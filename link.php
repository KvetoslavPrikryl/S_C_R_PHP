<?php 

    require "classes/Auth.php";
    require "classes/Database.php";
    require "classes/Link.php";
    require "classes/Url.php";

    session_start();
    $session = false;

    $connection = Database::connectionDB();

    $links = Link::getAllLink($connection);

    $all_links_name = [];

    foreach($links as $one_link){
        if(!in_array($one_link["name"], $all_links_name)){
            array_push($all_links_name, $one_link["name"]);
        }
    }

    if (Auth::isLoggedIn()){
        $session = $_SESSION["is_logged_in"];

        try {
            if($_SERVER["REQUEST_METHOD"] === "POST"){
                $name = $_POST["name"];
                $link_page = $_POST["link"];
                $text = $_POST["text"];

                $link = new Link();

                if($link->createLink($connection, $name, $link_page, $text)){
                    Url::redirectURL("/SweetCaramelRose/link.php");
                } else {
                    throw new Exception("Nepodařilo se uložit odkzad do databáze.");
                }
            }
        } catch (Exception $e) {
            error_log("Chyba při ukládání odkazu. \n", 3, "../errors/error.log");
            echo "Typ chyby: " . $e->getMessage();
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/link.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/0fe3234472.js" crossorigin="anonymous"></script>
    <script src="js/JQuery.js"></script>
    <script src="js/link.js"></script>
    <script src="js/hamburger.js"></script>
    <title>Document</title>
</head>
<body>
    <main>
        <?php if($session): ?>
            <?php require "assets/admin-panel.php"; ?>
        <?php endif; ?>
        <div class="page-description">
            <h1>Sweet Caramel Rose</h1>
            <h2>Odkazy</h2>
        </div>
        <?php require "assets/header.php"; ?>
        <section class="link">
            <?php if($session): ?>
                <button class="btn">Vytvořit odkaz</button>
                <article class="form">
                    <h2 class="form-title">Vytvořit odkaz</h2>
                    <form action="" method="POST">
                        <input type="text" name="name" placeholder="Název produktu">
                        <input type="text" name="link" placeholder="Odkaz na produkt">
                        <input type="text" name="text" placeholder="Doporučení">
                        <input type="submit" class="button" value="Uložit">
                    </form>
                </article>
            <?php endif ?>
            <article class="all-links">
                    <?php foreach($all_links_name as $one_link_name): ?>
                        <h3><?= $one_link_name; ?></h3>
                        <?php foreach($links as $one_link): ?>
                            <?php if($one_link["name"] === $one_link_name): ?>
                                <a href="<?= $one_link["link"];?>" target="_blank" class="one-link"><?= $one_link["text"];?></a>
                                <?php if($session): ?>
                                    <a href="admin/delete-link.php?id=<?= $one_link["id"]?>"><button class="delete-btn">Smazat!</button></a> <br>
                                <?php endif; ?>
                                <br>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
            </article>
        </section>
    </main>
    <?php require "assets/footer.php"; ?>
</body>
</html>