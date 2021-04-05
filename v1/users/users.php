<?php

require_once "../../bootstrap.php";

    if(isset($_REQUEST['REQUEST_METHOD']) === 'POST') {

        if(isset($_GET['user_name']) && isset($_GET['user_email']) && isset($_GET['user_password'])){

            $user_name = $_GET['user_name'];
            $user_password = $_GET['user_password'];
            $user_email= $_GET['user_email'];
            
            $user = new Users($pdo);
            print_r(json_encode($user->createUser($_GET['user_name'], $_GET['user_email'],$_GET['user_password'])));
    
            
        }

    } else if (isset($_REQUEST['REQUEST_METHOD']) === 'PATCH'){
        
    } else {
        $newMessage = new Statuses;
        $newMessage->setHttpStatusCode(401);
        $newMessage->addMessage('Not allowed');
        $newMessage->send();
    }
    