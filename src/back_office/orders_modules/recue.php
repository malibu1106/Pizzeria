<?php
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
WHERE order_status = 'recue'
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
        $dateFormatted = date('d/m/y H:i', strtotime($order['date_order']));
        $image_delivrance = $order['is_delivery'] === 1 ? 
            '<img src="../img/icons/scooter.png" class="img-fluid" style="max-height: 50px;" alt="Image de livraison">' :
            '<img src="../img/icons/take_away.png" class="img-fluid" style="max-height: 50px;" alt="Image à emporter">';
    ?>

        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-dark text-white text-center">Commande n°<?= $order['order_id']; ?></div>
                <div class="card-body p-1">
                    <div class="list-unstyled mt-2">
                        <p class="text-center fw-bold">Informations commande</p>
                        <div class="mb-3 d-flex justify-content-between">
                            <div class="col-4 text-center"><?= $order['first_name'].' '. $order['last_name']?></div>
                            <div class="col-4 text-center"><?= $order['phone']?></div>
                            <div class="col-4 text-center"><?= $order['email']?></div>
                        </div>
                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <div class="col-4 text-center"><?= $dateFormatted ?></div>
                            <div class="col-4 text-center"><?= $image_delivrance ?></div>
                            <div class="col-4 text-center"><?= $order['total']?>€</div>
                        </div>
                    </div>

                    <div class="list-unstyled mt-2">
                        <p class="text-center fw-bold">Contenu commande</p>
                        
                        <?php
                        // Récupérer les plats de la commande
                        $sql = "SELECT * FROM cart_items WHERE cart_id = :cart_id";
                        $query = $db->prepare($sql);
                        $query->bindValue(':cart_id', $order['cart_id']);
                        $query->execute();
                        $dishes = $query->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($dishes as $dish):
                            // Déterminer la table en fonction de custom_pizza_id
                            $quantity = $dish['quantity'];
                            if ($dish['custom_pizza_id'] === 0) {
                                $table = "dishes";
                                $dishId = $dish['dish_id'];                                
                            } else {
                                $table = "custom_pizza";
                                $dishId = $dish['custom_pizza_id'];
                            }

                            // Récupérer les informations du plat ou de la pizza personnalisée
                            $sql = "SELECT * FROM $table WHERE dish_id = :dish_id";
                            $query = $db->prepare($sql);
                            $query->bindValue(':dish_id', $dishId);
                            $query->execute();
                            $infos_dish = $query->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($infos_dish as $info): // Itérer sur les infos du plat
                        ?>
                            <div class="d-flex align-items-start mb-1">
                                <img src="<?=$info['image_url']?>" class="img-fluid rounded" alt="Image du plat" style="height: 100px; width: 100px;">
                                <div class="ms-3">
                                    <p class="mb-1"><?= $quantity .' X '. htmlspecialchars($info['name']); ?></p>
                                    <p class="text-muted mb-0"><?= htmlspecialchars($info['description']); ?></p> <!-- Ajouter une colonne description si elle existe -->
                                </div>
                            </div>
                        <?php endforeach; endforeach; ?>
                    </div>

                    <div class="list-unstyled mt-2 bg-primary">
                        <p class="text-center fw-bold">Informations commande</p>
                        <p class="mb-3">Heure - liv/emp - total - payée/nn payée</p>
                    </div>
                    <div class="list-unstyled mt-2 bg-success">
                        <p class="text-center fw-bold">Actions commande</p>
                        <p class="mb-3">X X X</p>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<pre>
    <?php print_r($orders); ?>
</pre>
