<?php

require_once "../../bootstrap.php"; 

if(isset($_GET["token"])):
    $checkSession = new Sessions($pdo);
    $checkToken = $checkSession->checkToken($_GET["token"]);

    $Array____checkToken = [
        "last_used" => "",
        "sessionuser_id" => "",
    ];

    checkToken($checkToken["last_used"]) ? $checkSession->updateSession($_GET["token"]) : false;
    //echo checkToken($tokenExpireDate) ? "Already Logged in" : false;

        if(isset($_GET["user_id"])){

            if($_GET["user_id"] != $checkToken["sessionuser_id"]) {
                echo "Wrong user id";
            } elseif ($_GET["user_id"] === $checkToken["sessionuser_id"]){

                
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

            if($user_name == false && $user_password == false && $user_email == false) {
                echo "Nothing to update";
            } else {

                
                $query = rtrim($query, ",");
                
                $user_name === true ? $user_name = $_GET["user_name"] : false; 
                
                $user_email === true ? $user_email = $_GET["user_email"] : false;  
                
                $user_password === true ? $user_password= $_GET["user_password"] : false;  
                
                if($user_password === true){
                    $user_password = $_GET["user_password"];
                    $user_password = password_hash($user_password, PASSWORD_DEFAULT);
                }
                
                
                
                $user = new Users($pdo);
                $user->UpdateUser($query, $user_name, $user_password, $user_email, $user_id);
            }
        }
            
        } else {
            echo "please log in";
        }
        
        
        
endif; // samma sak if statement med curly brackets
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