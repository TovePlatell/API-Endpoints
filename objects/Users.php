<?php



class Users
{

    private $db_Connection;
   

    function __construct($db)
    {
        $this->db_Connection = $db;
    }

    

    function CreateUser($user_name_IN, $user_email_IN, $user_password_IN)
    {

        if (!empty($user_name_IN) && !empty($user_email_IN) && !empty($user_password_IN)) {

            $sql2 = "SELECT user_email FROM users WHERE user_email = '$user_email_IN'";

            $stm2 = $this->db_Connection->prepare($sql2);

            if ($stm2->execute()) {
                $rowCount = $stm2->rowCount();
                if ($rowCount > 0) {
                    $newMessage = new Statuses;
                            $newMessage->setHttpStatusCode(409);
                            $newMessage->addMessage('User already exists!');
                            $newMessage->send();
                    die();

                } else {
                    $sql = "INSERT INTO users (user_name, user_email, user_password) VALUES (:user_name_IN, :user_email_IN, :user_password_IN)";

                    $stm = $this->db_Connection->prepare($sql); // connection to db

                    $stm->bindParam(":user_name_IN", $user_name_IN);
                    $stm->bindParam(":user_email_IN", $user_email_IN);
                    $stm->bindParam(":user_password_IN", $user_password_IN);

                   

                    if ($stm->execute()) {

                            $newMessage = new Statuses;
                            $newMessage->setHttpStatusCode(201);
                            $newMessage->addMessage('User created');
                            $newMessage->send();
                        
                        die();
                    }
                }
                die();
            }
        } else {

            $newMessage = new Statuses;
                            $newMessage->setHttpStatusCode(409);
                            $newMessage->addMessage('You have to fill in all the fields!');
                            $newMessage->send();
            die();
        }
    }




function DeleteUser($user_id){

    $sql = "DELETE FROM users where user_id = :user_id_IN";

    $stm = $this->db_Connection->prepare($sql);
    $stm->bindParam(":user_id_IN", $user_id);
    $stm->execute();

     if($stm->rowCount() > 0){

        $newMessage = new Statuses;
        $newMessage->setHttpStatusCode(200);
        $newMessage->addMessage('User is removed');
        $newMessage->send();     
     }  else {

        $newMessage = new Statuses;
        $newMessage->setHttpStatusCode(404);
        $newMessage->addMessage('Something went wrong trying to remove user');
        $newMessage->send();     
     }
    

}

function UpdateUser($query, $user_name, $user_password, $user_email, $user_id){
    $sql = "UPDATE users SET $query WHERE user_id = :user_id";
    $stm = $this->db_Connection->prepare($sql);
    $stm->bindParam(":user_id", $user_id);

    if($user_name != false){
        $stm->bindParam(":user_name", $user_name);
    }
    
    if($user_password != false){
        $stm->bindParam(":user_password", $user_password);
    }

    if($user_email != false){
        $stm->bindParam(":user_email", $user_email);
    }

    

    if($stm->execute()) {

        $newMessage = new Statuses;
        $newMessage->setHttpStatusCode(200);
        $newMessage->addMessage('User updated');
        $newMessage->send();
    }

}

/* function Login($user_name, $user_password){

    $sql = ("SELECT user_id, user_name, user_email, user_password FROM USERS WHERE user_name = :user_name AND user_password = :user_password");

    $stm = $this->db_Connection->prepare($sql);
    $stm->bindParam(":user_name", $user_name);
    $stm->bindParam(":user_password, $user_password);

    $stm->execute();

    if($stm->rowCount() == 1){
        $row = $stm->fetch();
        return $this->CreateToken($row['user_id'],$row['user_name']);
    
    
    }
}
 */
      










    
}