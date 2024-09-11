<?php
// ON DEMARRE DIRECTEMENT UNE SESSION POUR GERER LES MESSAGES A AFFICHER EN CAS DE PROBLEME
session_start();

if (isset($_POST) && !empty($_POST['name']) && !empty($_POST['description']) && !empty($_FILES['image_url']) && isset($_POST['extra_price'])) {
    
    // CONNEXION + MESSAGE TEMPORAIRE
    require_once('../php_sql/db_connect.php');

    // POST VALUES
    $name = strip_tags($_POST['name']);
    $description = strip_tags($_POST['description']);
    $image_url = strip_tags($_FILES['image_url']['name']);
    $extra_price = strip_tags($_POST['extra_price']);
    $is_available = isset($_POST['is_available']) ? 1 : 0; // Checkbox, si cochée = 1
    $is_bio = isset($_POST['is_bio']) ? 1 : 0; // Checkbox, si cochée = 1
    $is_allergen = isset($_POST['is_allergen']) ? 1 : 0; // Checkbox, si cochée = 1

    // GESTION DE L'IMAGE
    $uploadDir = '../img/ingredients/'; // Dossier où l'on stockera les images des ingrédients
    $imageFileType = strtolower(pathinfo($_FILES['image_url']['name'], PATHINFO_EXTENSION)); // Extension du fichier uploadé
    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif'); // Extensions autorisées

    // Check if the file is an allowed image type
    if (in_array($imageFileType, $allowedTypes)) { // Si l'extension du fichier uploadé est autorisée
        $newFileName = 'Ingredient_' . $name . '.' . $imageFileType;
        $image_filename = $uploadDir . $newFileName;
        move_uploaded_file($_FILES['image_url']['tmp_name'], $image_filename); // On stocke l'image dans le dossier
    } else {
        echo 'Extension d\'image incorrecte'; // ERREUR SESSION ICI
        $_SESSION['info_message'] = "Extension d'image incorrecte";
        header('Location: test_create_ingredient.php'); // Redirige l'utilisateur
        exit();
    }

    // INSERT INTO DATABASE
    $sql = "INSERT INTO ingredients (name, description, image_url, extra_price, is_available, is_bio, is_allergen)
            VALUES (:name, :description, :image_url, :extra_price, :is_available, :is_bio, :is_allergen)";

    $query = $db->prepare($sql);
    $query->bindValue(':name', $name);
    $query->bindValue(':description', $description);
    $query->bindValue(':image_url', $image_filename);
    $query->bindValue(':extra_price', $extra_price);
    $query->bindValue(':is_available', $is_available);
    $query->bindValue(':is_bio', $is_bio);
    $query->bindValue(':is_allergen', $is_allergen);

    // Exécution de la requête
    if ($query->execute()) {
        $_SESSION['info_message'] = "L'ingrédient a bien été ajouté.";
    } else {
        $_SESSION['info_message'] = "Erreur lors de l'ajout de l'ingrédient.";
    }

} else {
    $_SESSION['info_message'] = "Le formulaire n'a pas été rempli correctement.";
}

header('Location: test_create_ingredient.php'); // Redirige vers la page du formulaire (ou une autre page)
exit(); // Bonne pratique d'ajouter un exit après un header pour arrêter l'exécution
?>