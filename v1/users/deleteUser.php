<?php

include('../../config/dbConnection.php');//database connection
include('../../objects/Users.php');  

$user = new User($pdo);
        
if(!empty($_GET['user_id'])) {
    echo json_encode($user->DeleteUser($_GET['user_id']));

}

