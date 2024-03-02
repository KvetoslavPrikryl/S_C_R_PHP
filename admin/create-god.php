<?php
    require "../classes/Database.php";
    require "../classes/Dog.php";
    require "../classes/Url.php";
    require "../classes/Auth.php";
   
    session_start();

    if (!Auth::isLoggedIn()){
        die("Nepovolený přístup!");
    }

    $session = $_SESSION["is_logged_in"];

    $name = null;
    $dog_sex = null;
    $color = null;
    $weight = null;
    $height = null;
    $pately = null;
    $body = null;
    $img1 = null; 
    $img2 = null; 
    $img3 = null;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $name = $_POST["name"];
        $dog_sex = $_POST["dog_sex"];
        $color = $_POST["color"];
        $weight = $_POST["weight"];
        $height = $_POST["height"];
        $pately = $_POST["pately"];
        $body = $_POST["body"];
       
        $image_1 = [$_FILES["img1"]["name"], $_FILES["img1"]["tmp_name"], $_FILES["img1"]["error"]];
        $image_2 = [$_FILES["img2"]["name"], $_FILES["img2"]["tmp_name"], $_FILES["img2"]["error"]];
        $image_3 = [$_FILES["img3"]["name"], $_FILES["img3"]["tmp_name"], $_FILES["img3"]["error"]];

        //$connection = connectionDB();
        $connection = Database::connectionDB();

        $dog = new Dog();

        try{
            if($id = $dog->createDog($connection, $name, $dog_sex, $color, $weight, $height, $pately, $body)){
                if($image_1 != ""){
                    Dog::editDogImage($connection, $image_1, "img1", $name, $id);
                } 
                if($image_2 != ""){
                    Dog::editDogImage($connection, $image_2, "img2", $name, $id);
                }
                if($image_3 != ""){
                    Dog::editDogImage($connection, $image_3, "img3", $name, $id);
                }
                
                Url::redirectURL("/SweetCaramelRose/kennel.php");
            } else {
                throw new Excention("Nepodařilo se uložit nového psa!");
            }
        } catch (Excention $e) {
            error_log("Chyba na stráce create-dog. \n", 3, "../errors/error.log");
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
                <h2 class="form-title">Vytvořit psa</h2>
                <?php require "../assets/form-dog.php" ?>
            </article>
        </section>
    </main>
</body>
</html>