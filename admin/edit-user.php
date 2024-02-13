<?php 

    require "../classes/Database.php";
    require "../classes/User.php";
    require "../classes/Url.php";
    require "../classes/Auth.php";

    session_start();

    if (!Auth::isLoggedIn()){
        die("Nepovolený přístup!");
    }

    $connection = Database::connectionDB();

    $user = User::getUserParam($connection, $id=1, "first_name, second_name, admin_name, about_user, img");

    $id = $_SESSION["logged_in_user_id"];

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        try {
            $first_name = $_POST["first_name"];
            $second_name = $_POST["second_name"];
            $admin_name = $_POST["admin_name"];
            $about_user = $_POST["about_user"];

            if(User::updateUser($connection, $first_name, $second_name, $admin_name, $about_user, $id)){
                Url::redirectURL("/SweetCaramelRose/index.php");
            } else {
                throw new Exception("Nepodařilo se uložit změny pro uživatele!");
            }
        } catch (Exception $e) {
            error_log("Chyba na stránce edit-user. \n", 3, "../errors/error.log");
            echo "Typ chyby: " . $e->getMessage();
        }{

            
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
    <link rel="stylesheet" href="../css/edit-user.css">
    <title>Document</title>
</head>
<body>
    <main>
        <?php require "../assets/admin-panel.php"; ?>
        <a href="/SweetCaramelRose/index.php"><button class="btn go-back">Zpátky</button></a>
        <section class="edit-user">
            <div class="form">
                <article class="edit-user-form">
                    <h2 class="form-title">Upravit uživatele</h2>
                    <form action="" method="POST">
                        <input 
                            type="text" 
                            name="first_name" 
                            placeholder="Jméno"
                            value="<?= htmlspecialchars($user["first_name"]);?>"
                            ><br>
                        <input 
                            type="text" 
                            name="second_name" 
                            placeholder="Příjmení"
                            value="<?= htmlspecialchars($user["second_name"]);?>"
                            ><br>
                        <input 
                            type="text" 
                            name="admin_name" 
                            placeholder="Admin jméno"
                            value="<?= htmlspecialchars($user["admin_name"]);?>"
                            ><br>
                        <textarea 
                            type="text" 
                            name="about_user" 
                            placeholder="Něco o tobě"
                            ><?= htmlspecialchars($user["about_user"]);?></textarea><br>
                        
                        <input type="submit" class="button" value="Uložit">
                    </form>
                </article>
                <article class="edit-user-img">
                    <form action="update-user-image.php" method="POST" enctype="multipart/form-data">
                        <input 
                            type="file" 
                            name="image" 
                            placeholder="Obrázek"
                            file="<?= $user["img"];?>"
                        ><br>
                        <input type="submit" name="submit" class="button" value="Uložit">
                    </form>
                </article>
            </div>
        </section>
    </main>
    
</body>
</html>