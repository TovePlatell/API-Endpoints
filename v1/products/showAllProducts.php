<?php

require_once "../../bootstrap.php";  


$product = new Product($pdo);
print_r($product->ShowAllProducts());