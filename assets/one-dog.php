<article class="dog">
    <div class="dog-name">
        <h2>
            <?= $one_dog["name"]; ?>
        </h2>
    </div>
    <div class="dog-color">
        <p>
            Barva: <?= $one_dog["color"]; ?>
        </p>
    </div>
    <div class="dog-wight">
        <p>
            Váha: <?= $one_dog["weight"];?> kg
        </p>
    </div>
    <div class="dog-height">
        <p>
            Výška: <?= $one_dog["height"]; ?> cm
        </p>
    </div>
    <div class="dog-pately">
        <p>
            Pately: <?= $one_dog["pately"]; ?>
        </p>
    </div>
    <div class="dog-body">
        <p>
            Ocenění: <?= $one_dog["body"]; ?>
        </p>
    </div>
    <div class="dog-imgs">
        <img src="<?="uploads/Dogs/" . $one_dog["name"] . "/" . $one_dog["img1"]; ?>" class="dog-img" alt=""> 
        <img src="<?="uploads/Dogs/" .$one_dog["name"] . "/" . $one_dog["img2"]; ?>" class="dog-img" alt="">
        <img src="<?="uploads/Dogs/" .$one_dog["name"] . "/" . $one_dog["img3"]; ?>" class="dog-img" alt="">
    </div>

    <?php if($session): ?>
        <div class="admin-buttons">
            <a href="admin/edit-dog.php?id=<?= $one_dog["id"] ?>"><button class="edit-dog-btn">Upravit</button></a>
            <a href="admin/delete-dog.php?id=<?= $one_dog["id"] ?>&dog_name=<?= $one_dog["name"] ?>"><button class="delete-btn">Smazat</button></a>
        </div>
    <?php endif; ?>
</article>