<?php

class Users
{

    private $db_Connection;

    function __construct($db)
    {
        $this->db_Connection = $db;
    }
  
    // denna funktion funkar

    function CreateUser($user_name, $user_email, $user_password) {
        if (!empty($user_name) && !empty($user_email) && !empty($user_password)) {  

            
            $sql2 = "SELECT user_email, user_name FROM users WHERE user_email = '$user_email' OR user_name = '$user_name'";
            $stm2 = $this->db_Connection->prepare($sql2);

            if ($stm2->execute()) {
                $rowCount = $stm2->rowCount();
                if ($rowCount > 0) {
                    return true;
                        
                    } else {

                    $sql = "INSERT INTO users (user_name, user_email, user_password) VALUES (:user_name, :user_email, :user_password)";
                    $stm = $this->db_Connection->prepare($sql); // connection to db
                    $stm->bindParam(":user_name", $user_name);
                    $stm->bindParam(":user_email", $user_email);
                    $stm->bindParam(":user_password", $user_password);

                    if ($stm->execute()) {
                        return false;
                    }      
                } 
            }
        }
    }
            


    function DeleteUser($user_id)
    {

        $sql = "DELETE FROM users where user_id = :user_id";
        $stm = $this->db_Connection->prepare($sql);
        $stm->bindParam(":user_id", $user_id);

        $stm->execute();

        if ($stm->rowCount() > 0) {

            return true;

        } else {

            return false;
        }
    }



    function UpdateUser($query, $user_name, $user_password, $user_email, $user_id)
    {
        $sql = "UPDATE users SET $query WHERE user_id = :user_id";
        $stm = $this->db_Connection->prepare($sql);
        $stm->bindParam(":user_id", $user_id);

        if ($user_name != false) {
            $stm->bindParam(":user_name", $user_name);
        }

        if ($user_password != false) {
            $stm->bindParam(":user_password", $user_password);
        }

        if ($user_email != false) {
            $stm->bindParam(":user_email", $user_email);
        }



        if ($stm->execute()) {

            return true;

            /* $newMessage = new Statuses;
            $newMessage->setHttpStatusCode(200);
            $newMessage->addMessage('User updated');
            $newMessage->send(); */
        }else{

            
            return false;
        }
    }

}
