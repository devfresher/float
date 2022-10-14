<?php
require "../includes/config.php";
require_once CLASS_DIR."Validator.php";

if(isset($_POST["logAccount"])) {
    $myFilters = [
        'username' => [
            'sanitizations' => 'string|trim',
            'validations' => 'required',
        ],
        'password' => [
            'sanitizations' => 'string|trim',
            'validations' => 'required|minlen:5',
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
        
        $getUser = $user->getUserByUsername($sanitizedInputData['username']);
        
        if($getUser) {
            $saved_password = $getUser->password;
            unset($getUser->password);
            if (password_verify($sanitizedInputData["password"], $saved_password)) {
                $_SESSION['userid'] = $getUser->id;
                header("Location: ".BASE_URL."dashboard");
                exit();  
            }
            else {
                $_SESSION['formErrorMessage'] = $language->invalid_credentials;
            }
        }
        else {
            $_SESSION['formErrorMessage'] = $language->username_noexist;
        }

        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();  
    }
}

else if(isset($_POST["createAccount"])) {
    $myFilters = [
        'fullname' => [
            'sanitizations' => 'string|trim',
            'validations' => 'required',
        ],
        'username' => [
            'sanitizations' => 'string|trim',
            'validations' => 'required',
        ],
        'email' => [
            'sanitizations' => 'email|trim',
            'validations' => 'required',
        ],
        'mobileno: Mobile Number' => [
            'sanitizations' => 'number|trim',
            'validations' => 'required|minlen:11|maxlen:11',
        ],
        'password' => [
            'sanitizations' => 'string|trim',
            'validations' => 'required|minlen:5',
        ],
        'passwordrep: Confirm Password' => [
            'sanitizations' => 'string|trim',
            'validations' => 'required|minlen:5',
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
        if($sanitizedInputData['password'] != $sanitizedInputData['passwordrep']) {
            $_SESSION['formErrorMessage'] = $language->password_not_match;
        }
        else if($user->getUserByUsername($sanitizedInputData['username']) !== false) {
            $_SESSION['formErrorMessage'] = $language->username_exist;
        }
        else {
            $userData = [
                "fullname" => $sanitizedInputData['fullname'],
                "username" => $sanitizedInputData['username'],
                "password" => $user->hashPassword($sanitizedInputData['password']),
                "mobile_no" => $sanitizedInputData['mobileno'],
                "email" => $sanitizedInputData['email'],
                "transact_pin" => "0000",
                "date_created" => date("Y-m-d H:i:s")
            ];
            
            // Let's create the account...
            $createMember = $user->createMember($userData);
    
            if($createMember) {
                $_SESSION['formSuccessMessage'] = $language->register_success;
            }
            else {
                $_SESSION['formErrorMessage'] = $language->unexpected_error;
            }
        }
    }
    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit();  
}
// print_r($_POST);

?>