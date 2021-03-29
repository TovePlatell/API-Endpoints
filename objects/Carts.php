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

        if($stm->execute()){

            echo "Added to cart sucessfully";
            die();
          }
        }

      


       
function deleteItemInCart($cartproduct_id, $cartuser_id){

    $sql = "DELETE FROM carts WHERE cartproduct_id = :cartproduct_id AND cartuser_id = :cartuser_id";
  
    $stm = $this->db_Connection->prepare($sql);
    $stm->bindParam(":cartproduct_id", $cartproduct_id);
    $stm->bindParam(":cartuser_id", $cartuser_id);
    $stm->execute();
  
     if($stm->rowCount() > 0){
  
        echo "$cartproduct_id is removed";
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

      return $stm->fetchAll();
  }

  

    }


