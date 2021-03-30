<?php 
    function checkTokenExpired($token_time){
        if(strtotime($token_time) < time()) {
            echo "Token expired, please log in again";
        } elseif((strtotime($token_time) - 1800) < time()) {
            return true;
        } else {
            // else längst ner om inget av ovan statement gäller.
            return false;
        }
    }