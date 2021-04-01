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

   checkTokenExpired($checkToken->last_used) ? $checkSession->updateSession($_GET["token"]) : false;

   // if(!empty($checkToken)) {
   //checkTokenExpired($checkToken["last_used"]) ? $checkSession->updateSession($_GET["token"]) : false;

   if (!empty($_GET['user_id'])) {
      $user = new Users($pdo);
      $trueOrFalse = $user->DeleteUser($_GET["user_id"]);


      if ($trueOrFalse) {

         $newMessage = new Statuses;
         $newMessage->setHttpStatusCode(200);
         $newMessage->addMessage('User is removed');
         $newMessage->send();
      } else {

         $newMessage = new Statuses;
         $newMessage->setHttpStatusCode(404);
         $newMessage->addMessage('Something went wrong trying to remove user');
         $newMessage->send();
      }
   }
} else {
   $newMessage = new Statuses;
   $newMessage->setHttpStatusCode(409);
   $newMessage->addMessage('Please login');
   $newMessage->send();
}
