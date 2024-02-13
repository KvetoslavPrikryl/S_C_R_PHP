<?php

    require "../classes/Auth.php";

    session_start();

    if (!Auth::isLoggedIn()){
        die("Nepovolený přístup!");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/registration.css">
    <title>Document</title>
</head>
<body>
    <main>
        <div class="page-description">
            <h1>Registrace</h1>
        </div>
        <a href="/SweetCaramelRose/index.php"><button class="btn">Zpátky</button></a>
        <section class="form-section">
            <article class="form-article">
                <form action="./after-registration.php" method="POST">
                    <input type="text" class="input" name="first-name" placeholder="Křestní jméno" required><br>
                    <input type="text" class="input" name="second-name" placeholder="Příjmení" required><br>
                    <input type="password" class="input" name="password" placeholder="Heslo" required><br>
                    <input type="text" class="input" name="admin-name" placeholder="Admin jméno" required><br>
                    <input type="text" class="input" name="about_user" placeholder="O uživateli"><br>
                    <p class="result-text"></p>
                    <input type="submit" class="button" value="Zaregistrovat">
                </form>
            </article>
        </section>
    </main>
</body>
</html>