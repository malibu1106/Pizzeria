<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] != 1) {
    header('Location: ../login.php');
    exit();
}

require_once('../php_sql/db_connect.php');

// Vérifiez que l'order_id est passé dans l'URL
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Préparez la requête SQL pour mettre à jour le statut de la commande
    $sql = "UPDATE orders SET order_status = 'archivée' WHERE order_id = :order_id";
    
    $query = $db->prepare($sql);
    $query->bindParam(':order_id', $order_id, PDO::PARAM_INT);

    // Exécutez la requête
    if ($query->execute()) {
        // Redirigez vers la page d'affichage des commandes après la mise à jour
        header('Location: test_show_orders_as_admin.php');
        exit();
    } else {
        echo 'Erreur lors de la mise à jour du statut de la commande.';
    }
} else {
    echo 'Aucun order_id fourni.';
}
?>