<?php

require_once "../../bootstrap.php"; 


if(isset($_GET["token"])){
    $checkSession = new Sessions($pdo);
    $checkToken = $checkSession->checkToken($_GET["token"]);

   $Array____checkToken = [
        "last_used" => "",
        "sessionuser_id" => "",
    ];

    if(empty($checkToken)){
        $newMessage = new Statuses;
        $newMessage->setHttpStatusCode(409);
        $newMessage->addMessage('Not a valid token');
        $newMessage->send();
} 

    //checkTokenExpired($checkToken["last_used"]) ? $checkSession->updateSession($_GET["token"]) : false;
    //echo checkToken($tokenExpireDate) ? "Already Logged in" : false;

        if(isset($_GET["product_id"])){
            $newCartItem = new Carts($pdo);
            $trueOrFalse = $newCartItem->deleteItemSetInCart($_GET["product_id"], $checkToken->sessionuser_id);

            if($trueOrFalse){
                $newMessage = new Statuses;
                $newMessage->setHttpStatusCode(200);
                $newMessage->addMessage('Item has sucessfully been deleted from cart');
                $newMessage->send();

            } else {

                $newMessage = new Statuses;
                $newMessage->setHttpStatusCode(409);
                $newMessage->addMessage("The user does not have this product in the cart");
                $newMessage->send();
            }
        } 
        
         if(isset($_GET["cart_id"])){
            $newCartItem = new Carts($pdo);
            $trueOrFalse = $newCartItem->deleteItemInCart($_GET["cart_id"], $checkToken->sessionuser_id);

            if($trueOrFalse){
                $newMessage = new Statuses;
                $newMessage->setHttpStatusCode(200);
                $newMessage->addMessage('Item has sucessfully been deleted from cart');
                $newMessage->send();

            } else {

                $newMessage = new Statuses;
                $newMessage->setHttpStatusCode(409);
                $newMessage->addMessage("The user does not have this product in the cart");
                $newMessage->send();
            } 
        } 
        
     } else {
    $newMessage = new Statuses;
    $newMessage->setHttpStatusCode(401);
    $newMessage->addMessage('Please login');
    $newMessage->send();
}









?>