<?php
require_once('../php_sql/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['order_status'];

    // Préparation de la requête pour mettre à jour le statut de la commande
    $sql = "UPDATE orders SET order_status = :new_status WHERE order_id = :order_id";
    $query = $db->prepare($sql);
    $query->bindValue(':new_status', $new_status);
    $query->bindValue(':order_id', $order_id);

    if ($query->execute()) {
        // Vérification de l'existence du paramètre $_GET['order_display']
        $redirect_url = 'orders.php';
        if (isset($_GET['order_display'])) {
            $redirect_url .= '?order_display=' . $_GET['order_display'];
        }
        
        // Redirection après la mise à jour avec le paramètre GET
        header('Location: ' . $redirect_url);
        exit;
    } else {
        echo "Erreur lors de la mise à jour du statut.";
    }
}
?>