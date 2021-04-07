<?php 
    function checkTokenExpired($token_time){
        if(strtotime($token_time) < time()) {  // convert token_time to timestamp and check if its less than current time

            $newMessage = new Statuses;
            $newMessage->setHttpStatusCode(409);
            $newMessage->addMessage('Token expire please login again');
            $newMessage->setData('');
            $newMessage->send();
            exit;
            
        } elseif((strtotime($token_time) - 1800) < time()) {  // else takes 30 min of from current time
            return true;
        } else {
        
            return false;
        }
    }