<?php 

    require "../classes/Auth.php";
    require "../classes/Database.php";
    require "../classes/Image.php";
    require "../classes/Url.php";

    session_start();

    if (!Auth::isLoggedIn()){
        die("Nepovolený přístup!");
    }

    $connection = Database::connectionDB();
    $id = $_GET["id"];
    $image = Image::getImage($connection, $id);
    $path = "../uploads/Services/". $image["service"] . "/". $image["img_name"];

    try {
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if(Image::deleteImageFromDirectory($path)){
                if(Image::deleteImage($connection, $id)){
                    Url::redirectURL("/SweetCaramelRose/service.php");
                } else {
                    throw new  Exception("Nepodařilo se smazat obrázek z databáze.");
                }
            } else {
               throw new  Exception("Nepodařilo se smazat obrázek ze složky.");
            }
            rmdir("../uploads/Services/" . $image["service"]);
        }
    } catch (Exception $e) {
        error_log("Chyba na stránce delete-service. \n", 3, "../errors/error.log");
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
                <a href="/SweetCaramelRose/service.php"><button class="btn go-back">Zpátky</button></a>
                <form action="" method="POST">
                    <button class="btn delete-btn">SMAZAT!</button>
                </form>
            </article>
            <h2>Opravdu si přejete smazat obrázek <strong><?= $image["img_name"] ;?></strong></h2>
        </section>
    </main>
</body>
</html>