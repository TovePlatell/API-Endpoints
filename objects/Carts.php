<?php


class Carts
{

    private $db_Connection;
    function __construct($db)
    {
        $this->db_Connection = $db;

    }

    function addItemToCart($product_id, $user_id){
        $sql = ("INSERT INTO carts (cartproduct_id, cartuser_id) VALUES(:product_id, :user_id)");
        $stm = $this->db_Connection->prepare($sql);

        $stm->bindParam(":user_id", $user_id);
        $stm->bindParam(":product_id", $product_id);

        if(!$stm->execute()){
          
          return false;

          }else{

            return true;
          }
    }

    function checkProduct($product_id){
      $sql = "SELECT product_name, product_desc, price FROM products WHERE product_id = :product_id";
      $stm = $this->db_Connection->prepare($sql);
      $stm->bindParam(":product_id", $product_id);
      $stm->execute();

      $row = $stm->rowCount();

      if($row == 1){
        return $stm->fetch(PDO::FETCH_OBJ); 
      } else {
        return false;
      }
    }

       
function deleteItemInCart($cart_id, $cartuser_id){

    $sql = "DELETE FROM carts WHERE cart_id = :cart_id AND cartuser_id = :cartuser_id";
  
    $stm = $this->db_Connection->prepare($sql);
    $stm->bindParam(":cart_id", $cart_id);
    $stm->bindParam(":cartuser_id", $cartuser_id);
    $stm->execute();

     if($stm->rowCount() > 0){
  
      return true;

     } else {

        return false;

       }
    }
    
       
function deleteItemSetInCart($cartproduct_id, $cartuser_id){

    $sql = "DELETE FROM carts WHERE cartproduct_id = :cartproduct_id AND cartuser_id = :cartuser_id";
  
    $stm = $this->db_Connection->prepare($sql);
    $stm->bindParam(":cartproduct_id", $cartproduct_id);
    $stm->bindParam(":cartuser_id", $cartuser_id);
    $stm->execute();
  
     if($stm->rowCount() > 0){
  
      return true;

     } else {

      return false;
      
     }
    
  
  }

  
  function getCartItems($user_id = ""){
    $query = "";

    if(!empty($user_id)) {
        $query = 'WHERE cartuser_id = :id';
    }

      $sql = "SELECT * FROM carts 
              $query";

      $stm = $this->db_Connection->prepare($sql);

    if(!empty($user_id)){
        $stm->bindParam(":id", $user_id);
    }

      $stm->execute();

      return $stm->fetchAll(PDO::FETCH_OBJ);
  }

  

    }



