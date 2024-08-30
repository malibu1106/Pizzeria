<?php require_once('php_sql/db_connect.php');?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une Pizza</title>
</head>
<body>
    <h1>Ajouter une Nouvelle Pizza</h1>
    <form action="add_pizza.php" method="POST">
        <label for="name">Nom de la pizza :</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="description">Description :</label>
        <textarea id="description" name="description" required></textarea><br><br>

        <label for="image_url">URL de l'image :</label>
        <input type="text" id="image_url" name="image_url" required><br><br>

        <label for="price">Prix :</label>
        <input type="number" id="price" name="price" step="0.1" value="8" required><br><br>

        <label for="is_new">Afficher dans les nouveautés :</label>
        <input type="checkbox" id="is_new" name="is_new"><br><br>

        <label for="is_discounted">Réduction :</label>
        <input type="number" id="is_discounted" name="is_discounted" step="1" value="0">%</input><br><br>

        <label for="base_id">Base :</label>
        <select id="base_id" name="base_id" required>
                <?php 
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
        </select><br><br>

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