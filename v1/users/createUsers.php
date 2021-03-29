<?php
   require_once "../../bootstrap.php";  

  
    if(isset($_GET['user_name']) && isset($_GET['user_email']) && isset($_GET['user_password'])){  

        $user_name = trim($_GET['user_name']);
        $user_password = $_GET['user_password'];
        $user_email= $_GET['user_email'];

        $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
        
        $user = new Users($pdo);
        print_r(json_encode($user->createUser($_GET['user_name'], $_GET['user_email'],$hashed_password)));

        
    }


?>