<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Recherche de Pizzas</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="../js/filtered_search_pizzas.js"></script>
</head>
<?php
$active_filter = '';
if(isset($_GET['filter'])){
    $active_filter = $_GET['filter'];
}
?>

<body>

    <div class="container-liste-pizza">
        <a href="#" class="filter-link <?= ($active_filter == 'all') ? 'active-filter' : '';?>" data-filter="">Toutes
            nos
            pizzas</a>
        <a href="#" class="filter-link <?= ($active_filter == 'classic') ? 'active-filter' : '';?>"
            data-filter="is_classic">Les classiques</a>
        <a href="#" class="filter-link <?= ($active_filter == 'new') ? 'active-filter' : '';?>" data-filter="is_new">Les
            nouveautés</a>
        <a href="#" class="filter-link <?= ($active_filter == 'sales_count') ? 'active-filter' : '';?>"
            data-filter="sells_count">Les + demandées</a>
    </div>

    <h3>Sélectionnez des ingrédients :</h3>
    <div class="ingredient-selection-container">
        <form id="ingredient-form">
            <?php
        // Connexion à la base de données et récupération des ingrédients
        require_once('php_sql/db_connect.php');
        $sql = "SELECT ingredient_id, name, image_url FROM ingredients WHERE is_available = 1";
        $query = $db->prepare($sql);
        $query->execute();
        $ingredients = $query->fetchAll(PDO::FETCH_ASSOC);

        // Génération des options du select pour chaque ingrédient
        echo '<select id="ingredient-select" multiple>';
        foreach ($ingredients as $ingredient) {
            echo '<option value="' . $ingredient['ingredient_id'] . '" data-image="' . $ingredient['image_url'] . '">' . $ingredient['name'] . '</option>';
        }
        echo '</select>';
        ?>
        </form>

        <div class="selected-ingredients">
            <h4>Ingrédients sélectionnés :</h4>
            <ul id="selected-ingredient-list"></ul>
        </div>
    </div>


    <h3>Résultats des pizzas :</h3>
    <div id="pizza-results"></div>

    <script src="../js/test.js"></script>
</body>

</html>