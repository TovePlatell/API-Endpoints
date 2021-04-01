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

if(!empty($_GET['product_id'])) {
    
    $product = new Products($pdo);
    $trueOrfalse = $product->DeleteProduct($_GET["product_id"]);

   if($trueOrfalse){

    $newMessage = new Statuses;
    $newMessage->setHttpStatusCode(200);
    $newMessage->addMessage('Product is removed');
    $newMessage->send();  

}else{

    $newMessage = new Statuses;
    $newMessage->setHttpStatusCode(404);
    $newMessage->addMessage('Something went wrong trying to remove product');
    $newMessage->send(); 
   }

}

} else{

    $newMessage = new Statuses;
    $newMessage->setHttpStatusCode(405);
    $newMessage->addMessage('Method not allowed');
    $newMessage->send();
}

}

}else {
    $newMessage = new Statuses;
    $newMessage->setHttpStatusCode(401);
    $newMessage->addMessage('Please login');
    $newMessage->send();
    exit;
}


?>