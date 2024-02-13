<?php 

    require "../classes/Database.php";
    require "../classes/Url.php";
    require "../classes/User.php";

    session_start();

    if($_SERVER["REQUEST_METHOD"] === "POST"){

        $connection = Database::connectionDB();

        $first_name = $_POST["first-name"];
        $second_name = $_POST["second-name"];
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $admin_name = $_POST["admin-name"];
        $about_user = $_POST["about_user"];

        $user = new User();

        $id = $user->createUser($connection, $first_name, $second_name, $password, $admin_name, $about_user = "", $img = "Null");

        if(!empty($id)){
            // Zabraňuje tzv. fixation attack
            session_regenerate_id(true);

            // Nastavení že je uživatel přihlášený
            $_SESSION["is_logged_in"] = true;

            // Nastavení ID uživatele
            $_SESSION["logged_in_user_id"] = $id;

            Url::redirectURL("SweetCaramelRose/index.php");
        } else {
            echo "Uživatele se nepodařilo přidat";
        }
    }
