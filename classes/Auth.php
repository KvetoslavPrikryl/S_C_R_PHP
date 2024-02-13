<?php

class Auth{
    function isLoggedIn(){
        return isset($_SESSION["is_logged_in"]) and $_SESSION["is_logged_in"];
    }
}