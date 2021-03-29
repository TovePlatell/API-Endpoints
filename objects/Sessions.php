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

    public function createSession($user_id, $token, $token_expire){
        $sql = "INSERT INTO sessions (sessionuser_id, token, last_used)
                VALUES (:sessionuser_id, :token, date_add(NOW(), INTERVAL :token_expire SECOND))";
        $stm = $this->db_Connection->prepare($sql);
        $stm->bindParam(":sessionuser_id", $user_id);
        $stm->bindParam(":token", $token);
        $stm->bindParam(":token_expire", $token_expire);
        $stm->execute();
    }

    public function checkToken($token){
        $sql = "SELECT last_used, sessionuser_id, role FROM sessions s 
                INNER JOIN users u ON s.sessionuser_id = u.user_id
                WHERE token = :token";

        $stm = $this->db_Connection->prepare($sql);
        $stm->bindParam(":token", $token);
        $stm->execute();
        return $stm->fetch();
    }

    public function updateSession($token){
        $addTime = 3600; // 1 timme
        $sql = "UPDATE sessions SET last_used = date_add(NOW(), INTERVAL :addTime SECOND) 
                WHERE token = :token";
                $stm = $this->db_Connection->prepare($sql);
                $stm->bindParam(":addTime", $addTime);
                $stm->bindParam(":token", $token);
                $stm->execute();

    }

    // skapa en expire för som är buggd på funktion last used

    
}