<?php 
session_start();
$_SESSION['loggedIn'] = 1; // TEMP : Réglage temporaire pour indiquer l'état de connexion
$_SESSION['logged_user_id'] = 1; // TEMP : Réglage temporaire pour stocker l'ID de l'utilisateur connecté
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Affichage des commandes</title>
    <!-- Inclure Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../css/backoffice.css">

    <!-- Ajouter du JavaScript pour soumettre le formulaire automatiquement -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('order_date');

        // Soumettre automatiquement le formulaire dès que l'utilisateur change la date
        dateInput.addEventListener('change', function() {
            this.form.submit();
        });
    });
    </script>
</head>

<body>
    <!-- Barre de navigation -->
    <?php include 'backoffice_nav.php';
    require_once ('../php_sql/db_connect.php');?>

    <!-- Filtrage des commandes -->
    <div class="d-flex justify-content-evenly mt-4 mb-4 mx-auto">
        <a href="orders.php?order_display=recue" class="btn btn-dark fw-bold fs-4">Reçues</a>
        <a href="orders.php?order_display=preparation" class="btn btn-warning text-white fw-bold fs-4">En
            préparation</a>
        <a href="orders.php?order_display=pretes" class="btn btn-danger fw-bold fs-4">Prêtes</a>
        <a href="orders.php?order_display=livraison" class="btn btn-primary fw-bold fs-4">En livraison</a>
        <a href="orders.php?order_display=terminees" class="btn btn-success fw-bold fs-4">Terminées</a>
        <a href="orders.php?order_display=archivees" class="btn btn-secondary text-white fw-bold fs-4">Archivées</a>
    </div>

    <?php
    // Récupérer la valeur de 'order_display' si elle est définie
    $orderDisplay = isset($_GET['order_display']) ? $_GET['order_display'] : '';


    



// Récupération de l'état de la commande depuis l'URL
$order_display = isset($_GET['order_display']) ? $_GET['order_display'] : 'recue';

// Switch pour inclure les bons fichiers en fonction de l'état de la commande
switch ($order_display) {
    case 'recue':
        include 'orders_modules/recue.php';
        break;
    case 'preparation':
        include 'orders_modules/preparation.php';
        break;
    case 'pretes':
        include 'orders_modules/pretes.php';
        break;
    case 'livraison':
        include 'orders_modules/livraison.php';
        break;
    case 'terminees':
        include 'orders_modules/terminees.php';
        break;
    case 'archivees':
        include 'orders_modules/archivees.php';
        break;
    default:
        // Valeur par défaut si aucun état valide n'est fourni
        include 'orders_modules/recue.php';
        break;
}
?>




</body>

</html>