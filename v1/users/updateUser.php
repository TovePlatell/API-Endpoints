<?php

require_once "../../bootstrap.php";

if (isset($_GET["token"])) {

    $checkSession = new Sessions($pdo);
    $checkToken = $checkSession->checkToken($_GET["token"]);
    // $Array____checkToken = [
    // "last_used" => "",
    //  "sessionuser_id" => "",
    //  ];

    
    if (empty($checkToken)) {

        $newMessage = new Statuses;
        $newMessage->setHttpStatusCode(409);
        $newMessage->addMessage('Not a valid token');
        $newMessage->send();
    }

    if (!empty($checkToken)) {
        checkTokenExpired($checkToken->last_used) ? $checkSession->updateSession($_GET["token"]) : false;

        /*
         * Vi börjar med att sätta in värdena som kan ändras till false eftersom att vi bara vill
         * att värden som man vill ändra på ska gälla
         * Ex: om det finns en $_GET metod i URL:en på t.ex $_GET["user_name"] så ändrar vi
         * $user_name till true och uppdaterar sedan $query variabeln till något slags query tillägg.
         * Om $user_name är satt till "true" så kommer queryn att ha ett tillägg på user_name = :user_name.
         * Detta värde använder vi till SQL frågan
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

        /*
             * Om alla variabler är false så vill vi stoppa processen och det gör vi genom följande funktion
             */
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
    $newMessage->setHttpStatusCode(409);
    $newMessage->addMessage('Please login');
    $newMessage->send();
}
