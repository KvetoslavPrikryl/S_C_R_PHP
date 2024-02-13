<?php 

    require "../classes/Database.php";
    require "../classes/Image.php";
    require "../classes/Service.php";
    require "../classes/Url.php";
    require "../classes/Auth.php";

    session_start();

    if (!Auth::isLoggedIn()){
        die("Nepovolený přístup!");
    }

    $connection = Database::connectionDB();
  

    //isset($_POST["submit"]) && isset($_FILES["image"])


    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $image_text = $_POST["image_text"]; 
        $service = $_POST["service"];   
        $image = [$_FILES["image"]["name"], $_FILES["image"]["tmp_name"], $_FILES["image"]["error"]];                     

        if($image[2] === 0){
            try {
               
                if(!file_exists("../uploads/Services/".$service)){
                    mkdir("../uploads/Services/" . $service, 0777, true);
                }
                $image_upload_path ="../uploads/Services/" . $service . "/" . $image[0] ;
                move_uploaded_file($image[1], $image_upload_path);
                if(Image::createImage($connection, $image_text, $image[0], $service)){
                    URL::redirectURL("/SweetCaramelRose/service.php");
                } else {
                    throw new Execute("Nepodařilo se uložit obrázek do databáze!");
                }
                    
            } catch (Execute $e) {
                error_log("Chyba na stránce create-gallery. \n", 3, "../errors/error.log");
                echo "Typ chyby: " . $e->getMessage();
            }
        }

    } else {
        echo "Problém s odesláním souborů";
        echo $error;
    }
