<form method="POST" enctype="multipart/form-data">
    <input  type="text" 
            name="name" 
            placeholder="Jméno" 
            value="<?= htmlspecialchars($name);?>"
            required
    > <br>

    <input  type="text" 
            name="dog_sex" 
            placeholder="Pohlaví psa"
            value="<?= htmlspecialchars($dog_sex);?>" 
            required
            list="dog_sex"
    > <br>

    <datalist id="dog_sex">
        <option>pes</option>
        <option>fena</option>
        <option>štěně</option>
    </datalist>

    <input type="text" 
            name="color" 
            placeholder="Barva" 
            value="<?= htmlspecialchars($color);?>"  
    > <br>

    <input type="number" 
            name="weight" 
            placeholder="Váha"
            value="<?= htmlspecialchars($weight);?>"  
    > <br>

    <input type="number" 
            name="height" 
            placeholder="Výška"
            value="<?= htmlspecialchars($height);?>"  
    > <br>

    <textarea   name="pately" 
                placeholder="Pately" 
                ><?= htmlspecialchars($pately);?></textarea>

    <br>
    
    <textarea   name="body" 
                placeholder="Ocenění" 
                ><?= htmlspecialchars($body);?></textarea>

    <br>

    <input type="file" 
            name="img1" 
            placeholder="1. obrázek" 
            value="<?= $img1;?>"  
    > <br>

    <input type="file" 
            name="img2" 
            placeholder="2. obrázek" 
            value="<?= $img2;?>"  
    > <br>

    <input type="file" 
            name="img3" 
            placeholder="3. obrázek" 
            value="<?= $img3;?>"  
    > <br>

    <input type="submit" class="button" value="Uložit">
</form>
