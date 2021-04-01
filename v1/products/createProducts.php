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

if(isset($_GET['product_name']) && isset($_GET['product_desc']) && isset($_GET['price'])){

    $product_name = $_GET['product_name'];
    $product_desc = $_GET['product_desc'];
    $product_price = $_GET['price'];

    
   // echo "new updated products $product_name";
                          
    $product = new products($pdo);
    $trueOrFalse = $product->CreateProducts($product_name, $product_desc, $product_price);

    $newMessage = new Statuses;
    $newMessage->setHttpStatusCode(201);
    $newMessage->addMessage('Product created');
    $newMessage->setData(["Productname" => $product_name,"Productdesc" => $product_desc, "price" => $product_price]);
    $newMessage->send();
    exit;

}else{

    $array = [];

        !isset($_GET['product_name']) || strlen($_GET["product_name"]) < 1 ? array_push($array, 'pname cannot be empty') : false;
        !isset($_GET['product_desc']) || strlen($_GET["product_desc"]) < 1 ? array_push($array, 'pemail cannot be empty') : false;
        !isset($_GET['price']) || strlen($_GET["price"]) < 1 ? array_push($array, 'pr cannot be empty') : false;



        $newMessage = new Statuses;
        $newMessage->setHttpStatusCode(409);
        $newMessage->addMessage($array);
        $newMessage->send();

}
    }else{

        $newMessage = new Statuses;
        $newMessage->setHttpStatusCode(405);
        $newMessage->addMessage('Method Not Allowed');
        $newMessage->send();
    }

}
} else {
    $newMessage = new Statuses;
        $newMessage->setHttpStatusCode(409);
        $newMessage->addMessage('Please login');
        $newMessage->send();
}

    
    

?>

