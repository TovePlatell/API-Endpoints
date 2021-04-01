<?php 
    function checkTokenExpired($token_time){
        if(strtotime($token_time) < time()) {

            $newMessage = new Statuses;
            $newMessage->setHttpStatusCode(409);
            $newMessage->addMessage('Token expire please login again');
            $newMessage->setData('');
            $newMessage->send();
            exit;
            
        } elseif((strtotime($token_time) - 1800) < time()) {
            return true;
        } else {
            // else längst ner om inget av ovan statement gäller.
            return false;
        }
    }