<?php

class Database {
    
    public static function connectionDB(){
        $db_host = "localhost";
        $db_user = "Admin";
        $db_password = "";
        $db_name = "scr_database";
    
        $connection = "mysql:host=" . $db_host . ";dbname=" . $db_name . ";charset=utf8";

        try {
            $db = new PDO($connection, $db_user, $db_password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
}