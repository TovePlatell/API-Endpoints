<?php 
    require_once "config/dbConnection.php";
    require_once "helpers/session_helper.php";


    //  This function reads the files in the Objects-file and updates
    spl_autoload_register(function($objectName){  
        require_once "objects/$objectName.php";   
    });