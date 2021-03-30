<?php

require_once "../../bootstrap.php";


if(!empty($_GET['user_id'])) {
   $user = new Users($pdo);
   $user->DeleteUser($_GET["user_id"]);


}


