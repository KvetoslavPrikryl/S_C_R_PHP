<?php 

    require "classes/Auth.php";
    require "classes/Database.php";
    require "classes/Service.php";
    require "classes/Url.php";
    require "classes/Image.php";

    session_start();
    $session = false;

    $connection = Database::connectionDB();

    $services = Service::getAllServices($connection);
    $gallery = Image::getAllImages($connection);

    $all_service_names = [];
    $all_image_services = [];

    foreach($services as $one_service){
        array_push($all_service_names, $one_service["name"]);
    }

    foreach($gallery as $one_image){
        array_push($all_image_services, $one_image["service"]);
    }

    

    if (Auth::isLoggedIn()){
        $session = $_SESSION["is_logged_in"];

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $name = $_POST["name"];
            $price = $_POST["price"];

            $service = new Service();

            try{
                if($service->createService($connection, $name, $price)){
                    Url::redirectURL("/SweetCaramelRose/service.php");
                }
                else {
                    throw new Exception("Uložení nové služby se nepovedlo!");
                }
            } catch (Exception $e) {
                error_log("Chyba na stránce vytvoření nové služby. \n", 3, "../errors/error.log");
                echo "Typ chyby: " . $e->getMessage();
            }
        }

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/service.css">
    <script src="https://kit.fontawesome.com/0fe3234472.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="Js/JQuery.js"></script>
    <script src="Js/service.js"></script>
    <script src="Js/gallery.js"></script>
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
            <h2>Služby</h2>
        </div>
        <div class="content">
            <section class="services">
                <?php if($session): ?>
                    <button class="btn service-btn">Výtvořit servis</button>
                    <article class="create-service">
                        <h2 class="form-title">Vytvořit servis</h2>
                        <form action="" method="POST">
                            <input type="text" 
                                    name = "name"
                                    placeholder = "Název služby"
                                    >

                            <input type="number"
                                    name = "price"
                                    placeholder = "Cena"
                                    >
                            <input type="submit"
                                    name = "submit"
                                    value = "Uložit"
                                    class="button"
                                    >
                        </form>
                    </article>
                <?php endif ?>
                <?php if(empty($services)): ?>
                    <div class="service-header">
                        <p>Nebyli nalezeny žádné služby!</p>
                    </div>
                <?php else: ?>
                    <ul>
                        <?php foreach($services as $one_service): ?>
                                <li>
                                    <div class="one-service">
                                        <p><?= $one_service["name"]; ?></p>
                                        <p>Od <?= $one_service["price"]; ?> Kč</p>
                                    </div>
                                    <?php if($session): ?>
                                        <a href="admin/delete-service.php?id=<?=$one_service["id"] ?>"><button class="delete-btn">Smazat!</button></a>
                                    <?php endif ?>
                                </li>
                        <?php endforeach; ?>
                    </ul> 
                <?php endif; ?>
            </section>
            <section class="gallery">
                <h2 class="gallery-headline">Galerie</h2>

                <?php if($session): ?>
                    <button class="btn create-img">Vytvořit obrázek</button>
                    <article class="create-image">
                        <h2 class="form-title">Vytvořit obrázek</h2>
                        <form action="admin/create-gallery.php" method="POST" enctype="multipart/form-data">
                            <input type="text" 
                                    name = "image_text"
                                    placeholder = "Popis obrázku"
                                    >
                            <input type="file"
                                    name = "image"
                                    >
                            <input type="text"
                                    name = "service"
                                    placeholder = "Servis"
                                    list = "services"
                                    >
                            <datalist id="services">
                                <?php foreach($all_service_names as $one_service): ?> 
                                    <option value="<?= $one_service; ?>">
                                <?php endforeach; ?>
                            </datalist>
                            <input type="submit"
                                    name = "submit"
                                    value = "Uložit"
                                    class="button"
                                    >
                        </form>
                    </article>
                <?php endif ?>

                <article class="gallery-content">
                    <?php foreach( $gallery as $one_image): ?>
                        <div class="one-img">
                            <h3 class="service-name-image"><?= $one_image["service"]; ?></h3>
                            <p class="big-img-text"><?= $one_image["image_text"]; ?></p>
                            <img src="<?= "uploads/Services/" . $one_image["service"] ."/". $one_image["img_name"] ?>" alt="" class="one-image">
                            <br>
                            <?php if($session): ?>
                                <a href="admin/delete-image.php?id=<?=$one_image["id"]?>"><button class="delete-btn">Smazat</button></a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                    <div class="gallery-img-buttons">
                        <i class="fa-solid fa-xmark" id="close"></i>
                        <i class="fa-solid fa-chevron-right" id="right"></i>
                        <i class="fa-solid fa-chevron-left" id="left"></i>
                    </div>
                </article>
                <div class="big-gallery">
                    
                </div>
            </section>
        </div>
        <?php require "assets/header.php"; ?>
    </main>
    <?php require "assets/footer.php"; ?>
</body>
</html>