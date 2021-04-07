<?php

require_once "../../bootstrap.php";

if (isset($_GET["token"])) {

    $checkSession = new Sessions($pdo);
    $checkToken = $checkSession->checkToken($_GET["token"]);
  
    if (empty($checkToken)) { // check if the token is in url or not

        $newMessage = new Statuses;
        $newMessage->setHttpStatusCode(409);
        $newMessage->addMessage('Not a valid token');
        $newMessage->send();
    }

    if (!empty($checkToken)) {
        checkTokenExpired($checkToken->last_used) ? $checkSession->updateSession($_GET["token"]) : false;

        /*
         * We begin with adding the values that can be change to false beacuse we only want the values you want to change to be valid.
         * ex: if there is a $_GET method in the url - ex. $_GET['user_name'] we will change $user_name to true and update the $query variable. If $user_name isset to true the query have an addition on user_name = :user_name and this value will be used in the SQL query*
         */
        
        $user_name = false;
        $user_password = false;
        $user_email = false;
        $query = "";

        if (isset($_GET["user_name"])) {
            $user_name = true;
            $query .= "user_name = :user_name,";
        }

        if (isset($_GET["user_password"])) {
            $user_password = true;
            $query .= "user_password = :user_password,";
        }

        if (isset($_GET["user_email"])) {
            $user_email = true;
            $query .= "user_email = :user_email,";
        }    
         // If all variables are false we would like to stop the process and that we do through following:
    
        if ($user_name == false && $user_password == false && $user_email == false) {

            $newMessage = new Statuses;
            $newMessage->setHttpStatusCode(409);
            $newMessage->addMessage('Nothing to update - empty fields');
            $newMessage->send();
        } elseif (($user_name === true && strlen($_GET["user_name"]) < 1) || ($user_password === true && strlen($_GET["user_password"]) < 1) || ($user_email === true && strlen($_GET["user_email"]) < 1)) {
            $array = [];

            // if the variable is true and the condition that the strings lenght is less than one the condition is true then push it to the created array that we writes out in our error message. 

            $user_name === true && strlen($_GET["user_name"]) < 1 ? array_push($array, "Username cannot be blank") : false;
            $user_password === true && strlen($_GET["user_password"]) < 1 ? array_push($array, "Password cannot be blank") : false;
            $user_email === true && strlen($_GET["user_email"]) < 1 ? array_push($array, "Email cannot be blank") : false;

            $newMessage = new Statuses;
            $newMessage->setHttpStatusCode(409);
            $newMessage->addMessage($array);
            $newMessage->send();

        } else {


            $query = rtrim($query, ",");  // takes away the last comma sign from the if statement

            $user_name === true ? $user_name = $_GET["user_name"] : false;

            $user_email === true ? $user_email = $_GET["user_email"] : false;

            $user_password === true ? $user_password = $_GET["user_password"] : false;

            if ($user_password === true) {
                $user_password = $_GET["user_password"];
                $user_password = password_hash($user_password, PASSWORD_DEFAULT);
            }


            $user = new Users($pdo);
            $trueOrFalse = $user->UpdateUser($query, $user_name, $user_password, $user_email, $checkToken->sessionuser_id);

            if ($trueOrFalse) {

                $newMessage = new Statuses;
                $newMessage->setHttpStatusCode(200);
                $newMessage->addMessage('Sucessfully updated');
                $newMessage->setData(["Username" => $user_name, "email" => $user_email]);
                $newMessage->send();
                exit;
            }
        }
    }
} else {
    $newMessage = new Statuses;
    $newMessage->setHttpStatusCode(401);
    $newMessage->addMessage('Please login');
    $newMessage->send();
}
