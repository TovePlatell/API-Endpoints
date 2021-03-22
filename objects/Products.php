<?php

include('../config/dbConnection.php');//database connection

class Product{

  //object properties
  public $product_id;
  public $product_title;
  public $product_description;


  function __construct($db){

    $this->db_connection = $db;  //db är våran pdo koppling
}
  


}



