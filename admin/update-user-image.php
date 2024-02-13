<?php 

    require "../classes/Database.php";
    require "../classes/User.php";
    require "../classes/Image.php";
    require "../classes/Url.php";
    require "../classes/Auth.php";

    session_start();

    if (!Auth::isLoggedIn()){
        die("Nepovolený přístup!");
    }

    $id = $_SESSION["logged_in_user_id"];
    $img_path = "../img/admin/";

    $connection = Database::connectionDB();

    $user_img_in_database = User::getUserParam($connection, $id, "img");

    $user_img = $img_path . $user_img_in_database["img"];

    echo $user_img_in_database["img"];


    if(isset($_POST["submit"]) && isset($_FILES["image"])){
        $img = $_FILES["image"]["name"];
        $image_tmp_name = $_FILES["image"]["tmp_name"];
        $error = $_FILES["image"]["error"];
        $image_upload_path = "../img/admin/" . $img;

        if($error === 0){

            if($user_img_in_database["img"] != ""){
                unlink($user_img);
                $image = "";
                User::updateUserImage($connection, $image, $id);

                if(User::updateUserImage($connection, $img, $id)){
                    move_uploaded_file($image_tmp_name, $image_upload_path);
                    Url::redirectURL("/SweetCaramelRose/index.php");
                } 

            } else {
                move_uploaded_file($image_tmp_name, $image_upload_path);
                User::updateUserImage($connection, $img, $id);

                Url::redirectURL("/SweetCaramelRose/index.php");
            }
            
            
        } else {
            echo $error;
        }
    }

    