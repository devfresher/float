<?php
require "../includes/config.php";
require_once CLASS_DIR."Validator.php";

if(isset($_POST["shareFloat"])) {
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
        $receiver = $user->getUserByMobileNo($sanitizedInputData['userPhone']);
        $receiverFloatSettings = json_decode($receiver->userMeta->float_settings);

        $sender = $user->loggedInUser();
        $senderFloatSettings = json_decode($sender->userMeta->float_settings);

        if (!$receiver) {
            $_SESSION['errorMessage'] = $language->user_noexist;
        } else {
            if ($amount > $senderFloatSettings->float_amount) {
                $_SESSION['errorMessage'] = $language->insufficient_fund;
            } else {
                $receiverBalance = $receiver->userMeta->wallets->float_wallet;
                $newReceiverBalance = $receiverBalance + $amount;

                $senderBalance = $senderFloatSettings->float_amount;
                $newSenderBalance = $senderBalance - $amount;

                if ($newSenderBalance > 0) {
                    $newSenderFloatSettings = json_encode([
                        "float_amount" => $newSenderBalance,
                        "sell_on_float" => true
                    ]);

                    $updateSender = $user->updateUser([
                        "user_meta" => [
                            "float_wallet" => $newSenderBalance,
                            "float_settings" => $newSenderFloatSettings
                        ]
                    ], $receiver->id);
                } else {
                    $user->delete2("Delete from user_meta where `key` = 'float_settings' && `user_id` = $sender->id");
                }

                $updateReceiver = $user->updateUser([
                    "user_meta" => [
                        "float_wallet" => $newReceiverBalance,
                    ]
                ], $receiver->id);

                $_SESSION['successMessage'] = $language->txn_completed;
            }
        }

        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
    }
}