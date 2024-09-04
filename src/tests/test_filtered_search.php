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

<body>
    <a href="../index.php">Accueil</a>
    <h3>Sélectionnez des ingrédients :</h3>
    <form id="ingredient-form">
        <?php
    // Connexion à la base de données et récupération des ingrédients
    require_once('../php_sql/db_connect.php');
    $sql = "SELECT ingredient_id, name, image_url FROM ingredients";
    $query = $db->prepare($sql);
    $query->execute();
    $ingredients = $query->fetchAll(PDO::FETCH_ASSOC);

    // Génération des options du select pour chaque ingrédient
    echo '<select id="ingredient-select" multiple>';
    foreach ($ingredients as $ingredient) {
        echo '<option value="' . $ingredient['ingredient_id'] . '" data-image="'.$ingredient['image_url'].'">' . $ingredient['name'] . '</option>';
    }
    echo '</select>';
    ?>
    </form>

    <h3>Résultats des pizzas :</h3>
    <div id="pizza-results"></div>


</body>

</html>