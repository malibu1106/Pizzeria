<?php 
session_start();
if(!empty($_SESSION['info_message'])){
    echo $_SESSION['info_message'];
} 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <h2>Formulaire d'inscription</h2>
    <form action="bo_create_user.php" method="POST" enctype="multipart/form-data">
        <label for="first_name">Prénom :</label>
        <input type="text" id="first_name" name="first_name" required>
        <br><br>
        
        <label for="last_name">Nom :</label>
        <input type="text" id="last_name" name="last_name" required>
        <br><br>
        
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>
        <br><br>
        
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        <br><br>
        
        <input type="submit" value="S'inscrire">
    </form>
</body>
</html>