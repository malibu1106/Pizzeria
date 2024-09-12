<?php
session_start();

if (isset($_POST) && !empty($_POST['name']) && !empty($_POST['description']) && isset($_POST['extra_price'])) {
    
    // CONNEXION À LA BASE DE DONNÉES
    require_once('../php_sql/db_connect.php');

    // POST VALUES
    $name = strip_tags($_POST['name']);
    $description = strip_tags($_POST['description']);
    $extra_price = strip_tags($_POST['extra_price']);

    // INSERT INTO DATABASE
    $sql = "INSERT INTO pizzas_sizes (name, description, extra_price)
            VALUES (:name, :description, :extra_price)";

    $query = $db->prepare($sql);
    $query->bindValue(':name', $name);
    $query->bindValue(':description', $description);
    $query->bindValue(':extra_price', $extra_price);

    // Exécution de la requête
    if ($query->execute()) {
        $_SESSION['info_message'] = "La taille a bien été ajoutée.";
    } else {
        $_SESSION['info_message'] = "Erreur lors de l'ajout de la taille.";
    }

} else {
    $_SESSION['info_message'] = "Le formulaire n'a pas été rempli correctement.";
}

header('Location: test_create_size.php'); // Redirection vers la page du formulaire
exit();
?>