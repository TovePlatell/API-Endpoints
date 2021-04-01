<?php

require_once "../../bootstrap.php"; 

if(isset($_GET["token"])){
    $checkSession = new Sessions($pdo);
    $checkToken = $checkSession->checkToken($_GET["token"]);

    if(empty($checkToken)){
            $newMessage = new Statuses;
            $newMessage->setHttpStatusCode(409);
            $newMessage->addMessage('Not a valid token');
            $newMessage->send();
    }
    
    if(!empty($checkToken)) {
        checkTokenExpired($checkToken->last_used) ? $checkSession->updateSession($_GET["token"]) : false;

        if($checkToken->role == "admin"){

        if(isset($_GET["product_id"])){
            
            $product_id = $_GET["product_id"];
            $product_name = false;
            $product_desc = false;
            $product_price = false;
            $changeProduct = "";
            
            if(isset($_GET["product_name"])){
                $product_name = true;
                $changeProduct .= "product_name = :product_name,";
            }
                
                if(isset($_GET["product_desc"])){
                    $product_desc= true;
                    $changeProduct .= "product_desc = :product_desc,";
                }
                
                if(isset($_GET["price"])){
                    $product_price = true;
                    $changeProduct .= "product_price = :product_price,";
                }
/*
             * Om alla variabler är false så vill vi stoppa processen och det gör vi genom följande funktion
             */
            if($product_name== false && $product_desc== false && $product_price == false) {

                $newMessage = new Statuses;
                $newMessage->setHttpStatusCode(404);
                $newMessage->addMessage('Nothing to update!');
                $newMessage->send();

                
            } elseif (($product_name === true && strlen($_GET["product_name"]) < 1) || ($product_desc === true && strlen($_GET["product_desc"]) < 1) || ($product_price === true && strlen($_GET["price"]) < 1)) {

                $array2 = [];
                $product_name === true && strlen($_GET["product_name"]) < 1 ? array_push($array2, "productname cannot be blank") : false;
                $product_desc === true && strlen($_GET["product_desc"]) < 1 ? array_push($array2, "product desc cannot be blank") : false;
                $product_price === true && strlen($_GET["price"]) < 1 ? array_push($array2, "price cannot be blank") : false;

                $newMessage = new Statuses;
                $newMessage->setHttpStatusCode(409);
                $newMessage->addMessage($array2);
                $newMessage->send();
            } else {


                $changeProduct = rtrim($changeProduct, ",");
                
                $product_name === true ? $product_name = $_GET["product_name"] : false;  
                
                $product_desc === true ? $product_desc = $_GET["product_desc"] : false;  
                
                $product_price === true ? $product_price= $_GET["price"] : false;  
                
                
                $product = new Products($pdo);
                $product->UpdateProduct($changeProduct, $product_name, $product_desc, $product_price, $product_id);

                $newMessage = new Statuses;
                $newMessage->setHttpStatusCode(200);
                $newMessage->addMessage('Sucessfully updated products');
                $newMessage->setData(["productname" => $product_name, "productdesc" => $product_desc, "price" => $product_price]);
                $newMessage->send();
                exit;
                
            }

        } else{

            $newMessage = new Statuses;
            $newMessage->setHttpStatusCode(405);
            $newMessage->addMessage('You have to specify product_id');
            $newMessage->send();

        }

} else {

    $newMessage = new Statuses;
    $newMessage->setHttpStatusCode(405);
    $newMessage->addMessage('You´re not admin!');
    $newMessage->send();

}

}

}else {

    $newMessage = new Statuses;
            $newMessage->setHttpStatusCode(409);
            $newMessage->addMessage('Please log in!');
            $newMessage->send();
}