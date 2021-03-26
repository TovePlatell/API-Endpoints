<?php


class Cart
{

    private $db_Connection;
    private $user_id;
    private $user_name;
    private $user_email;
    private $user_token;
    private $user_password;



    function __construct($db)
    {

        $this->db_Connection = $db;
    }

     

    function addItemToCart($cart_id, $product_id){

        $sql = ("INSERT INTO carts (cart_id, product_id) VALUES(:cart_id, :product_id)");

        $stm = $this->db_Connection->prepare($sql);

        $stm->bindParam(":cart_id", $cart_id);
        $stm->bindParam(":product_id", $product_id);

        if($stm->execute()){

            echo "Created product sucessfully";
            die();
          }
        }
        
    }


