<?php
require_once "../includes/config.php";
require_once CLASS_DIR."Validator.php";

if($user->loggedInUser() === false) {
    session_destroy();
    header("location: ".BASE_URL."index");
    exit;
}
else {

}
    echo "<pre>";
        print_r($_POST);
        
        print_r($user->loggedInUser());
    echo "</pre>";
    

?>