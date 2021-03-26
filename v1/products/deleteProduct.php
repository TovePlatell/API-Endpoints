<?php

include('../../config/dbConnection.php');//database connection
include('../../objects/Products.php');  



$product = new Product($pdo);

if(!empty($_GET['product_id'])) {
    echo json_encode($product->DeleteProduct($_GET['product_id']));

}




?>