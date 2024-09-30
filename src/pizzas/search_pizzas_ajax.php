<?php
// Vérifie si la requête est une requête AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ingredients'])) {
    // Connexion à la base de données
    require_once('../php_sql/db_connect.php');

    // Récupère les IDs des ingrédients sélectionnés depuis la requête AJAX
    $selected_ingredients = json_decode($_POST['ingredients'], true);

    // Récupère le filtre sélectionné
    $selected_filter = isset($_POST['selected_filter']) ? $_POST['selected_filter'] : '';

    // Construction de la base de la requête SQL
    $sql = "
        SELECT d.name, d.description, MIN(d.price) as price, MAX(d.sells_count) as sells_count, d.image_url, d.is_discounted
        FROM dishes d
        LEFT JOIN dishes_ingredients di ON d.name = di.dish_name
        LEFT JOIN ingredients i ON di.ingredient_id = i.ingredient_id
    ";

    // Variable pour ajouter les conditions WHERE
    $conditions = [];

    // Ajout de la condition pour les ingrédients sélectionnés (uniquement les pizzas qui ont tous les ingrédients sélectionnés)
    if (!empty($selected_ingredients)) {
        $placeholders = implode(',', array_fill(0, count($selected_ingredients), '?'));

        // Condition : tous les ingrédients sélectionnés doivent être présents dans chaque pizza
        $conditions[] = "d.name IN (
            SELECT di.dish_name
            FROM dishes_ingredients di
            WHERE di.ingredient_id IN ($placeholders)
            GROUP BY di.dish_name
            HAVING COUNT(DISTINCT di.ingredient_id) = " . count($selected_ingredients) . "
        )";
    }

    // Ajout des filtres spécifiques
    if ($selected_filter === 'is_classic') {
        $conditions[] = "d.is_classic = 1";
    } elseif ($selected_filter === 'is_new') {
        $conditions[] = "d.is_new = 1";
    }

    // Gestion du filtre 'Les + demandées'
    if ($selected_filter === 'sells_count') {
        $orderBy = " ORDER BY MAX(d.sells_count) DESC LIMIT 3";
    } else {
        $orderBy = '';
    }

    // Ajout de la condition pour vérifier que tous les ingrédients sont disponibles
    $conditions[] = "i.is_available = 1";

    // Construction de la clause WHERE
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }

    // Ajout du GROUP BY pour regrouper par pizza
    $sql .= "
        GROUP BY d.name, d.description, d.image_url, d.is_discounted
    ";

    $sql .= $orderBy;

    // Préparation et exécution de la requête
    if (!empty($selected_ingredients)) {
        $query = $db->prepare($sql);
        $query->execute($selected_ingredients);
    } else {
        $query = $db->prepare($sql);
        $query->execute();
    }

    // Récupération des résultats
    $pizzas = $query->fetchAll(PDO::FETCH_ASSOC);

    // Génère le HTML des résultats
    if ($pizzas) {
        echo '<div class="container-pizza">';
        foreach ($pizzas as $pizza) {
            include 'pizza_card.php';
        }
        echo '</div>';
    } else {
        echo 'Aucune pizza trouvée avec les critères sélectionnés.';
    }
} else {
    echo 'Requête invalide.';
}
