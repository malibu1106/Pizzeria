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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid d-flex align-items-center">
            <p class="text-white fw-bold fs-3 mb-0">Tableau de bord</p> <!-- Centré et plus gros/gras -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Retour au site</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../back_office/backoffice.php">Gestion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Filtrage des commandes -->
    <div class="d-flex justify-content-between mt-4 mb-4 w-75 mx-auto">
        <a href="orders.php" class="btn btn-primary">En cours</a>
        <a href="orders.php?order_display=pretes" class="btn btn-primary">Prêtes</a>
        <a href="orders.php?order_display=livraisons" class="btn btn-primary">En livraison</a>
        <a href="orders.php?order_display=terminees" class="btn btn-primary">Terminées</a>
        <a href="orders.php?order_display=archivees" class="btn btn-primary">Commandes archivées</a>
    </div>

    <?php
// Récupérer la valeur de 'order_display' si elle est définie
$orderDisplay = isset($_GET['order_display']) ? $_GET['order_display'] : '';

// Affichage du formulaire si la valeur de 'order_display' est 'terminees', 'all' ou 'archivees'
if ($orderDisplay === 'terminees' || $orderDisplay === 'all' || $orderDisplay === 'archivees'): ?>
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

    <?php endif;

    // Si 'order_display' n'est pas défini, ajouter deux <br>
    if (!isset($_GET['order_display'])) {
    echo '<br><br>';
    }
    ?>

    <div class="row">
        <!-- Début de la grille Bootstrap -->

        <?php
        require_once('../php_sql/db_connect.php');

        // Par défaut, on montre les commandes "en cours"
$whereClause = "(o.order_status = 'en préparation')";

// Si un paramètre GET 'order_display' est passé, on ajuste la requête
if (isset($_GET['order_display'])) {
    switch ($_GET['order_display']) {
        case 'pretes':
            // Filtrer uniquement les commandes terminées
            $whereClause = "o.order_status = 'prête'";
            break;
        case 'livraisons':
            // Filtrer uniquement les commandes en cours de livraison
            $whereClause = "(o.is_delivery = 1 AND o.order_status = 'partie')";
            break;
            case 'terminees':
                // Filtrer uniquement les commandes terminées
                $whereClause = "o.paid = 1 AND o.order_status = 'partie' AND (o.is_delivery = 1 AND o.is_delivery_complete = 1 OR o.is_delivery = 0)";
                break;
        case 'archivees':
            // Filtrer uniquement les commandes archivées
            $whereClause = "o.order_status = 'archivée'";
            break;
        default:
            // Filtrer les commandes "en cours" par défaut
            $whereClause = "(o.order_status = 'en cours')";
            break;
    }
}

// Ajouter un filtrage par date si une date est sélectionnée et applicable
if (isset($_GET['order_date']) && !empty($_GET['order_date']) && ($orderDisplay === 'terminees' || $orderDisplay === 'all' || $orderDisplay === 'archivees')) {
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
        o.is_delivery,
        o.is_delivery_complete, 
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
                    case 'en préparation':
                        $statusClass = 'bg-warning';
                        break;
                    case 'prête':
                        $statusClass = 'bg-danger';
                        break;
                    case 'partie':
                        $statusClass = 'bg-primary';
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
                echo '<table class="table table-bordered ">';
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
            <td>Status : '.$order['order_status'].'</td>


        </tr>';
        echo '<tr>
        <td colspan="2">Délivrance : ' . ($order['is_delivery'] == 1 ? 'Livraison' : 'À emporter') . '</td>
        <td>' . ($order['is_delivery'] == 1 
            ? ($order['is_delivery_complete'] == 1 ? 'Livrée' : 'En cours') 
            : ($order['is_delivery_complete'] == 1 ? 'Récupérée' : 'À récupérer')) . '</td>
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
        echo '
    </div>'; // Fin de la dernière colonne
    }
    ?>


        <!-- Modal pour changer le statut -->
        <?php foreach ($user_orders as $order) : ?>
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
                                    <option value="en préparation"
                                        <?= ($order['order_status'] == "en préparation" ? 'selected' : '') ?>>En cours
                                    </option>
                                    <option value="prête" <?= ($order['order_status'] == "prête" ? 'selected' : '') ?>>
                                        Prête
                                    </option>
                                    <option value="partie"
                                        <?= ($order['order_status'] == "partie" ? 'selected' : '') ?>>Partie
                                    </option>
                                    <option value="terminée"
                                        <?= ($order['is_delivery_complete'] == 1 ? 'selected' : '') ?>>
                                        Terminée</option>
                                    <option value="archivée"
                                        <?= ($order['order_status'] == "archivée" ? 'selected' : '') ?>>Archivée
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