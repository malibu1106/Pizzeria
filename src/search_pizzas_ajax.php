<?php
// Vérifie si la requête est une requête AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ingredients'])) {
    // Connexion à la base de données
    require_once('php_sql/db_connect.php');

    // Récupère les IDs des ingrédients sélectionnés depuis la requête AJAX
    $selected_ingredients = json_decode($_POST['ingredients'], true);

    // Vérifie si des ingrédients ont été sélectionnés
    if (!empty($selected_ingredients)) {
        // Convertit le tableau en une liste d'IDs pour la requête SQL
        $placeholders = implode(',', array_fill(0, count($selected_ingredients), '?'));

        // Requête SQL pour récupérer les pizzas contenant les ingrédients sélectionnés, avec un seul résultat par nom de pizza
        $sql = "
            SELECT d.name, d.description, MIN(d.price) as price
            FROM dishes d
            INNER JOIN dish_ingredients di ON d.name = di.dish_name
            WHERE di.ingredient_id IN ($placeholders)
            GROUP BY d.name, d.description
            HAVING COUNT(DISTINCT di.ingredient_id) = ?
        ";

        $query = $db->prepare($sql);
        $query->execute(array_merge($selected_ingredients, [count($selected_ingredients)]));

    } else {
        // Si aucun ingrédient n'est sélectionné, récupère toutes les pizzas
        $sql = "
            SELECT d.name, d.description, MIN(d.price) as price
            FROM dishes d
            GROUP BY d.name, d.description
        ";

        $query = $db->prepare($sql);
        $query->execute();
    }

    $pizzas = $query->fetchAll(PDO::FETCH_ASSOC);

    // Génère le HTML des résultats
    if ($pizzas) {
        foreach ($pizzas as $pizza) {
            echo '<div class="pizza">';
            echo '<strong>' . htmlspecialchars($pizza['name']) . '</strong><br>';
            echo 'Description: ' . htmlspecialchars($pizza['description']) . '<br>';
            echo 'Prix: ' . htmlspecialchars($pizza['price']) . '€<br>';
            echo '</div>';
        }
    } else {
        echo 'Aucune pizza trouvée avec les ingrédients sélectionnés.';
    }
} else {
    echo 'Requête invalide.';
}
?>
