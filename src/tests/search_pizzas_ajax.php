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
        SELECT d.name, d.description, MIN(d.price) as price, MAX(d.sells_count) as sells_count
        FROM dishes d
        LEFT JOIN dish_ingredients di ON d.name = di.dish_name
    ";

    // Variable pour ajouter les conditions WHERE
    $conditions = [];

    // Ajout de la condition pour les ingrédients, s'ils existent
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
        // On ajoute un tri basé sur la colonne sells_count avec agrégation
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }
        $sql .= " GROUP BY d.name, d.description";
        $sql .= " ORDER BY MAX(d.sells_count) DESC"; // Utilisation de MAX pour que ça fonctionne avec GROUP BY
        $sql .= " LIMIT 3"; // Limite les résultats à 3 pizzas
    
    } else {
        // Gestion des autres cas avec ou sans ingrédients
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }
        $sql .= " GROUP BY d.name, d.description";
    }

    // Si aucun ingrédient ni filtre n'est sélectionné, récupérer toutes les pizzas
    if (empty($selected_ingredients) && empty($selected_filter)) {
        $sql = "
            SELECT d.name, d.description, MIN(d.price) as price
            FROM dishes d
            GROUP BY d.name, d.description
        ";
    }

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
        foreach ($pizzas as $pizza) {
            include 'pizza_card.php';
        }
    } else {
        echo 'Aucune pizza trouvée avec les critères sélectionnés.';
    }
} else {
    echo 'Requête invalide.';
}
?>
