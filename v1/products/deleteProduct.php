<?php

require_once "../../bootstrap.php"; 



$product = new Product($pdo);

if(!empty($_GET['product_id'])) {
    echo json_encode($product->DeleteProduct($_GET['product_id']));

}




?>