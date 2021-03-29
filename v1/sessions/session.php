<?php

require_once "../../bootstrap.php";

if(isset($_GET["token"])){
    $checkSession = new Sessions($pdo);
    $checkToken = $checkSession->checkToken($_GET["token"]);

    checkToken($checkToken["last_used"]) ? $checkSession->updateSession($_GET["token"]) : false;
    echo !checkToken($checkToken) ? "Already logged in" : false;
    //echo checkToken($tokenExpireDate) ? "Already Logged in" : false;
}

if(!isset($_GET["token"])) {

    if(isset($_GET['user_name']) && isset($_GET['user_password'])) {
        
        // Värden från URL:en // Get metoden
        $user_name = $_GET["user_name"];
        $user_password = $_GET["user_password"];
        
    // Sätter igång sessions classen
    $newSession = new Sessions($pdo);

    /* Vi returnar värdet från checkUser funktionen och lagrar  
    * den  i $userInfo ---> returnar 1 row eller ingenting.
     * Om den returnerar 1 row så blir det en array.
     */
    
    $userInfo = $newSession->checkUser($user_name);

    /*
     * Eftersom att $userInfo har en return på en Fetch som returnerar en array
     * så kommer $userInfo att uppdateras till en array
     */
    $NyaUserInfo = [
        "user_name" => "tove",
        "user_password" => "hashed",
        "user_email" => "tove@tove.se"
    ];

    // Om $userInfo är tom -> echo 
    echo empty($userInfo) ? "Username not found" : false;

    // Lagrar värdena från $userInfo i enskilda variabler
    if(!empty($userInfo)){
        $checkUser_name = $userInfo["user_name"];
        $checkUser_password = $userInfo["user_password"];
        $checkUser_id = $userInfo["user_id"];

        // Jämför $user_pasword (det som en user skriver in) med det
        // hashade lösenordet från databasen
        if(password_verify($user_password, $checkUser_password)){
    
            /*
             * skapar binary bytes > konverterar till hexadecimal >
             * konverterar till bokstäver
             */
            $token = base64_encode(bin2hex(openssl_random_pseudo_bytes(24)).time());
            $token_expire = 3600;
    
            $newSession->createSession($checkUser_id, $token, $token_expire);
    
            echo "logged in";
    
        } else {
            echo "username or password is incorrect";
        }
    }
    
    



    
    
} else {
    $array = [];
    !isset($_GET['user_name']) ? array_push($array, "Username cannot be empty") : false;
    !isset($_GET['user_password']) ? array_push($array, "Password cannot be empty") : false;
    
    echo json_encode($array);
}
}