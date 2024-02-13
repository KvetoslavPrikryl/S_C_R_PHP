<?php 

    require "../classes/Dog.php";
    require "../classes/Database.php";
    require "../classes/Url.php";
    require "../classes/Auth.php";

    session_start();

    if (!Auth::isLoggedIn()){
        die("Nepovolený přístup!");
    }

    $connection = Database::connectionDB();

    $id = $_GET["id"];

    $dog = Dog::getDog($connection, $id, "name, img1, img2, img3");
    

    try {
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if(Dog::deleteDog($connection, $id)){
                if($dog["img1"] != ""){
                    Dog::deleteDogImage($connection, $dog["name"], $dog["img1"]);
                }
                if($dog["img2"] != ""){
                    Dog::deleteDogImage($connection, $dog["name"], $dog["img2"]);
                }
                if($dog["img3"] != ""){
                    Dog::deleteDogImage($connection, $dog["name"], $dog["img3"]);
                }
                rmdir("../uploads/Dogs/" . $dog["name"]);
                Url::redirectURL("/SweetCaramelRose/kennel.php");
            } else {
                throw new  Exception("Nepodařilo se smazat psa z databáze.");
            }
        }
    } catch (Exception $e) {
        error_log("Chyba na stránce delete-dog. \n", 3, "../errors/error.log");
        echo "Typ chyby: " . $e->getMessage();
    }
   

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/delete.css">
    <title>Document</title>
</head>
<body>
    <main>
        <section class="delete-section">
            <article class="delete-buttons">
                <a href="/SweetCaramelRose/kennel.php"><button class="btn go-back">Zpátky</button></a>
                <form action="" method="POST">
                    <button class="btn delete-btn">SMAZAT!</button>
                </form>
            </article>
            <h2>Opravdu chcete smazat psa: <strong><?= $dog["name"] ?></strong></h2>
        </section>
    </main>
</body>
</html>