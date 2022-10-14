<?php
require "config.php";
// session_destroy();
// require_once MODEL_DIR.'Authorization.php';

// $auth = new Authorization($db);

if (PAGE_NAME == 'logout') {
    if ($user->isLoggedIn() === false) {
        $referer = BASE_URL.'login';
        header('Location: '.$referer);
        exit();
    }
} else {
    // $pageInfo = $auth->getPage(PAGE_NAME);

    if (PAGE_ACCESS_TYPE == 'guest') {
        if ($user->isLoggedIn() === true) {
            $utility->redirectToLandingPage();
        }
    }
    else {
        $userInfo = $user->loggedInUser();

        if($userInfo->transact_pin == '0000') {
            if(PAGE_SLUG != 'modifyTransactPIN') {
                header("location: ".BASE_URL."modifyTransactPIN");
            }
        }

        if (PAGE_ACCESS_TYPE == 'admin') {
            if ($user->isLoggedIn()) {
                // if($auth->hasPagePermission($user->currentUser->id, PAGE_NAME) == false){
                //     $utility->redirectToLandingPage();
                // } else {
                //     if($auth->isAuthorized(PAGE_NAME) === false) {
                //         $utility->showAuthorizeForm(PAGE_NAME);
                //     }
                // }
            } else {
                header('Location: '.BASE_URL.'login');
            }
        } 
        
        elseif (PAGE_ACCESS_TYPE == 'user') {
            if ($user->isLoggedIn() === false) {
                header('Location: '.BASE_URL.'login');
            }
        }

    }
}

require_once COMPONENT_DIR."header.php";