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
                "categoryId" => $sanitizedInputData['categoryId'],
                "report_user_id" => isset($sanitizedInputData['reportedId']) ? $sanitizedInputData['reportedId'] : NULL,
                "ticket_content" => addslashes($sanitizedInputData['message']),
                "date_created" => date("Y-m-d H:i:s")
            ];

            // $createTicket = $ticket->createTicket($ticketData);

        }        
    }
}
    
    print_r($_POST);
    
    // print_r($user->loggedInUser());
    
// }


?>