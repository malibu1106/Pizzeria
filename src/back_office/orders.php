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

<body class="container my-4">
    <div class="d-flex justify-content-between mb-4">
        <a href="../index.php" class="btn btn-primary">Retour au site</a>
        <a href="../back_office/backoffice.php" class="btn btn-primary">Accueil - Gestion</a>
    </div>
    <!-- Filtrage des commandes -->
    <div class="d-flex justify-content-between mb-4 w-50 mx-auto">
        <a href="orders.php" class="btn btn-primary">En cours</a>
        <a href="orders.php?order_display=all" class="btn btn-primary">Toutes les commandes</a>
        <a href="orders.php?order_display=archivée" class="btn btn-primary">Commandes archivées</a>
    </div>
    <?php
// Récupérer la valeur de 'order_display' si elle est définie
$orderDisplay = isset($_GET['order_display']) ? $_GET['order_display'] : '';

// Affichage du formulaire si la valeur de 'order_display' est 'all' ou 'archivée'
if ($orderDisplay === 'all' || $orderDisplay === 'archivée'): ?>
    <!-- Formulaire pour filtrer par date -->
    <form action="orders.php" method="GET" class="mb-4 w-50 mx-auto">
        <div class="form-check d-flex justify-content-around align-items-center">
            Filtrer par date :
            <input type="date" name="order_date" id="order_date" class="form-control w-25"
                value="<?= isset($_GET['order_date']) ? htmlspecialchars($_GET['order_date']) : date('Y-m-d') ?>">
        </div>
        <!-- Conserver l'état actuel de order_display -->
        <input type="hidden" name="order_display" value="<?= htmlspecialchars($orderDisplay) ?>">
    </form>

    <?php
endif;

// Si 'order_display' n'est pas défini, ajouter deux <br>
if (!isset($_GET['order_display'])) {
    echo '<br><br>';
}
?>

    <div class="row">
        <!-- Début de la grille Bootstrap -->

        <?php
        require_once('../php_sql/db_connect.php');

        // Par défaut, on montre les commandes "A faire - Payée" et "A faire - Non payée"
$whereClause = "o.order_status = 'A faire - Payée' OR o.order_status = 'A faire - Non payée'";

// Si un paramètre GET 'order_display' est passé, on ajuste la requête
if (isset($_GET['order_display'])) {
    if ($_GET['order_display'] === 'all') {
        // Si 'all' est passé, on exclut seulement les commandes archivées
        $whereClause = "o.order_status != 'archivée'";
    } elseif ($_GET['order_display'] === 'archivée') {
        // Si 'archivée' est passé, on prend seulement les commandes archivées
        $whereClause = "o.order_status = 'archivée'";
    }
}

// Ajouter un filtrage par date si une date est sélectionnée
if (isset($_GET['order_date']) && !empty($_GET['order_date'])) {
    $selectedDate = $_GET['order_date'];
    $whereClause .= " AND DATE(o.date_order) = '$selectedDate'";
}


// Construction de la requête SQL avec la clause WHERE
$sql = "
    SELECT 
        o.order_id, 
        o.date_order, 
        o.order_status, 
        o.total,
        o.payment_method, 
        u.first_name, 
        u.last_name, 
        u.email,
        u.phone, 
        IF(ci.dish_id = 0, cp.custom_pizza_id, d.dish_id) as dish_id,  
        IF(ci.dish_id = 0, cp.name, d.name) as dish_name,               
        IF(ci.dish_id = 0, cp.price, d.price) as dish_price,            
        ci.quantity as dish_quantity,
        IF(ci.dish_id = 0, p_p.name, p_p2.name) as pate_name,           
        IF(ci.dish_id = 0, p_s.name, p_s2.name) as size_name,           
        IF(ci.dish_id = 0, p_b.name, p_b2.name) as base_name,           
        IF(ci.dish_id = 0, 'custom', 'standard') as dish_type           
    FROM orders o
    JOIN cart_items ci ON o.cart_id = ci.cart_id
    JOIN users u ON o.user_id = u.user_id  

    LEFT JOIN dishes d ON ci.dish_id = d.dish_id
    LEFT JOIN pizzas_pates p_p2 ON d.pate_id = p_p2.pizza_pate_id
    LEFT JOIN pizzas_sizes p_s2 ON d.size_id = p_s2.pizza_size_id
    LEFT JOIN pizzas_bases p_b2 ON d.base_id = p_b2.pizza_base_id

    LEFT JOIN custom_pizzas cp ON ci.custom_pizza_id = cp.custom_pizza_id
    LEFT JOIN pizzas_pates p_p ON cp.pate_id = p_p.pizza_pate_id
    LEFT JOIN pizzas_sizes p_s ON cp.size_id = p_s.pizza_size_id
    LEFT JOIN pizzas_bases p_b ON cp.base_id = p_b.pizza_base_id

    WHERE $whereClause
    ORDER BY o.order_id, dish_name
";

        $query = $db->prepare($sql);
        $query->execute();
        $user_orders = $query->fetchAll(PDO::FETCH_ASSOC);

        $current_order_id = null;

        foreach ($user_orders as $order) {
            if ($current_order_id !== $order['order_id']) {
                if ($current_order_id !== null) {
                    echo '<tr><td colspan="2">Réglement : '.$previous_order_payment.'</td><td><strong>Total : '.$previous_order_total.'€</strong></td></tr>';
                    echo '</tbody></table><br><br>';
                    echo '</div>'; // Fin de la colonne
                }
                $current_order_id = $order['order_id'];
                $previous_order_total = $order['total'];
                $previous_order_payment = $order['payment_method'];  // Store the payment method of the current order

                // Déterminer la classe Bootstrap en fonction du statut
                $statusClass = '';
                switch ($order['order_status']) {
                    case 'A faire - Non payée':
                        $statusClass = 'bg-warning';
                        $statusInfo = 'A faire - <span class="text-danger text-uppercase fw-bold">Non payée</span>';
                        break;
                    case 'A faire - Payée':
                        $statusClass = 'bg-warning';
                        $statusInfo = 'A faire - <span class="text-success text-uppercase fw-bold">Payée</span>';
                        break;
                    case 'Faite - Non payée':
                        $statusClass = 'bg-success';
                        $statusInfo = 'Faite - <span class="text-danger text-uppercase fw-bold">Non payée</span>';
                        break;
                    case 'Faite - Payée':
                        $statusClass = 'bg-success';
                        $statusInfo = 'Faite - <span class="text-success text-uppercase fw-bold">Payée</span>';
                        break;
                    case 'En attente':
                        $statusClass = 'bg-dark text-white';
                        $statusInfo = '<span class="text-warning text-uppercase fw-bold">En attente</span>';
                        break;
                    case 'Terminée':
                        $statusClass = 'bg-primary';
                        $statusInfo = '<span class="text-primary text-uppercase fw-bold">Terminée</span>';
                        break;
                    case 'Archivée':
                        $statusClass = 'bg-dark text-white';
                        $statusInfo = '<span class="">Archivée</span>';
                        break;
                    default:
                        $statusClass = 'bg-light';  // Default color if status is unknown
                        $statusInfo = '<span class="text-warning text-uppercase fw-bold">Inconnu</span>';
                        break;
                }

    $action_url = "update_order_status.php";

    // Si le paramètre 'order_display' existe dans l'URL
    if (isset($_GET['order_display'])) {
        if ($_GET['order_display'] === 'all') {
            // Ajouter 'all' dans l'URL
            $action_url .= "?order_display=all";
        } elseif ($_GET['order_display'] === 'archivée') {
            // Ajouter 'archivée' dans l'URL
            $action_url .= "?order_display=archivée";
        }
    }


                // Nouvelle colonne pour chaque commande
                echo '<div class="col-12 col-md-6 mb-4">'; // Colonne qui prend 100% de la largeur sur petits écrans, et 50% sur les grands
                echo '<table class="table table-bordered">';
                echo '<thead class="'.$statusClass.'"><tr><th colspan="3">
                <div class="d-flex justify-content-between">Commande n°'.$order['order_id'].' - '.$order['first_name'].' '.$order['last_name'].'
                    <div class="order_actions d-flex gap-2">
                    <a href="print_order.php?order_id='.$order['order_id'].'"><img src="../img/icons/order_print.png"
                alt="imprimer la commande"></a>
                
    <img src="../img/icons/order_edit_status.png" alt="éditer le status de la commande" data-bs-toggle="modal" data-bs-target="#editStatusModal-'.$order['order_id'].'">
        
    </div>
    </div>
    </th>
    </tr>
    </thead>';
    echo '<tbody>';
        echo '<tr>
            <td>Tel : '.$order['phone'].'</td>
            <td colspan="2">Mail : '.$order['email'].'</td>
        </tr>';
        echo '<tr>
            <td colspan="2">Date : '.date('d/m/Y H:i', strtotime($order['date_order'])).'</td>
            <td>Status : '.$statusInfo.'</td>


        </tr>';
        }

        echo '<tr>';
            echo '<td colspan="3">'.$order['dish_quantity'].' X '.$order['dish_name'].' : '.$order['size_name'].',
                '.$order['pate_name'].', '.$order['base_name'].'</td>';
            echo '</tr>';

        $subtotal = $order['dish_price'] * $order['dish_quantity'];

        if ($order['dish_type'] === 'custom') {
        $custom_pizza_id = $order['dish_id'];
        $sql_ingredients = "
        SELECT i.name
        FROM custom_pizzas_ingredients cpi
        JOIN ingredients i ON cpi.ingredient_id = i.ingredient_id
        WHERE cpi.custom_pizza_id = :custom_pizza_id
        ";

        $query_ingredients = $db->prepare($sql_ingredients);
        $query_ingredients->bindValue(':custom_pizza_id', $custom_pizza_id);
        $query_ingredients->execute();
        $ingredients = $query_ingredients->fetchAll(PDO::FETCH_ASSOC);
        } else {
        $dish_name = $order['dish_name'];
        $sql_ingredients = "
        SELECT i.name
        FROM dish_ingredients di
        JOIN ingredients i ON di.ingredient_id = i.ingredient_id
        WHERE di.dish_name = :dish_name
        ";

        $query_ingredients = $db->prepare($sql_ingredients);
        $query_ingredients->bindValue(':dish_name', $dish_name);
        $query_ingredients->execute();
        $ingredients = $query_ingredients->fetchAll(PDO::FETCH_ASSOC);
        }

        echo '<tr>';
            echo '<td colspan="3">';
                $ingredient_names = array_column($ingredients, 'name');
                echo implode(', ', $ingredient_names);
                echo '</td>';
            echo '</tr>';

        echo '<tr>';
            echo '<td>Prix Unitaire : '.$order['dish_price'].'€</td>';
            echo '<td colspan="2">Sous-total : '.$subtotal.'€</td>';
            echo '</tr>';
        }

        if ($current_order_id !== null) {
        echo '<tr>
            <td colspan="2">Réglement : '.$previous_order_payment.'</td>
            <td><strong>Total : '.$previous_order_total.'€</strong></td>
        </tr>';
        echo '</tbody>
    </table>';
    echo '</div>'; // Fin de la dernière colonne
    }
    ?>


        <?php foreach ($user_orders as $order) : ?>
        <!-- Modal pour changer le statut -->
        <div class="modal fade" id="editStatusModal-<?=$order['order_id']?>" tabindex="-1"
            aria-labelledby="editStatusLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editStatusLabel">Modifier le statut de la commande
                            n°<?=$order['order_id']?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="<?=$action_url?>" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="order_id" value="<?=$order['order_id']?>">
                            <div class="mb-3">
                                <label for="orderStatus" class="form-label">Nouveau statut :</label>
                                <select class="form-select" name="order_status" id="orderStatus">
                                    <option value="A faire - Non payée"
                                        <?= ($order['order_status'] == "A faire - Non payée" ? 'selected' : '') ?>>A
                                        faire -
                                        Non payée</option>
                                    <option value="A faire - Payée"
                                        <?= ($order['order_status'] == "A faire - Payée" ? 'selected' : '') ?>>A faire -
                                        Payée</option>
                                    <option value="Faite - Non payée"
                                        <?= ($order['order_status'] == "Faite - Non payée" ? 'selected' : '') ?>>Faite -
                                        Non
                                        payée</option>
                                    <option value="Faite - Payée"
                                        <?= ($order['order_status'] == "Faite - Payée" ? 'selected' : '') ?>>Faite -
                                        Payée
                                    </option>
                                    <option value="En attente"
                                        <?= ($order['order_status'] == "En attente" ? 'selected' : '') ?>>En attente
                                    </option>
                                    <option value="Terminée"
                                        <?= ($order['order_status'] == "Terminée" ? 'selected' : '') ?>>Terminée
                                    </option>
                                    <option value="Archivée"
                                        <?= ($order['order_status'] == "Archivée" ? 'selected' : '') ?>>Archivée
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div> <!-- Fin de la grille Bootstrap -->
</body>

</html>