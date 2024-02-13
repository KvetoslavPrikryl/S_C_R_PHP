<?php 

    require "classes/Auth.php";
    require "classes/Database.php";
    require "classes/Dog.php";

    session_start();
    $session = false;

    if (Auth::isLoggedIn()){
        $session = $_SESSION["is_logged_in"];
    }

    $connection = Database::connectionDB();

    $dogs = Dog::getAllDogs($connection);

    $dog_mens = [];
    $dog_bitchs = [];
    $puppy = [];

    $dog = [];

    foreach($dogs as $one_dog){
        if($one_dog["dog_sex"] === "pes" || $one_dog["dog_sex"] === "Pes"){
            array_push($dog_mens, $one_dog);
        } elseif ($one_dog["dog_sex"] === "fena"|| $one_dog["dog_sex"] === "Fena"){
            array_push($dog_bitchs, $one_dog);
        } elseif ($one_dog["dog_sex"] === "štěně" || $one_dog["dog_sex"] === "Štěně"){
            array_push($puppy, $one_dog);
        } else{
            array_push($dog, $one_dog);
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/kennel.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/0fe3234472.js" crossorigin="anonymous"></script>
    <script src="js/JQuery.js"></script>
    <script src="js/kennel.js"></script>
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
            <h2>Chovatelská stanice</h2>
        </div>
        <?php require "assets/header.php"; ?>
        <section class="dog-header">
            <?php if(empty($dogs)): ?>
                <p>Žádní psi nebyli nalezeni!</p>
            <?php endif; ?>
            <?php if($session): ?>
                <div class="admin-dog-panel">
                    <li><a href="admin/create-god.php"><button class="btn">Vytvořit psa</button></a></li>
                </div>
            <?php endif; ?>
        </section>
        <section class="dogs">
            <article class="dog-article">
                <button class="btn man-dogs-btn">Psi</button>
                <div id="man-dogs">
                    <?php foreach($dog_mens as $one_dog): ?>
                            <?php require "assets/one-dog.php" ?>
                    <?php endforeach; ?>
                </div>
            </article>
            <article class="dog-article">
                <button class="btn famele-dogs-btn">Feny</button>
                <div id="famele-dogs">
                    <?php foreach($dog_bitchs as $one_dog): ?>
                            <?php require "assets/one-dog.php" ?>
                    <?php endforeach; ?>
                </div>
            </article>
            <article class="dog-article">
                <button class="btn pupy-dogs-btn">Štěňata</button>
                <div id="pups">
                    <?php foreach($puppy as $one_dog): ?>
                            <?php require "assets/one-dog.php" ?>
                    <?php endforeach; ?>
                </div>
            </article>
        </section>
        
    </main>
    <?php require "assets/footer.php"; ?>
</body>
</html>