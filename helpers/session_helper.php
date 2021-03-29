<?php 
    function checkToken($token_time){
        if(strtotime($token_time) < time()) {
            echo "Token expired, plase log in again";
        } elseif((strtotime($token_time) - 1800) < time()) {
            return true;
        } else {
            // else längst ner om inget av ovan statement gäller.
            return false;
        }
    }