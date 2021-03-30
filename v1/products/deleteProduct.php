<?php

require_once "../../bootstrap.php"; 




if(!empty($_GET['product_id'])) {
    
    $product = new Products($pdo);
    $product->DeleteProduct($_GET["product_id"]);

}




?>