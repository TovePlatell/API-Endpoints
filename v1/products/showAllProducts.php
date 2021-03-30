<?php

require_once "../../bootstrap.php";  


$product = new Products($pdo);

$allProducts = $product->ShowAllProducts();

$newMessage = new Statuses;
            $newMessage->setHttpStatusCode(409);
            $newMessage->addMessage('');
            $newMessage->setData($allProducts);
            $newMessage->send();