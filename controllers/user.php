<?php
require_once "../includes/config.php";
require_once CLASS_DIR."Validator.php";

if($user->loggedInUser() === false) {
    session_destroy();
    header("location: ".BASE_URL."index");
    exit;
}
else {
    if(isset($_POST["updateProfile"])) {
        $myFilters = [
            'email: Email Address' => [
                'sanitizations' => 'email|trim',
                'validations' => 'required',
            ],
            'mobile_no: Mobile Number' => [
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
            $mobileNo = $sanitizedInputData['mobile_no'];
            $email = $sanitizedInputData['email'];
            $checkMobile = $user->getUserByMobileNo($mobileNo);
            
            if($checkMobile !== false AND $checkMobile->id != $user->loggedInUser()->id) {
                $_SESSION['formErrorMessage'] = $language->mobile_exist;
            }
            else {
                $userData = [
                    "mobile_no" => $mobileNo,
                    "email" => $email
                ];

                $updateUser = $user->updateUser($userData, $user->loggedInUser()->id);
                
                if($updateUser) {
                    $_SESSION['successMessage'] = $language->updated;
                    $_SESSION['titleMessage'] = "Success";
                }
                else {
                    $_SESSION['errorMessage'] = $language->request_failed;
                    $_SESSION['titleMessage'] = "Error";
                }
            }
            header("Location: ".$_SERVER['HTTP_REFERER']);
            exit();
        }        
    }

    else if(isset($_POST["updateBankInfo"])) {
        $myFilters = [
            'bankName' => [
                'sanitizations' => 'string|trim',
                'validations' => 'required',
            ],
            'accountName' => [
                'sanitizations' => 'string|trim',
                'validations' => 'required',
            ],
            'accountNo: Account Number' => [
                'sanitizations' => 'string|trim',
                'validations' => 'required|minlen:10|maxlen:10',
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

            $accountNo = $sanitizedInputData['accountNo'];

            // $accountNo = '274332910';

            // Searching for account number in json string
            $searchAza = $db->getRecFrmQry("SELECT * FROM users_meta WHERE `value` RLIKE '\"accountNo\":\"[[:<:]]".$accountNo."[[:>:]]\"'");

            if(count($searchAza) > 0) {
                $_SESSION['errorMessage'] = $language->accountno_exist;
                $_SESSION['titleMessage'] = "Error";
            }
            else {
                
                $userData = [
                    "email" => $user->loggedInUser()->email,
                    "user_meta" => [
                        "bankInfo" => json_encode([
                            "bankName" => $sanitizedInputData['bankName'],
                            "accountName" => $sanitizedInputData['accountName'],
                            "accountNo" => $sanitizedInputData['accountNo']
                        ])
                    ]
                ];

                $updateUser = $user->updateUser($userData, $user->loggedInUser()->id);

                if($updateUser) {
                    $_SESSION['successMessage'] = $language->updated;
                    $_SESSION['titleMessage'] = "Success";
                }
                else {
                    $_SESSION['errorMessage'] = $language->request_failed;
                    $_SESSION['titleMessage'] = "Error";
                }
            }
            header("Location: ".$_SERVER['HTTP_REFERER']);
            exit();
        }
    }
    else if(isset($_POST['updatePIN'])) {
        $myFilters = [
            'currentPin' => [
                'sanitizations' => 'number|trim',
                'validations' => 'required',
            ],
            'newPin' => [
                'sanitizations' => 'string|trim',
                'validations' => 'required|minlen:4|maxlen:4',
            ],
            'retypenewPin' => [
                'sanitizations' => 'string|trim',
                'validations' => 'required|minlen:4|maxlen:4',
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

            $transact_pin = $user->loggedInUser()->transact_pin;
            $currentPin = $sanitizedInputData['currentPin'];
            $newPin = $sanitizedInputData['newPin'];
            $retypenewPin = $sanitizedInputData['retypenewPin'];

            $_SESSION['titleMessage'] = 'Error';

            if($currentPin != $transact_pin) {
                $_SESSION['errorMessage'] = $language->curr_transactpin_not_match;
            }
            else if($newPin == $currentPin) {
                $_SESSION['errorMessage'] = $language->curr_newtransactpin_match;
            }
            else if($newPin != $retypenewPin) {
                $_SESSION['errorMessage'] = $language->password_not_match;
            }
            else if($newPin == '0000') {
                $_SESSION['errorMessage'] = $language->defaulttransactPIN;
            }
            else {
                $userData = [
                    "transact_pin" => $newPin
                ];

                $updatePin = $user->updateUser($userData, $user->loggedInUser()->id);

                if($updatePin) {
                    $_SESSION['successMessage'] = $language->updated;
                    $_SESSION['titleMessage'] = 'Success';
                }
                else {
                    $_SESSION['errorMessage'] = $language->request_failed;
                }
            }
            header("Location: ".$_SERVER['HTTP_REFERER']);
            exit();
        }
    }
    
    // print_r($_POST);
    
    // print_r($user->loggedInUser());
    
}


?>