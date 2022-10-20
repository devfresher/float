<?php
require_once "../includes/config.php";
require_once CLASS_DIR."Validator.php";
require MODEL_DIR."Ticket.php";

$ticket = new Ticket($db);

if($user->loggedInUser() === false) {
    session_destroy();
    header("location: ".BASE_URL."index");
    exit;
}
else {
    if(isset($_POST["createTicket"])) {
        $myFilters = [
            'subject' => [
                'sanitizations' => 'string|trim',
                'validations' => 'required',
            ],
            'categoryId' => [
                'sanitizations' => 'number|trim',
                'validations' => 'required',
            ],
            'message' => [
                'sanitizations' => 'string|trim',
                'validations' => 'required',
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

            $ticketData = [
                "ticket_reference" => $utility->randID('alphabetic', 12),
                "subject" => $sanitizedInputData['subject'],
                "creator_id" => $user->loggedInUser()->id,
                "category_id" => $sanitizedInputData['categoryId'],
                "report_user_id" => isset($sanitizedInputData['reportedId']) ? $sanitizedInputData['reportedId'] : NULL,
                "ticket_content" => addslashes($sanitizedInputData['message']),
                "date_created" => date("Y-m-d H:i:s")
            ];

            $createTicket = $ticket->createTicket($ticketData);

            if($createTicket) {

                // We need to disable the user they reported from float community...
                if(isset($sanitizedInputData['reportedId'])) {
                    $reportedUserFloatSettings = json_decode($user->getUserById($sanitizedInputData['reportedId'])->userMeta->float_settings);
                    
                    $userData = [
                        "user_meta" => [
                            "float_settings" => json_encode([
                                "float_amount" => $reportedUserFloatSettings->float_amount,
                                "sell_on_float" => true,
                                "suspend" => true,
                            ])
                        ]
                    ];

                    $user->updateUser($userData, $sanitizedInputData['reportedId']);
                }

                $_SESSION['successMessage'] = $language->created;
                $_SESSION['titleMessage'] = "Success";
            }
            else {
                $_SESSION['errorMessage'] = $language->unexpected_error;
                $_SESSION['titleMessage'] = "Error";
            }
            header("Location: ".BASE_URL."createTicket");
            exit();
        }
    }

    //ticket reply code...
    elseif (isset($_POST["addReply"])) {
        $myFilters = [
            'ticketReference' => [
                'sanitizations' => 'string|trim',
                'validations' => 'required',
            ],
            'replyTxt' => [
                'sanitizations' => 'string|trim',
                'validations' => 'required|',
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

            $ticketReplyData = [
                "user_id" => $user->loggedInUser()->id,
                "ticket_reference" => $sanitizedInputData['ticketReference'],
                "message" => addslashes($sanitizedInputData['replyTxt']),
                "date_created" => $utility->dateCreated()
            ];

            $createReplyTicket = $ticket->createReplyTicket($ticketReplyData);
            // print_r($ticketReplyData);

            if($createReplyTicket) {
                $_SESSION['successMessage'] = $language->created;
                $_SESSION['titleMessage'] = "Success";
            }
            else {
                $_SESSION['errorMessage'] = $language->unexpected_error;
                $_SESSION['titleMessage'] = "Error";
            }
            header("Location: ".$_SERVER['HTTP_REFERER']);  
            exit();
        }
    }
}
    
    // print_r($_POST);
    
    // print_r($user->loggedInUser());
    
// }


?>