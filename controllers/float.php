<?php
require "../includes/config.php";
require_once CLASS_DIR."Validator.php";
require_once MODEL_DIR."Floats.php";
$floats = new Floats($db);

if($user->loggedInUser() === false) {
    session_destroy();
    header("location: ".BASE_URL."index");
    exit;
}
else {
    if(isset($_POST["updateFloatSettings"])) {
        $myFilters = [
            'sell_on_float' => [
                'sanitizations' => 'string|trim',
                'validations' => 'required',
            ],
            'amount' => [
                'sanitizations' => 'float',
                'validations' => 'number|required',
            ]
        ];

        $validator = new Validator($myFilters);
        $validationResults = $validator->run($_POST);

        if ($validationResults === FALSE) {
            $validationErrors = $validator->getValidationErrors();
            foreach ($validationErrors as $error) {
                $_SESSION['formErrorMessage'][] = $error;
            }
            header("Location: ".$_SERVER['HTTP_REFERER']);
            exit();   
        }
        else {
            $sanitizedInputData = $validationResults;

            $amount = $sanitizedInputData['amount'];
            $sellOnFLoat = isset($sanitizedInputData['sell_on_float']) ? true:false;

            $floatBalance = $user->loggedInUser()->wallets->float_wallet;
            if ($floatBalance < $amount) {
                $_SESSION['errorMessage'] = "Insufficient Float Balance";
                $_SESSION['titleMessage'] = "Error";
            } else {

                //Create float history data here...
                $floatData = [
                    "userid" => $user->loggedInUser()->id,
                    "old_balance" => (float) $floatBalance,
                    "amount" => (float) $amount,
                    "new_balance" => (float) ($floatBalance - $amount),
                    "operation" => 0,
                    "status" => 1,
                    "date_created" => $utility->dateCreated()
                ];

                $floatBalance -= $amount;
                
                $userData = [
                    "user_meta" => [
                        "float_settings" => json_encode([
                            "float_amount" =>$amount,
                            "sell_on_float" =>$sellOnFLoat
                        ]),
                        "float_wallet" => $floatBalance
                    ]
                ];

                $updateUser = $user->updateUser($userData, $user->loggedInUser()->id);
                
                if($updateUser) {
                    
                    if($sellOnFLoat) { $floats->createFloat($floatData); }

                    $_SESSION['successMessage'] = $language->updated;
                    $_SESSION['titleMessage'] = "Success";
                }
                else {
                    $_SESSION['errorMessage'] = $language->request_failed;
                    $_SESSION['titleMessage'] = "Error";
                }
            }
            
        }

        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
    }

    else if(isset($_POST["shareFloat"])) {
        $myFilters = [
            'amount' => [
                'sanitizations' => 'float',
                'validations' => 'required|number',
            ],
            "userPhone: Receiver's Phone Number" => [
                'sanitizations' => 'string|trim',
                'validations' => 'required|minlen:11|maxlen:11',
            ]
        ];

        $validator = new Validator($myFilters);
        $validationResults = $validator->run($_POST);

        if ($validationResults === FALSE) {
            $validationErrors = $validator->getValidationErrors();
            foreach ($validationErrors as $error) {
                $_SESSION['errorMessage'][] = $error;
            }
            header("Location: ".$_SERVER['HTTP_REFERER']);  
            exit();   
        }
        else {
            $sanitizedInputData = $validationResults;

            $amount = $sanitizedInputData['amount'];
            $transactPin = $sanitizedInputData['pin'];
            $receiver = $user->getUserByMobileNo($sanitizedInputData['userPhone']);
            // $receiverFloatSettings = json_decode($receiver->userMeta->float_settings); //Not selling float...

            $sender = $user->loggedInUser();
            $senderFloatSettings = json_decode($sender->userMeta->float_settings);
            
            $_SESSION['titleMessage'] = "Error";

            if ($transactPin == '0000') {
                $_SESSION['errorMessage'] = $language->defaulttransactPIN;
            } else if ($sender->transact_pin != $transactPin) {
                $_SESSION['errorMessage'] = $language->incorrect_pin;
            } else if (!$receiver) {
                $_SESSION['errorMessage'] = $language->user_noexist;
            } else {
                if ($amount > $senderFloatSettings->float_amount) {
                    $_SESSION['errorMessage'] = $language->insufficient_fund;
                } else {
                    $receiverBalance = $receiver->userMeta->wallets->float_wallet;
                    $newReceiverBalance = $receiverBalance + $amount;

                    $senderBalance = $senderFloatSettings->float_amount;
                    $newSenderBalance = $senderBalance - $amount;

                    $senderFloatRemark = json_encode([
                        "old_bal" => $senderBalance,
                        "amount" => $amount,
                        "new_bal" => $newSenderBalance
                    ]);

                    $receiverFloatRemark = json_encode([
                        "old_bal" => $receiverBalance,
                        "amount" => $amount,
                        "new_bal" => $newReceiverBalance
                    ]);

                    $isUpdateSender = false;

                    if ($newSenderBalance > 0) {
                        $newSenderFloatSettings = json_encode([
                            "float_amount" => $newSenderBalance,
                            "sell_on_float" => true
                        ]);

                        //Update sender sell float balance...
                        $updateSender = $user->updateUser([
                            "user_meta" => [
                                "float_settings" => $newSenderFloatSettings
                            ]
                        ], $sender->id);

                        if($updateSender) {
                            $isUpdateSender = true;
                        }

                    } else {
                        $updateSender = $user->delete2("Delete from user_meta where `key` = 'float_settings' && `user_id` = $sender->id");

                        if($updateSender) {
                            $isUpdateSender = true;
                        }
                    }

                    if($updateSender) {
                        
                        $updateReceiver = $user->updateUser([
                            "user_meta" => [
                                "float_wallet" => $newReceiverBalance,
                            ]
                        ], $receiver->id);

                        if($updateReceiver) {

                            $senderHistory = [
                                "userid" => $sender->id,
                                "old_balance" => (float) ($sender->userMeta->wallets->float_wallet), //Exact balance in main float wallet
                                "amount" => (float) (0),
                                "new_balance" => (float) ($sender->userMeta->wallets->float_wallet), ///Exact balance in main float wallet
                                "receiver_id" => $receiver->id,
                                "operation" => 1,
                                "sellfloat_remark" => $senderFloatRemark,
                                "status" => 1,
                                "date_created" => $utility->dateCreated()
                            ];
        
                            $receiverHistory = [
                                "userid" => $receiver->id,
                                "old_balance" => (float) ($receiverBalance), //Exact balance in main float wallet
                                "amount" => (float) ($amount),
                                "new_balance" => (float) ($newReceiverBalance), //new balance in main float balance
                                "sender_id" => $sender->id,
                                "operation" => 1,
                                "sellfloat_remark" => $receiverFloatRemark,
                                "status" => 1,
                                "date_created" => $utility->dateCreated()
                            ];

                            $floats->createFloat($senderHistory);
                            $floats->createFloat($receiverHistory);

                            $_SESSION['titleMessage'] = "Success";
                            $_SESSION['successMessage'] = $language->txn_completed;
                        }
                        else {
                            $_SESSION['successMessage'] = $language->unexpected_error;
                        }
                    }
                    else {
                        $_SESSION['successMessage'] = $language->unexpected_error;
                    }
                }
            }
            header("Location: ".$_SERVER['HTTP_REFERER']);
            exit();
        }
    }
}
    
// print_r($_POST);