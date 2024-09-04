<?php 
session_start();
if(!empty($_SESSION['info_message'])){
    echo $_SESSION['info_message'];
} 
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <script src="js/max_image_size_check.js" defer></script>
    <title>Ajouter une Pizza</title>
</head>

<body>
    <a href="index.php">Accueil</a>
    <h1>Ajouter une Nouvelle Pizza</h1>
    <form id="uploadForm" action="bo_create_pizza.php" method="POST" enctype="multipart/form-data">
        <label for="name">Nom de la pizza :</label>
        <input type="text" id="name" name="name" required>*<br><br>

        <label for="description">Description :</label>
        <textarea id="description" name="description" required></textarea>*<br><br>

        <label for="image_url">URL de l'image :</label>
        <input type="file" id="image_url" name="image_url" accept=".jpg, .jpeg, .png, .gif" required />*<br><br>

        <label for="price">Prix :</label>
        <input type="number" id="price" name="price" step="0.1" value="8" required>*<br><br>

        <label for="is_new">Afficher dans les nouveautés :</label>
        <input type="checkbox" id="is_new" name="is_new"><br><br>

        <label for="is_discounted">Réduction :</label>
        <input type="number" id="is_discounted" name="is_discounted" step="1" value="0">%</input><br><br>

        <label for="base_id">Base :</label>
        <select id="base_id" name="base_id" required>
            <option default disabled selected>Sélectionnez une base</option>
            <?php

                require_once('php_sql/db_connect.php');
                // REQUETE POUR LES PATES
                $sql = "SELECT pizza_base_id, name, description FROM pizzas_bases";

                // PREPARATION DE LA REQUETE
                $query = $db->prepare($sql);

                //EXECUTION DE LA REQUETE + STOCK DES DONNEES DANS LA VARIABLE
                $query->execute();
                $bases = $query->fetchAll(PDO::FETCH_ASSOC);

                foreach ($bases as $base){
                    echo '<option value="'.$base['pizza_base_id'].'">'.$base['description'].'</option>';
                }
                ?>
        </select>*<br><br>

        <label>Ingrédients :</label><br>
        <?php 
                // REQUETE POUR LES PATES
                $sql = "SELECT ingredient_id, name, description FROM ingredients";

                // PREPARATION DE LA REQUETE
                $query = $db->prepare($sql);

                //EXECUTION DE LA REQUETE + STOCK DES DONNEES DANS LA VARIABLE
                $query->execute();
                $ingredients = $query->fetchAll(PDO::FETCH_ASSOC);

                foreach ($ingredients as $ingredient){
                    echo '<input type="checkbox" name="ingredients[]" value="'.$ingredient['ingredient_id'].'">'.$ingredient['name'].'<br>';
                }
                ?>


        <br><input type="submit" value="Ajouter la Pizza">
    </form>
</body>

</html>