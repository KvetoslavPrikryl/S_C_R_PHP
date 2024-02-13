<?php 
    require "../classes/Auth.php";
    require "../classes/Database.php";
    require "../classes/Link.php";
    require "../classes/Url.php";

    session_start();

    if (!Auth::isLoggedIn()){
        die("Nepovolený přístup!");
    }

    $connection = Database::connectionDB();

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        try {
            if(LINK::deleteLink($connection, $_GET["id"])){
                Url::redirectURL("/SweetCaramelRose/link.php");
            } else {
                throw new  Exception("Nepodařilo se smazat odkaz z databáze.");
            }
        } catch (Exception $e) {
            error_log("Chyba na stránce delete-link. \n", 3, "../errors/error.log");
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
    <link rel="stylesheet" href="../css/delete.css">
    <title>Document</title>
</head>
<body>
    <main>
        <section class="delete-section">
            <article class="delete-buttons">
                <a href="/SweetCaramelRose/link.php"><button class="btn go-back">Zpět</button></a>
                <form action="" method="POST">
                    <button class="btn delete-btn">SMAZAT!</button>
                </form>
            </article>
            <h2>Opravdu chcete smazat odkaz</h2>
        </section>            
    </main>
</body>
</html>