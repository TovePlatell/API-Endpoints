<?php 
require_once "../../bootstrap.php";


if(isset($_GET["token"])){

    $checkSession = new Sessions($pdo);
    $checkToken = $checkSession->checkToken($_GET["token"]); // 


    if(empty($checkToken)){
        $newMessage = new Statuses;
        $newMessage->setHttpStatusCode(409);
        $newMessage->addMessage('Not a valid token');
        $newMessage->send();
        exit;
} 

    checkTokenExpired($checkToken->last_used) ? $checkSession->updateSession($_GET["token"]) : false;  // std class is an array inside an array 
   

        if($checkToken->role == "admin"){   // check whether you´re admin or not

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