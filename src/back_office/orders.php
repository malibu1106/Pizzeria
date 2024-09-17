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
    <div class="d-flex justify-content-evenly mt-4 mb-4 mx-auto">
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
    if (in_array($orderDisplay, ['terminees', 'all', 'archivees'])): ?>
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
    <?php endif; ?>

    <div class="row">
        <!-- Début de la grille Bootstrap -->

        <?php
        require_once('../php_sql/db_connect.php');

        // Par défaut, on montre les commandes "en cours"
        $whereClause = "(o.order_status = 'en préparation')";

        // Si un paramètre GET 'order_display' est passé, on ajuste la requête
        switch ($orderDisplay) {
            case 'pretes':
                $whereClause = "o.order_status = 'prête'";
                break;
            case 'livraisons':
                $whereClause = "(o.is_delivery = 1 AND o.order_status = 'partie')";
                break;
            case 'terminees':
                $whereClause = "o.is_paid = 1 AND o.order_status = 'partie' AND (o.is_delivery = 1 AND o.is_delivery_complete = 1 OR o.is_delivery = 0)";
                break;
            case 'archivees':
                $whereClause = "o.order_status = 'archivée'";
                break;
        }

        // Ajouter un filtrage par date si une date est sélectionnée et applicable
        if (isset($_GET['order_date']) && !empty($_GET['order_date']) && in_array($orderDisplay, ['terminees', 'all', 'archivees'])) {
            $selectedDate = htmlspecialchars($_GET['order_date']);
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
                o.is_paid,
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
        echo '<div class="container w-75">';

        foreach ($user_orders as $order) {
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
                    $statusClass = 'bg-light';
                    break;
            }

            if ($current_order_id !== $order['order_id']) {
                if ($current_order_id !== null) {
                    echo '<tr><td colspan="7" class="">Réglement : '.$previous_order_payment.'</td>
                    <td class="text-center font-weight-bold" style="font-weight: bold;">';
                
                    if ($previous_order_paid === 1) {
                        echo '<span class="text-success">PAYÉE</span>';
                    } else {
                        echo '<span class="text-danger">NON PAYÉE</span>';
                    }
                
                    echo '</td></tr>';
                }
                
                $current_order_id = $order['order_id'];
                $previous_order_payment = $order['payment_method'];
                $previous_order_paid = $order['is_paid'];
                
                echo '
                <table class="table table-bordered">
                    <thead class="'.$statusClass.'">
                        <tr>
                            <th scope="col">Commande n°' . $order['order_id'] . '</th>
                            <th scope="col">Date</th>
                            <th scope="col">Nom du client</th>
                            <th scope="col">Email</th>
                            <th scope="col">Téléphone</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>' . $order['order_id'] . '</td>
                            <td>' . (new DateTime($order['date_order']))->format('d/m/y H:i') . '</td>
                            <td>' . $order['first_name'] . ' ' . $order['last_name'] . '</td>
                            <td>' . $order['email'] . '</td>
                            <td>' . $order['phone'] . '</td>
                            <td>' . $order['order_status'] . '</td>
                        </tr>
                    </tbody>
                </table>';
                
                echo '
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Quantité</th>
                            <th scope="col">Plat</th>
                            <th scope="col">Pâte</th>
                            <th scope="col">Taille</th>
                            <th scope="col">Base</th>                                
                            <th scope="col">Prix unitaire</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>';
            }
            
            echo '<tr>
                <td>' . $order['dish_quantity'] . '</td>
                <td>' . $order['dish_name'] . '</td>
                <td>' . $order['pate_name'] . '</td>
                <td>' . $order['size_name'] . '</td>
                <td>' . $order['base_name'] . '</td>                    
                <td>' . number_format($order['dish_price'], 2) . ' €</td>
                <td>' . number_format($order['dish_quantity'] * $order['dish_price'], 2) . ' €</td>
            </tr>';
            
            $previous_order_id = $order['order_id'];
            $previous_order_paid = $order['is_paid'];
            $previous_order_payment = $order['payment_method'];
        }
        
        if (isset($previous_order_id) && $previous_order_id !== null) {
            echo '<tr><td colspan="7" class="">Réglement : '.$previous_order_payment.'</td>
            <td class="text-center font-weight-bold" style="font-weight: bold;">';
            
            if ($previous_order_paid === 1) {
                echo '<span class="text-success">PAYÉE</span>';
            } else {
                echo '<span class="text-danger">NON PAYÉE</span>';
            }
        
            echo '</td></tr>
            </tbody></table></div>';
        }
        ?>
    </div>

</body>

</html>