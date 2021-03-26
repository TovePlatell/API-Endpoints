<?php
include('../../config/dbConnection.php');//database connection
include('../../objects/Products.php');  


$product = new Product($pdo);
print_r($product->ShowAllProducts());