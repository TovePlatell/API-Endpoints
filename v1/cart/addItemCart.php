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
        exit;
} 

    if(!empty($checkToken)){
   checkTokenExpired($checkToken->last_used) ? $checkSession->updateSession($_GET["token"]) : false;
    
    //echo checkToken($tokenExpireDate) ? "Already Logged in" : false;

        if(isset($_GET["product_id"])){
            $newCartItem = new Carts($pdo);
            $checkProduct = $newCartItem->checkProduct($_GET["product_id"]);
            
            if($checkProduct){
             $trueOrFalse =  $newCartItem->addItemToCart($_GET["product_id"], $checkToken->sessionuser_id); // genom så hämtar från en std class..  hade vi [] så vill den hämta från en array
                 if($trueOrFalse){
                $array = [
                    "product" => $checkProduct->product_name,
                    "description" => $checkProduct->product_desc,
                    "price" => $checkProduct->price
                    /*"description" => $checkProduct["product_desc"],
                    "price" => $checkProduct["price"] */
                ];

                $newMessage = new Statuses;
                $newMessage->setHttpStatusCode(401);
                $newMessage->addMessage("Successfully added product to cart");
                $newMessage->setData($array);
                $newMessage->send();
                exit;

            } else{

                $newMessage = new Statuses;
                $newMessage->setHttpStatusCode(500);
                $newMessage->addMessage("Something went wrong");
                //$newMessage->setData($array);
                $newMessage->send();
                exit;

            }

            } else {
                $newMessage = new Statuses;
                $newMessage->setHttpStatusCode(401);
                $newMessage->addMessage('Product does not exist');
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

