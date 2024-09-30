<?php
// Inclure le fichier de connexion à la base de données
include '../php_sql/db_connect.php';

// Vérifier si les paramètres 'status' et 'order_id' sont bien passés dans l'URL
if (isset($_GET['status']) && isset($_GET['order_id'])) {
    // Sécuriser les valeurs passées
    $status = $_GET['status'];
    $order_id = intval($_GET['order_id']); // Assurez-vous que order_id soit un entier

    try {
        // Préparer la requête SQL pour mettre à jour le statut de la commande
        $stmt = $db->prepare("UPDATE orders SET order_status = :status WHERE order_id = :order_id");
        // Exécuter la requête avec les paramètres
        $stmt->execute(['status' => $status, 'order_id' => $order_id]);

        // Vérifier si la mise à jour a réussi
        if ($stmt->rowCount() > 0) {
            // Si 'switch' est défini à 'reverse', rediriger vers la prochaine étape
            if (isset($_GET['switch']) && $_GET['switch'] === "reverse") {
                switch ($status) {
                    case 'recue':
                        header("Location: orders.php?order_display=preparation");
                        break;
                    case 'preparation':
                        header("Location: orders.php?order_display=pretes");
                        break;
                    case 'prete':
                        header("Location: orders.php?order_display=livraison");
                        break;
                    case 'livraison':
                        header("Location: orders.php?order_display=terminees");
                        break;
                    case 'terminees':
                        header("Location: orders.php?order_display=archivees");
                        break;
                    default:
                        header("Location: orders.php");
                        break;
                }
            } else {
                // Sinon, rediriger vers l'étape précédente
                switch ($status) {
                    case 'preparation':
                        header("Location: orders.php?order_display=recue");
                        break;
                    case 'prete':
                        header("Location: orders.php?order_display=preparation");
                        break;
                    case 'livraison':
                        header("Location: orders.php?order_display=pretes");
                        break;
                    case 'terminees':
                        header("Location: orders.php?order_display=livraison");
                        break;
                    case 'archivees':
                        header("Location: orders.php?order_display=terminees");
                        break;
                    default:
                        header("Location: orders.php");
                        break;
                }
            }
            exit(); // Assurer que le script s'arrête après la redirection
        } else {
            echo "Aucune mise à jour effectuée. Veuillez vérifier l'ID de la commande.";
        }
    } catch (PDOException $e) {
        // En cas d'erreur dans l'exécution de la requête
        echo "Erreur lors de la mise à jour : " . $e->getMessage();
    }
} else {
    echo "Paramètres manquants.";
}
?>
