<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Impression de la commande</title>
    <!-- Inclure Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/backoffice.css">
    <style>
    @media print {

        /* Cacher le bouton d'impression lors de l'impression */
        .print-button {
            display: none;
        }
    }

    /* Centrer la table */
    .table-container {
        display: flex;
        justify-content: center;
    }
    </style>
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
                    <li class="navbar-nav ms-auto">
                        <button class="btn btn-primary" onclick="window.print()">Imprimer cette commande</button>
                    </li>
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

    <?php
        require_once('../php_sql/db_connect.php');

        // Vérifier si l'ID de la commande est passé dans l'URL
        if (isset($_GET['order_id'])) {
            $order_id = $_GET['order_id'];

            // Requête SQL pour récupérer les informations de la commande spécifique
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

            WHERE o.order_id = :order_id
            ORDER BY dish_name
            ";

            $query = $db->prepare($sql);
            $query->bindValue(':order_id', $order_id);
            $query->execute();
            $order_details = $query->fetchAll(PDO::FETCH_ASSOC);

            if ($order_details) {
                $current_order = $order_details[0]; // Récupérer les infos générales de la commande

                // Conteneur pour centrer la table
                echo '<div class="container w-100 w-md-75 w-lg-50">';
                // Ajouter les classes Bootstrap pour la largeur responsive
                echo '<table class="table table-bordered mt-5 ">';
                echo '<thead class="table-dark"><tr><th colspan="3">
                <div class="d-flex justify-content-between">Commande n°'.$current_order['order_id'].' - '.$current_order['first_name'].' '.$current_order['last_name'].'</div>
                </th></tr></thead>';
                echo '<tbody>';
                echo '<tr><td>Tel : '.$current_order['phone'].'</td><td colspan="2">Mail : '.$current_order['email'].'</td></tr>';
                echo '<tr><td colspan="2">Date : '.$current_order['date_order'].'</td><td>Status : '.$current_order['order_status'].'</td></tr>';

                // Afficher les plats commandés
                foreach ($order_details as $item) {
                    echo '<tr>';
                    echo '<td colspan="3">'.$item['dish_quantity'].' X '.$item['dish_name'].' : '.$item['size_name'].', '.$item['pate_name'].', '.$item['base_name'].'</td>';
                    echo '</tr>';

                    // Sous-total pour chaque plat
                    $subtotal = $item['dish_price'] * $item['dish_quantity'];

                    // Afficher les ingrédients
                    if ($item['dish_type'] === 'custom') {
                        $custom_pizza_id = $item['dish_id'];
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
                        $dish_name = $item['dish_name'];
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

                    echo '<tr><td colspan="3">';
                    $ingredient_names = array_column($ingredients, 'name');
                    echo implode(', ', $ingredient_names);
                    echo '</td></tr>';

                    echo '<tr><td>Prix Unitaire : '.$item['dish_price'].'€</td><td colspan="2">Sous-total : '.$subtotal.'€</td></tr>';
                }

                echo '<tr><td colspan="2">Réglement : '.$current_order['payment_method'].'</td><td><strong>Total : '.$current_order['total'].'€</strong></td></tr>';
                echo '</tbody></table>';
                echo '</div>'; // Fermeture du conteneur
            } else {
                echo "<p>Aucune commande trouvée.</p>";
            }
        } else {
            echo "<p>ID de commande non spécifié.</p>";
        }
    ?>
</body>

</html>