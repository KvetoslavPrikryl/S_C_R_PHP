<?php 

    require "classes/Auth.php";
    require "classes/User.php";
    require "classes/Database.php";

    session_start();
    $session = false;
    $connection = Database::connectionDB();
    $user = User::getUserParam($connection, $id=1, "first_name, second_name, about_user, img"); 
    $user_img_path = "img/admin/" . $user["img"];

    if (Auth::isLoggedIn()){
        $session = $_SESSION["is_logged_in"];
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/0fe3234472.js" crossorigin="anonymous"></script>
    <script src="js/JQuery.js"></script>
    <script src="js/index.js"></script>
    <script src="js/hamburger.js"></script>
    <title>Document</title>
</head>
<body>
    <main>
        <section class="page-description">
            <h1>Sweet Caramel Rose</h1>
            <h2>Chovatelská stanice a psí salón</h2>
        </section>
        <section class="user">
            <div class="user-info">
                <?php if($session): ?>
                    <a class="edit-user-button" href="admin/edit-user.php">Upravit</a>
                <?php else: ?>
                    <button id="sing-in">Přihlásit</button>
                <?php endif ?>
                <h2><?php echo htmlspecialchars($user["first_name"])." ".htmlspecialchars($user["second_name"])  ?></h2>
                <img src="<?= $user_img_path ?>" alt="">
                <p><?php echo htmlspecialchars($user["about_user"]) ?></p>
            </div>
        </section>
        <?php require "assets/header.php"; ?>
        <section class="sing-in-user-form">
            <form action="./admin/login.php" method="POST" >
                <i class="fa-solid fa-xmark" id="close"></i>
                <input type="text" class="admin-name" name="admin-name" placeholder="Uživatelské jméno"><br>
                <input type="password" class="password" name="login-password" placeholder="Heslo"><br>
                <input type="submit" class="button" value="Přihlásit">
            </form>
        </section>
    </main>
    <?php if($session): ?>
        <?php require "assets/admin-panel.php"; ?>
    <?php endif; ?>
    <?php require "assets/footer.php"; ?>
</body>
</html>