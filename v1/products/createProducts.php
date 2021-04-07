<?php

require_once "../../bootstrap.php";

if(isset($_GET["token"])){
    $checkSession = new Sessions($pdo);
    $checkToken = $checkSession->checkToken($_GET["token"]);  // check that the token is set
 

    if(empty($checkToken)){                     // if not print out error message
        $newMessage = new Statuses;
            $newMessage->setHttpStatusCode(409);
            $newMessage->addMessage('Not a valid token');
            $newMessage->send();
    }
    
    if(!empty($checkToken)) {           // if not empty check when token is lastused if true update token
        checkTokenExpired($checkToken->last_used) ? $checkSession->updateSession($_GET["token"]) : false; // call a method, access a property on the object of a class

        if($checkToken->role == "admin"){  // check wheather you have the permission to create if you´re an admin

if(isset($_GET['product_name']) && isset($_GET['product_desc']) && isset($_GET['price'])){

    $product_name = $_GET['product_name'];
    $product_desc = $_GET['product_desc'];
    $product_price = $_GET['price'];


                          
    $product = new products($pdo);
    $trueOrFalse = $product->CreateProducts($product_name, $product_desc, $product_price);  // return statement return true or false

    $newMessage = new Statuses;
    $newMessage->setHttpStatusCode(201);
    $newMessage->addMessage('Product created');
    $newMessage->setData(["Productname" => $product_name,"Productdesc" => $product_desc, "price" => $product_price]); // assign values to the keys of an array
    $newMessage->send();
    exit;

}else{

    $array = [];

        
        !isset($_GET['product_name']) || strlen($_GET["product_name"]) < 1 ? array_push($array, 'product name cannot be empty') : false;
        !isset($_GET['product_desc']) || strlen($_GET["product_desc"]) < 1 ? array_push($array, 'prpduct email cannot be empty') : false;
        !isset($_GET['price']) || strlen($_GET["price"]) < 1 ? array_push($array, 'price cannot be empty') : false;



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
        $newMessage->setHttpStatusCode(401);
        $newMessage->addMessage('Please login');
        $newMessage->send();
}

    
    

?>

