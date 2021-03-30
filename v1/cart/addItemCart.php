<?php
require_once "../../bootstrap.php";

if(isset($_GET["token"])){
    $checkSession = new Sessions($pdo);
    $checkToken = $checkSession->checkToken($_GET["token"]);

    $Array____checkToken = [
        "last_used" => "",
        "sessionuser_id" => "",
    ];

    checkTokenExpired($checkToken["last_used"]) ? $checkSession->updateSession($_GET["token"]) : false;
    //echo checkToken($tokenExpireDate) ? "Already Logged in" : false;

        if(isset($_GET["product_id"])){
            $newCartItem = new Carts($pdo);
            $newCartItem->addItemToCart($_GET["product_id"], $checkToken["sessionuser_id"]);
        } 
        
} else {
            echo "please log in";
}

