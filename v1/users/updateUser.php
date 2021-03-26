<?php
include('../../config/dbConnection.php');//database connection
include('../../objects/Users.php');  


if(isset($_GET["user_id"])){

    $user_id = $_GET["user_id"];
    $user_name = false;
    $user_password = false;
    $user_email = false;
    $query = "";
    
    if(isset($_GET["user_name"])){
        $user_name = true;
        $query .= "user_name = :user_name,";
    }
    
    if(isset($_GET["user_password"])){
        $user_password = true;
        $query .= "user_password = :user_password,";
    }

    if(isset($_GET["user_email"])){
        $user_email = true;
        $query .= "user_email = :user_email,";
    }

    $query = rtrim($query, ",");

    $user_name === true ? $user_name = $_GET["user_name"] : false; 

    $user_email === true ? $user_email = $_GET["user_email"] : false;  

    $user_password === true ? $user_password= $_GET["user_password"] : false;  

    if($user_password === true){
        $user_password = $_GET["user_password"];
        $user_password = password_hash($user_password, PASSWORD_DEFAULT);
    }



$user = new User($pdo);
$user->UpdateUser($query, $user_name, $user_password, $user_email, $user_id);

} else {
    echo "error";
}

/*     $user_id = "";
    $usern_name = "";
    $user_password = "";
    $user_email = "";
  

    if(isset($_GET['user_id'])) {
        $id = $_GET['user_id'];
    } else {
        $error = new stdClass();
        $error->message = "id not specified";
        $error->code = "0004";
        echo json_encode($error);
        die();
    }

    if(isset($_GET['user_name'])) {
        $user_name = $_GET['user_name'];
    }

    if(isset($_GET['user_password'])) {
        $user_password = $_GET['user_password'];
    }

    if(isset($_GET['user_email'])) {
        $user_email = $_GET['user_email'];
    }



    $user = new User($pdo);
    echo json_encode($user->UpdateUser($user_id, $user_name, $user_password, $user_email, ));
 */