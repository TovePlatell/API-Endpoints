<?php 
require_once "../../bootstrap.php";


if(isset($_GET["token"])){
    $checkSession = new Sessions($pdo);
    $checkToken = $checkSession->checkToken($_GET["token"]);

    $Array____checkToken = [
        "last_used" => "",
        "sessionuser_id" => "",
        "role" => "",
    ];

    checkTokenExpired($checkToken["last_used"]) ? $checkSession->updateSession($_GET["token"]) : false;
    //echo checkToken($tokenExpireDate) ? "Already Logged in" : false;

        if($checkToken["role"] == "admin"){

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
    echo "please log in";        
}

?>