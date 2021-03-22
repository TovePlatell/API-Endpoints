<?php

 class Connection{   

   public function dbConnect(){      // return pdo
    return new PDO("mysql:host=localhost; dbname=ecommerce","root", "");  // this is our connection


 }
} 
 ?> 