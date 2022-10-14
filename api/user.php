<?php
require "../includes/config.php";
require_once CLASS_DIR."Validator.php";

header('Content-Type: application/json; charset=utf-8');
if($user->loggedInUser() === false) {
    session_destroy();
    header("location: ".BASE_URL."index");
    exit;
}
else {
    if(isset($_GET["phone"])) {
        $myFilters = [
            'phone' => [
                'sanitizations' => 'string|trim',
                'validations' => 'required|minLen:11|maxLen:11',
            ]
        ];

        $validator = new Validator($myFilters);
        $validationResults = $validator->run($_GET);

        if ($validationResults === FALSE) {
            $validationErrors = $validator->getValidationErrors();
            foreach ($validationErrors as $error) {
                $response['error'] = $error;
            }

            echo json_encode($response, JSON_PRETTY_PRINT);
            exit;
        }
        else {
            $sanitizedInputData = $validationResults;
            
            $getUser = $user->getUserByMobileNo($sanitizedInputData['phone']);
            if($getUser) {
                unset($getUser->password);
                $response['data'] = $getUser;
            }
            else {
                $response['error'] = "User not found";
            } 

            echo json_encode($response, JSON_PRETTY_PRINT);
            exit;
        }
    }
}