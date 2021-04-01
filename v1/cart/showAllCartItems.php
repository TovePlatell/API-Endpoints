<?php 
require_once "../../bootstrap.php";


// varje gång jag lägger till token tecken får jag error - jag kna skriva token= blank och de funkar.... 
//kan inte göra något om jag ej är inloggad



if(isset($_GET["token"])){
  

    $checkSession = new Sessions($pdo);
    $checkToken = $checkSession->checkToken($_GET["token"]);

    $Array____checkToken = [
        "last_used" => "",
        "sessionuser_id" => "",
        "role" => "",
    ];

    if(empty($checkToken)){
        $newMessage = new Statuses;
        $newMessage->setHttpStatusCode(409);
        $newMessage->addMessage('Not a valid token');
        $newMessage->send();
        exit;
} 

    checkTokenExpired($checkToken->last_used) ? $checkSession->updateSession($_GET["token"]) : false;  // std class är en array i en array
    //echo checkToken($tokenExpireDate) ? "Already Logged in" : false;

        if($checkToken->role == "admin"){   

            $newCartItem = new Carts($pdo);
            $allCartItems = $newCartItem->getCartItems();
            
            $newMessage = new Statuses;
            $newMessage->setHttpStatusCode(409);
            $newMessage->addMessage('');
            $newMessage->setData($allCartItems);
            $newMessage->send();

        } else {
            
            $newCartItem = new Carts($pdo);
            $allCartItems = $newCartItem->getCartItems($checkToken["sessionuser_id"]);
            
            $newMessage = new Statuses;
            $newMessage->setHttpStatusCode(409);
            $newMessage->addMessage('');
            $newMessage->setData($allCartItems);
            $newMessage->send();
            
        }
        
    } else {

        $newMessage = new Statuses;
        $newMessage->setHttpStatusCode(401);
        $newMessage->addMessage('Please login');
        $newMessage->send();
    }

?>