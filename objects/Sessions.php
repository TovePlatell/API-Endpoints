<?php

class Sessions {

    private $db_Connection;

    function __construct($db)
    {
        $this->db_Connection = $db;
    }

    public function checkUser($user_name){
        $sql = "SELECT user_name, user_password, user_id 
                FROM users 
                WHERE user_name = :user_name";
        $stm = $this->db_Connection->prepare($sql);
        $stm->bindParam(":user_name", $user_name);
        $stm->execute();

        return $stm->fetch();
    }

    public function createSession($user_id, $token){
        $sql = "INSERT INTO sessions (sessionuser_id, token)
                VALUES (:sessionuser_id, :token)";
        $stm = $this->db_Connection->prepare($sql);
        $stm->bindParam(":sessionuser_id", $user_id);
        $stm->bindParam(":token", $token);
        $stm->execute();
    }


    // skapa en expire för som är buggd på funktion last used
}