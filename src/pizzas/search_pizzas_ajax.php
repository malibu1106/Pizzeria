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
        LEFT JOIN dish_ingredients di ON d.name = di.dish_name
        LEFT JOIN ingredients i ON di.ingredient_id = i.ingredient_id
    ";

    // Variable pour ajouter les conditions WHERE
    $conditions = [];

    // Ajout de la condition pour les ingrédients sélectionnés, s'ils existent
    if (!empty($selected_ingredients)) {
        $placeholders = implode(',', array_fill(0, count($selected_ingredients), '?'));
        $conditions[] = "di.ingredient_id IN ($placeholders)";
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
    // Cette ligne doit se référer à l'alias correct pour la table des ingrédients
    $conditions[] = "i.is_available = 1";

    // Construction de la clause WHERE
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }

    // Ajout du GROUP BY pour regrouper par pizza et filtrer celles qui ont tous les ingrédients disponibles
    $sql .= "
        GROUP BY d.name, d.description, d.image_url, d.is_discounted
        HAVING COUNT(DISTINCT di.ingredient_id) = (SELECT COUNT(*) FROM dish_ingredients di2 WHERE di2.dish_name = d.name)
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