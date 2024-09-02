<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche de Pizzas</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Inclure jQuery avant Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>
<a href="index.php">Accueil</a>
<h3>Sélectionnez des ingrédients :</h3>
<form id="ingredient-form">
    <?php
    // Connexion à la base de données et récupération des ingrédients
    require_once('php_sql/db_connect.php');
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

<script>
    $(document).ready(function() {
        // Initialiser Select2 avec les images
        $('#ingredient-select').select2({
            templateResult: formatState,
            templateSelection: formatState
        });

        function formatState(state) {
            if (!state.id) {
                return state.text; // Affichage par défaut (text) si aucune image
            }
            var baseUrl = $(state.element).data('image');
            var $state = $(
                '<span><img src="' + baseUrl + '" class="img-flag" style="width: 20px; height: 20px; margin-right: 10px;"/>' + state.text + '</span>'
            );
            return $state;
        }

        // Fonction pour récupérer les résultats de la recherche
        function fetchPizzas() {
            const ingredientsArray = $('#ingredient-select').val();

            // Requête AJAX pour récupérer les résultats
            $.ajax({
                type: 'POST',
                url: 'search_pizzas_ajax.php',
                data: { ingredients: JSON.stringify(ingredientsArray) },
                success: function(response) {
                    $('#pizza-results').html(response);
                },
                error: function() {
                    $('#pizza-results').html('Une erreur est survenue lors de la recherche.');
                }
            });
        }

        // Ajoute un écouteur d'événements pour chaque changement de sélection
        $('#ingredient-select').on('change', fetchPizzas);

        // Charge initialement toutes les pizzas au démarrage
        fetchPizzas();
    });
</script>

</body>
</html>
