<?php

require_once "../../bootstrap.php";  


$product = new Products($pdo);

$allProducts = $product->ShowAllProducts();     

            $newMessage = new Statuses;
            $newMessage->setHttpStatusCode(200);
            $newMessage->addMessage('');
            $newMessage->setData($allProducts);  
            $newMessage->send();
            exit;