<?php
    require "../classes/Database.php";
    require "../classes/Url.php";
    require "../classes/User.php";



    session_start();
    if($_SERVER["REQUEST_METHOD"] === "POST") {

        $connection = Database::connectionDB();
    
    
        $admin_name = $_POST["admin-name"];
        $log_password = $_POST["login-password"];

        $user = new User();
    
        if($user->authentication($connection, $admin_name, $log_password)) {
            // Získání ID uživatele
            $id = $user->getUserId($connection, $admin_name);
    
            // Zabraňuje provedení tzv. fixation attack. Více zde: https://owasp.org/www-community/attacks/Session_fixation
            session_regenerate_id(true);
    
            // Nastavení, že je uživatel přihlášený
            $_SESSION["is_logged_in"] = true;
            // Nastavení ID uživatele
            $_SESSION["logged_in_user_id"] = $id;
            
            Url::redirectUrl("/SweetCaramelRose/index.php");
            
        } else {
            $error = "Chyba při přihlášení";
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php require "../assets/header.php"; ?>
    <main>
        <?php if(!empty($error)): ?>
            <p><?= $error ?></p>
            <a href="../index.php">Přihlášení</a>
        <?php endif; ?>
    </main>
</body>
</html>