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

    checkToken($checkToken["last_used"]) ? $checkSession->updateSession($_GET["token"]) : false;
    //echo checkToken($tokenExpireDate) ? "Already Logged in" : false;

        if($checkToken["role"] == "admin"){

            $newCartItem = new Carts($pdo);
            $allCartItems = $newCartItem->getCartItems();
            
            print_r($allCartItems);

        } else {
            
            $newCartItem = new Carts($pdo);
            $allCartItems = $newCartItem->getCartItems($checkToken["sessionuser_id"]);
            
            print_r($allCartItems);
            
        }
        
} else {
    echo "please log in";        
}

?>