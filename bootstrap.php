<?php 
    require_once "config/dbConnection.php";
    require_once "helpers/session_helper.php";


    // Denna funktion läser av filerna i objects mappen och uppdaterar
    spl_autoload_register(function($objectName){  
        require_once "objects/$objectName.php";   
    });