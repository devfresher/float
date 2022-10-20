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
    if(isset($_POST["fundWallet"])) {
        $myFilters = [
            'amount' => [
                'sanitizations' => 'float|trim',
                'validations' => 'required|number',
            ],
            'payType' => [
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
        }
    }

    elseif ($_POST["shareMoney"]) {
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
                $_SESSION['formErrorMessage'][] = $error;
            }
            header("Location: ".$_SERVER['HTTP_REFERER']);
            exit();   
        }
        else {
            $sanitizedInputData = $validationResults;

            $amount = $sanitizedInputData['amount'];
            $transactPin = $sanitizedInputData['pin'];

            $receiver = $user->getUserByMobileNo($sanitizedInputData['userPhone']);
            $sender = $user->loggedInUser();
            
            $_SESSION['titleMessage'] = "Error";

            if ($sender->transact_pin != $transactPin) {
                $_SESSION['errorMessage'] = $language->incorrect_pin;
            } else if (!$receiver) {
                $_SESSION['errorMessage'] = $language->user_noexist;
            } else {

                if ($amount > $sender->userMeta->wallets->main_wallet) {
                    $_SESSION['errorMessage'] = $language->insufficient_fund;
                } else {
                    $receiverBalance = $receiver->userMeta->wallets->main_wallet;
                    $newReceiverBalance = $receiverBalance + $amount;

                    $senderBalance = $sender->userMeta->wallets->main_wallet;
                    $newReceiverBalance = $senderBalance + $amount;

                    var_dump($sanitizedInputData);die;
                }
            }
        }
    }
}