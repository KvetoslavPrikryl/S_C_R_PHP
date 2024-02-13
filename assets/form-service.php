<form method="POST">
    <input  type="text" 
            name="name" 
            placeholder="Název služby" 
            value="<?= htmlspecialchars($name)  ?>"
            required
    >

    <input  type="number" 
            name="price" 
            placeholder="Cena"
            value="<?= htmlspecialchars($price) ?>" 
            required
    >

    <input type="submit" value="Uložit">
</form>