<?php 
session_start();

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
</head>

<body><a href="../index.php">Accueil</a>
    <h2>Formulaire de contact</h2>
    <form action="bo_create_ticket.php" method="POST" enctype="multipart/form-data">

        <?php
        // Si l'utilisateur n'est pas connecté, inclure le formulaire pour nom prenom email
        if($_SESSION['loggedIn'] !== 1) {
            include '../tickets/block_user_not_logged_in.html';
        }
        ?>

        <?php
        // SI L'UTILISATEUR EST CONNECTÉ, VÉRIFIER S'IL A UN NUMÉRO DE TÉLÉPHONE ENREGISTRÉ
        if($_SESSION['loggedIn'] == 1) {
            require_once('../php_sql/db_connect.php'); // Inclure le fichier de connexion à la base de données
            
            // Préparer la requête SQL pour récupérer le numéro de téléphone de l'utilisateur connecté
            $sql = "SELECT phone FROM users WHERE user_id = :user_id";
            $query = $db->prepare($sql);
            $query->bindValue(':user_id', $_SESSION['logged_user_id']);
            $query->execute();
            $user = $query->fetch(PDO::FETCH_ASSOC); // Récupérer les résultats de la requête
            
            // Si l'utilisateur n'a pas de numéro de téléphone enregistré, afficher le champ de saisie du téléphone
            
        }

        if(empty($user['phone']) || $_SESSION['loggedIn'] == 0) {
            echo '<br><strong>Bloc affiché si utilisateur non connecté ou si user.phone n\'existe pas</strong><br>
                  <label for="phone">Téléphone :</label>
                  <input type="phone" id="phone" name="phone">
                  <br><br>';
        }
        ?>

        <?php
        // SI L'UTILISATEUR EST CONNECTÉ, RÉCUPÉRER LES COMMANDES ASSOCIÉES À SON COMPTE
        if($_SESSION['loggedIn'] == 1) {
            // Préparer la requête SQL pour récupérer les commandes de l'utilisateur connecté
            $sql = "SELECT * FROM orders WHERE user_id = :user_id";
            $query = $db->prepare($sql);
            $query->bindValue(':user_id', $_SESSION['logged_user_id']);
            $query->execute();
            $user_orders = $query->fetchAll(PDO::FETCH_ASSOC); // Récupérer toutes les commandes de l'utilisateur
        }
        
        // Si l'utilisateur a des commandes, inclure le fichier correspondant
        if(!empty($user_orders)) {
            include '../tickets/block_user_logged_in_and_have_order.php';
        }
        ?>

        <!-- Ce bloc est affiché dans tous les cas -->

        <strong>Seul bloc affiché dans tous les cas</strong><br>
        <label for=" object">Objet :</label>
        <input type="text" id="object" name="object" required />*
        <br><br>

        <label for="message">Message :</label>
        <textarea id="message" name="message" required></textarea>*
        <br><br>
        <input type="submit" value="Envoyer">
    </form>
</body>

</html>