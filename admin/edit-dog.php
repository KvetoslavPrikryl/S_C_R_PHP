<?php 
    require "../classes/Auth.php";
    require "../classes/Database.php";
    require "../classes/Dog.php";
    require "../classes/Url.php";

    session_start();

    if (!Auth::isLoggedIn()){
        die("Nepovolený přístup!");
    }

    $session = $_SESSION["is_logged_in"];

    $connection = Database::connectionDB();

    $id = $_GET["id"];

    $one_dog = Dog::getDog($connection, $id);

    if(isset($id)){
        if($one_dog){
            $name = $one_dog["name"];
            $dog_sex = $one_dog["dog_sex"];
            $weight = $one_dog["weight"];
            $height = $one_dog["height"];
            $color = $one_dog["color"];
            $pately = $one_dog["pately"];
            $body = $one_dog["body"];
            $img1 = $one_dog["img1"];
            $img2 = $one_dog["img2"];
            $img3 = $one_dog["img3"];
            $id = $one_dog["id"];
        } else {
            die("Pes nenalezen!");
        }
      
    } else {
        die("ID nebylo zadáno, pes nemohl být nalezeb!");
    }

    if($_SERVER["REQUEST_METHOD"] === "POST"){

        $name = $_POST["name"];
        $dog_sex = $_POST["dog_sex"];
        $weight = $_POST["weight"];
        $height = $_POST["height"];
        $color = $_POST["color"];
        $pately = $_POST["pately"];
        $body = $_POST["body"];

        $image_1 = [$_FILES["img1"]["name"], $_FILES["img1"]["tmp_name"], $_FILES["img1"]["error"]];
        $image_2 = [$_FILES["img2"]["name"], $_FILES["img2"]["tmp_name"], $_FILES["img2"]["error"]];
        $image_3 = [$_FILES["img3"]["name"], $_FILES["img3"]["tmp_name"], $_FILES["img3"]["error"]];

        $img_path = "../uploads/Dogs/";

        $image_null = "";

        try{
            if(Dog::editDog($connection, $name, $dog_sex, $color, $weight, $height, $pately, $body, $id)){
                if($image_1[0] != ""){
                    if(file_exists($img_path . $name . "/" . $img1)){
                        unlink($img_path . $name . "/" . $img1);
                    }
                    
                    if(Dog::editDogImage($connection, $image_null, "img1", $name, $id)){
                        Dog::editDogImage($connection, $image_1, "img1", $name, $id);
                        echo "Uložen obrázek 1";
                    }
                    
                }
                if($image_2[0] != ""){
                    if(file_exists($img_path . $name . "/" . $img2)){
                        unlink($img_path . $name . "/" . $img2);
                    }
                    
                    if(Dog::editDogImage($connection, $image_null, "img2", $name, $id)){
                        Dog::editDogImage($connection, $image_2, "img2", $name, $id);
                        echo "Uložen obrázek 2";
                    }
                }
                if($image_3[0] != ""){
                    if(file_exists($img_path . $name . "/" . $img3)){
                        unlink($img_path . $name . "/" . $img3);
                    }
                    
                    if(Dog::editDogImage($connection, $image_null, "img3", $name, $id)){
                        Dog::editDogImage($connection, $image_3, "img3", $name, $id);
                        echo "Uložen obrázek 3";
                    }
                }

                Url::redirectURL("/SweetCaramelRose/kennel.php");
            } else {
                throw new Exception("Nepodařilo se uložit změny o psovi!");
            }
        } catch (Exception $e){
            error_log("Chyba na stráce edit-dog. \n", 3, "../errors/error.log");
            echo "Typ chyby: " . $e->getMessage();
            }

    }

?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/form-dog.css">
    <title>Document</title>
</head>
<body>
    <main>
        <?php if($session): ?>
            <?php require "../assets/admin-panel.php"; ?>
        <?php endif; ?>
        <a href="/SweetCaramelRose/kennel.php"><button class="btn go-back">Zpátky</button></a>
        <section class="form-section">
            <article class="form-article">
                <h2 class="form-title">Upravit psa</h2>
                <?php require "../assets/form-dog.php"; ?>
            </article>
        </section>
    </main>
</body>
</html>
