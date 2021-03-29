<?php

require_once "../../bootstrap.php";

$user = new Users($pdo);
        
if(!empty($_GET['user_id'])) {
    echo json_encode($user->DeleteUser($_GET['user_id']));

}

