<form method="POST">
    <input  type="text" 
            name="name" 
            placeholder="Název služby" 
            value="<?= htmlspecialchars($name)  ?>"
            required
    >

    <input  type="text" 
            name="link" 
            placeholder="Odkaz"
            value="<?= htmlspecialchars($link) ?>" 
            required
    >
    <input  type="text" 
            name="text" 
            placeholder="Text"
            value="<?= htmlspecialchars($text) ?>" 
            required
    >

    <input type="submit" value="Uložit">
</form>