<?php
   require_once "../../bootstrap.php";  

  // denna funktion funkar bra med alla meddelanden

  
    if(isset($_GET['user_name']) && isset($_GET['user_email']) && isset($_GET['user_password'])){  

        $user_name = trim($_GET['user_name']);   // removes whitespaces
        $user_password = $_GET['user_password'];
        $user_email= $_GET['user_email'];

        $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);   //creates a new hashed password
        
        $user = new Users($pdo);  
        $trueOrFalse = $user->createUser($_GET['user_name'], $_GET['user_email'],$hashed_password);

        if($trueOrFalse){
            $newMessage = new Statuses;
            $newMessage->setHttpStatusCode(409);
            $newMessage->addMessage('User already exists!');
            $newMessage->send();

        } else {

            $array3 = [
                "user_name" => $user_name, 
                "user_email" => $user_email
            ];

            $newMessage = new Statuses;
            $newMessage->setHttpStatusCode(201);
            $newMessage->addMessage('User created');
            $newMessage->setData($array3);
            $newMessage->send();
        }

        
    } else {

        $array = [];

        !isset($_GET['user_name']) || strlen($_GET["user_name"]) < 1 ? array_push($array, 'Username cannot be empty') : false;
        !isset($_GET['user_email']) || strlen($_GET["user_email"]) < 1 ? array_push($array, 'Useremail cannot be empty') : false;
        !isset($_GET['user_password']) || strlen($_GET["user_password"]) < 1 ? array_push($array, 'Userpassword cannot be empty') : false;


        $newMessage = new Statuses;
        $newMessage->setHttpStatusCode(409);
        $newMessage->addMessage($array);
        $newMessage->send();
    }
