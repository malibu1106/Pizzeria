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
// Requête pour récupérer les informations des commandes et des utilisateurs associés
$sql = "
SELECT 
    orders.*, 
    users.first_name, 
    users.last_name, 
    users.phone,
    users.email,
    GROUP_CONCAT(cart_items.dish_id) AS dish_ids,
    GROUP_CONCAT(cart_items.custom_pizza_id) AS custom_pizza_ids,
    SUM(cart_items.quantity) AS total_quantity 
FROM orders
JOIN users ON orders.user_id = users.user_id
JOIN cart_items ON orders.cart_id = cart_items.cart_id
WHERE order_status = 'terminee'
GROUP BY orders.order_id
ORDER BY orders.order_id DESC
";

$query = $db->prepare($sql);
$query->execute();
$orders = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Contenu principal -->
<div class="container p-4 d-flex mw-100 gap-4 justify-content-center">
    <?php foreach ($orders as $order): 
        // Formatage de la date de commande
        $dateFormatted = date('d/m/y H:i', strtotime($order['date_order']));
        
        // Choix de l'image de livraison ou à emporter
        $image_delivrance = $order['is_delivery'] === 1 ? 
            '<img src="../img/icons/orders/scooter.png" class="img-fluid" style="max-height: 50px;" alt="Image de livraison">' :
            '<img src="../img/icons/orders/take_away.png" class="img-fluid" style="max-height: 50px;" alt="Image à emporter">';
    ?>

    <!-- Carte de la commande -->
    <div class="col-md-6">
        <div class="card mb-3 border-warning">
            <!-- En-tête de la carte -->
            <div class="card-header bg-success text-white text-center">
                Commande n°<?= $order['order_id']; ?>
            </div>

            <!-- Corps de la carte -->
            <div class="card-body p-1">

                <!-- Informations sur la commande -->
                <div class="list-unstyled mt-2">
                    
                    
                </div>

                

                <!-- Contenu de la commande -->
                <div class="list-unstyled mt-2">
                <span class="position-absolute end-0 top-0 px-4 py-5"><?= $image_delivrance ?></span>
                    <p class="text-center fw-bold">Contenu commande</p>

                    <?php
                    // Récupérer les plats de la commande
                    $sql = "SELECT * FROM cart_items WHERE cart_id = :cart_id";
                    $query = $db->prepare($sql);
                    $query->bindValue(':cart_id', $order['cart_id']);
                    $query->execute();
                    $dishes = $query->fetchAll(PDO::FETCH_ASSOC);

                    // Parcourir chaque plat de la commande
                    foreach ($dishes as $dish):
                        // Vérifier si c'est un plat personnalisé ou standard
                        $quantity = $dish['quantity'];
                        if ($dish['custom_pizza_id'] === 0) {
                            $table = "dishes";
                            $dishId = $dish['dish_id'];                                
                        } else {
                            $table = "custom_pizzas";
                            $dishId = $dish['custom_pizza_id'];
                        }

                        // Récupérer les informations du plat ou de la pizza personnalisée
                        $sql = "SELECT * FROM $table WHERE dish_id = :dish_id";
                        $query = $db->prepare($sql);
                        $query->bindValue(':dish_id', $dishId);
                        $query->execute();
                        $infos_dish = $query->fetchAll(PDO::FETCH_ASSOC);

                        // Parcourir chaque info du plat ou de la pizza
                        foreach ($infos_dish as $info):

                            // Si c'est un plat standard (dishes), récupérer le nom de la taille
                            if ($table === 'dishes') {
                                // Requête pour récupérer le nom de la taille dans la table pizza_sizes
                                $sql_size = "SELECT name FROM pizzas_sizes WHERE pizza_size_id = :size_id";
                                $query_size = $db->prepare($sql_size);
                                $query_size->bindValue(':size_id', $info['size_id']);
                                $query_size->execute();
                                $size_name = $query_size->fetchColumn();
                    
                                // Récupérer la base et la pâte si nécessaire
                                // Exemple pour la base (table 'pizza_bases')
                                $sql_base = "SELECT name FROM pizzas_bases WHERE pizza_base_id = :base_id";
                                $query_base = $db->prepare($sql_base);
                                $query_base->bindValue(':base_id', $info['base_id']); // Assuming there's a base_id column
                                $query_base->execute();
                                $base_name = $query_base->fetchColumn();
                    
                                // Exemple pour la pâte (table 'pizza_pates')
                                $sql_pate = "SELECT name FROM pizzas_pates WHERE pizza_pate_id = :pate_id";
                                $query_pate = $db->prepare($sql_pate);
                                $query_pate->bindValue(':pate_id', $info['pate_id']); // Assuming there's a pate_id column
                                $query_pate->execute();
                                $pate_name = $query_pate->fetchColumn();
                            }
                    
                            // Si c'est une pizza personnalisée (custom_pizzas), récupérer les mêmes informations
                            if ($table === 'custom_pizzas') {
                                // Requête pour récupérer le nom de la taille dans la table pizza_sizes
                                $sql_size = "SELECT name FROM pizzas_sizes WHERE pizza_size_id = :size_id";
                                $query_size = $db->prepare($sql_size);
                                $query_size->bindValue(':size_id', $info['size_id']);
                                $query_size->execute();
                                $size_name = $query_size->fetchColumn();
                    
                                // Récupérer la base (table 'pizza_bases')
                                $sql_base = "SELECT name FROM pizzas_bases WHERE pizza_base_id = :base_id";
                                $query_base = $db->prepare($sql_base);
                                $query_base->bindValue(':base_id', $info['base_id']); // Assuming base_id exists in custom_pizzas
                                $query_base->execute();
                                $base_name = $query_base->fetchColumn();
                    
                                // Récupérer la pâte (table 'pizza_pates')
                                $sql_pate = "SELECT name FROM pizzas_pates WHERE pizza_pate_id = :pate_id";
                                $query_pate = $db->prepare($sql_pate);
                                $query_pate->bindValue(':pate_id', $info['pate_id']); // Assuming pate_id exists in custom_pizzas
                                $query_pate->execute();
                                $pate_name = $query_pate->fetchColumn();
                            }
                    ?>
                    <!-- Affichage du plat/pizza avec l'image et les informations -->
                    <div class="d-flex align-items-center m-2 gap-5 position-relative">
                        <?php
                        // Afficher l'image du plat ou de la pizza
                        if ($table === "dishes") {
                            echo '<img src="../' . $info['image_url'] . '" class="img-fluid rounded" alt="Image du plat" style="height: 100px; width: 100px;">';
                        } else {
                            echo '<img src="../img/products/Pizza Personnalisée.png" class="img-fluid rounded" alt="Image du plat" style="height: 100px; width: 100px;">';
                        }
                        ?>
                        <!-- Conteneur d'informations sur le plat -->
                        <div class="">
                            <!-- Conteneur flex pour aligner les éléments horizontalement -->
                            
                            <div class="d-flex flex-wrap fw-bold">
                                <div class="d-flex align-items-center m-1 py-2 px-3 shadow-sm bg-light rounded border text-center ">
                                    <!-- Quantité -->
                                    <!-- <div class="me-3 px-1 "> -->
                                        <?= $quantity; ?>
                                    <!-- </div> -->
                                </div>
                                <div class="d-flex align-items-center m-1 p-2 shadow-sm bg-light rounded border text-center">
                                    <!-- Nom du plat -->
                                    <!-- <div class="me-3 px-1"> -->
                                        <?= htmlspecialchars($info['name']); ?>
                                    <!-- </div> -->
                                </div>
                                <!-- Informations supplémentaires -->
                                <div class="d-flex align-items-center m-1 p-2 shadow-sm bg-light rounded border text-center">
                                    <!-- <div class="me-3 px-1"> -->
                                        <?= htmlspecialchars($base_name); ?>
                                    <!-- </div> -->
                                </div>
                                <div class="d-flex align-items-center m-1 p-2 shadow-sm bg-light rounded border text-center">
                                <!-- <div class="me-3 px-1"> -->
                                    <?= htmlspecialchars($pate_name); ?>
                                <!-- </div> -->
                                </div>
                                <div class="d-flex align-items-center m-1 p-2 shadow-sm bg-light rounded border text-center">
                                <!-- <div class="me-3 px-1"> -->
                                    <?= htmlspecialchars($size_name); ?>
                                <!-- </div> -->
                                    <!-- <?php print_r($info);?> -->
                                </div>
                            </div>
                            

                            <!-- Liste des ingrédients -->
                            
                                <?php
                                // Préparer la requête pour récupérer les ingrédients selon le type de plat
                                $ingredientTable = $table . '_ingredients';

                                if ($table === "dishes") {
                                    // Requête pour les plats standards
                                    $sql = "
                                    SELECT i.name AS ingredient_name, i.image_url AS ingredient_image_url
                                    FROM $ingredientTable di
                                    JOIN ingredients i ON di.ingredient_id = i.ingredient_id
                                    WHERE di.dish_name = :dish_name
                                    ";
                                    $stmt = $db->prepare($sql);
                                    $stmt->bindValue(':dish_name', $info['name']);
                                    $stmt->execute();
                                    $ingredientsList = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                } elseif ($table === "custom_pizzas") {
                                    // Requête pour les pizzas personnalisées
                                    $sql = "SELECT * FROM $ingredientTable WHERE custom_pizza_id = :pizza_id";
                                    $stmt = $db->prepare($sql);
                                    $stmt->bindValue(':pizza_id', $info['dish_id']);
                                    $stmt->execute();
                                    $customIngredients = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    if (count($customIngredients) > 0) {
                                        $ingredientIds = array_column($customIngredients, 'ingredient_id');
                                        $placeholders = implode(',', array_fill(0, count($ingredientIds), '?'));
                                        $sqlIngredients = "SELECT name AS ingredient_name, image_url AS ingredient_image_url FROM ingredients WHERE ingredient_id IN ($placeholders)";
                                        $stmtIngredients = $db->prepare($sqlIngredients);
                                        $stmtIngredients->execute($ingredientIds);
                                        $ingredientDetails = $stmtIngredients->fetchAll(PDO::FETCH_ASSOC);
                                    }
                                }

                                // Affichage des ingrédients
                                $finalIngredients = isset($ingredientDetails) ? $ingredientDetails : $ingredientsList;
                                ?>
                                <div class="">
                                    <!-- Affichage des ingrédients en flex -->
                                    <div class="d-flex flex-wrap">
                                        <?php foreach($finalIngredients as $ingredient): ?>
                                            <div class="d-flex align-items-center m-1 p-1 shadow-sm bg-light rounded border">
                                                <!-- Image de l'ingrédient -->
                                                <div class="me-3 px-1">
                                                    <img src="../<?php echo $ingredient['ingredient_image_url']; ?>" alt="<?php echo $ingredient['ingredient_name']; ?>" class="img-fluid" style="max-width: 40px; border-radius: 50%;">
                                                </div>
                                                <!-- Nom de l'ingrédient -->
                                                <div>
                                                    <p class="mb-0"><?php echo $ingredient['ingredient_name']; ?></p>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            
                        </div>
                        <div class="position-absolute end-0 bottom-0 fw-bold p-2">
                        <?= number_format($info['price'] * $dish['quantity'], 2, ',', ' '); ?>€
                        </div>
                        
                        
                    </div>
                    <?php endforeach; endforeach; ?>
                </div>

            </div>
            <!-- Actions sur la commande (à personnaliser) -->
            <div class="list-unstyled mt-3">
                    <p class="text-center fw-bold">Informations commande</p>
                    <div class="mb-5 d-flex justify-content-between">
                        <div class="col-3 text-center"><?= $order['first_name'].' '. $order['last_name']?></div>
                        <div class="col-3 text-center"><?= $order['phone']?></div>
                        <div class="col-3 text-center"><?= $order['email']?></div>
                        <div class="col-3 text-center"><?= $dateFormatted ?></div>
                    </div>
                    <div class="mb-3 d-flex justify-content-between align-items-center px-4">

                    
                    
                        
                        
                        
                        
                            <?php
                            if ($order['is_paid']){
                                echo '<div class="d-flex gap-3 align-items-center text-uppercase border border-2 border-success rounded text-success fw-bold py-2 px-3" style="height: 50px;">
                                        <div class="">payée</div>
                                        <img src="../img/icons/orders/'.$order['payment_method'].'.png" class="img-fluid" style="max-height: 30px;" alt="Image de livraison">
                                    </div>';
                                echo '';
                            }     
                            else{
                                echo '<div class="d-flex align-items-center justify-content-center text-uppercase border border-2 border-danger rounded text-danger fw-bold py-2 px-4" style="height: 50px;">
                                        à régler
                                    </div>';
                            }
                            ?>

                            <a href="">
                                <div class="switch-status-arrow multi-color"></div>
                            </a>

                            <a href="update_status.php?status=archivee&order_id=<?=$order['order_id']?>">
                                <div class="switch-status-arrow bg-secondary">></div>
                            </a>
                            
                            
                            <div class="fw-bold p-2">
                            Total : <?= $order['total']?>€
                            </div>
                            
                            
                            
                        
                    </div>
                </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
