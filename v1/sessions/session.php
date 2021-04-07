<?php

require_once "../../bootstrap.php";

if (isset($_GET["token"])) {
    $checkSession = new Sessions($pdo);
    $checkToken = $checkSession->checkToken($_GET["token"]);

    checkTokenExpired($checkToken["last_used"]) ? $checkSession->updateSession($_GET["token"]) : false;
    echo !checkTokenExpired($checkToken) ? "Already logged in" : false;
    
}

if (!isset($_GET["token"])) {

    if (isset($_GET['user_name']) && isset($_GET['user_password'])) {

         // Get method - gets the value from URL
        $user_name = $_GET["user_name"];
        $user_password = $_GET["user_password"];

        // Starts the session class
        $newSession = new Sessions($pdo);

        /*  we return the value from checkUser function and store it in Userinfo --> and it will return 1 row or nothing. If it get´s returned --> array 
        */
        $userInfo = $newSession->checkUser($user_name);
     // Because of $userInfo has a return on a fetch that returns an array, $userInfo will update to an arrayEftersom att $userInfo har en 
     
     /*  ex... $NyaUserInfo = [
            "user_name" => "tove",
            "user_password" => "hashed",
            "user_email" => "tove@tove.se"
        ];*/

        // If $userInfo is empty -> echo 
        if (empty($userInfo)) { //echo empty($userInfo) //? 
            $newMessage = new Statuses;
            $newMessage->setHttpStatusCode(404);
            $newMessage->addMessage('User does not exists');
            $newMessage->send();
        }
        //  : false;

        // Stores the values from userInfo into seperates variables
        if (!empty($userInfo)) {
            $checkUser_name = $userInfo["user_name"];
            $checkUser_password = $userInfo["user_password"];
            $checkUser_id = $userInfo["user_id"];

            // compare user_password that the user is typing with the hashed password from the databaseJämför $user_pasword
            if (password_verify($user_password, $checkUser_password)) {
            
             // creates binary bytes - > converts to hexadecimal - > that converts to letters
            
                $token = base64_encode(bin2hex(openssl_random_pseudo_bytes(24)) . time());
                $token_expire = 3600; 

                $newSession->createSession($checkUser_id, $token, $token_expire);


                $newMessage = new Statuses;
                $newMessage->setHttpStatusCode(202);
                $newMessage->addMessage('Logged in');
                $newMessage->setData($token);  
                $newMessage->send();
            } else {

                $newMessage = new Statuses;
                $newMessage->setHttpStatusCode(409);
                $newMessage->addMessage('Username or password does not match');
                $newMessage->send();
            }
        }
    } else {
        $array = [];
           // check whether username, password isset, else error message 
        !isset($_GET['user_name']) ? array_push($array, "Username cannot be empty") : false;
        !isset($_GET['user_password']) ? array_push($array, "Password cannot be empty") : false;

        $newMessage = new Statuses;
        $newMessage->setHttpStatusCode(409);
        $newMessage->addMessage($array);
        $newMessage->send();

        
    }
}
