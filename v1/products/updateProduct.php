<?php

require_once "../../bootstrap.php"; 


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

    $changeProduct = rtrim($changeProduct, ",");

    $product_name === true ? $product_name = $_GET["product_name"] : false;  

    $product_desc === true ? $product_desc = $_GET["product_desc"] : false;  

    $product_price === true ? $product_price= $_GET["price"] : false;  

    
$product = new Product($pdo);
$product->UpdateProduct($changeProduct, $product_name, $product_desc, $product_price, $product_id);

} else {
    echo "error";
}
