<?php

include('../../config/dbConnection.php');//database connection
include('../../objects/Products.php');  


if(isset($_GET['product_name']) && isset($_GET['product_desc']) && isset($_GET['price'])){

    $product_name = $_GET['product_name'];
    $product_desc = $_GET['product_desc'];
    $product_price = $_GET['price'];

    
    echo "new updated products $product_name";
    
    $product = new product($pdo);
    $product->CreateProducts($product_name, $product_desc, $product_price);

    echo "new updated products $product_name";
    
}else{




}

?>

