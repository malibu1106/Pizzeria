<pre>
<?php
print_r($_POST);
?>
</pre>

<?php

    if (isset($_POST) && !empty($_POST['name']) && !empty($_POST['description']) && !empty($_POST['image_url']) && 
    !empty($_POST['price']) && !empty($_POST['is_new']) && !empty($_POST['is_discounted']) && !empty($_POST['base_id']) && !empty($_POST['ingredients'])){
        
        // CONNEXION + MESSAGE TEMPORAIRE
        require_once('php_sql/db_connect.php');
        echo '<br>formulaire complet<br>';

        // POST VALUES
        $name = strip_tags($_POST['name']);
        $description = strip_tags($_POST['description']);
        $image_url = strip_tags($_POST['image_url']);
        $base_price = strip_tags($_POST['price']); // Garde la valeur de base
        $is_new = strip_tags($_POST['is_new']) === 'on';
        $is_discounted = strip_tags($_POST['is_discounted']) / 100 ;
        $base_id = strip_tags($_POST['base_id']);
        $ingredients = ($_POST['ingredients']); // temp

        // AUTO VALUE
        $type = "pizza";      
        

        // RECUPERATION DES TAILLES ET DES PATES POUR INSERER LES PIZZAS DANS TOUTES LEURS DECLINAISONS POSSIBLES

        $sql = "SELECT pizza_size_id, extra_price FROM pizzas_sizes";

                // PREPARATION DE LA REQUETE
                $query = $db->prepare($sql);

                //EXECUTION DE LA REQUETE + STOCK DES DONNEES DANS LA VARIABLE
                $query->execute();
                $sizes = $query->fetchAll(PDO::FETCH_ASSOC);

        $sql = "SELECT pizza_pate_id, extra_price FROM pizzas_pates";
        
                // PREPARATION DE LA REQUETE
                $query = $db->prepare($sql);

                //EXECUTION DE LA REQUETE + STOCK DES DONNEES DANS LA VARIABLE
                $query->execute();
                $pates = $query->fetchAll(PDO::FETCH_ASSOC);

        // BIND
        

        foreach ($sizes as $size){        


            foreach($pates as $pate){


                $current_price = $base_price + $pate['extra_price'] + $size['extra_price']; // ON CALCULE LE PRIX DE CHAQUE DECLINAISON EN FONCTION DES SUPPLEMENTS PATES / TAILLES

                $sql = "INSERT INTO dishes (name, description, image_url, price, type, is_new, is_discounted, pate_id, base_id, size_id)
                        VALUES (:name, :description, :image_url, :price, :type, :is_new, :is_discounted, :pate_id, :base_id, :size_id)";

                $query = $db->prepare($sql);
                $query->bindValue(':name', $name);
                $query->bindValue(':description', $description);
                $query->bindValue(':image_url', $image_url);
                $query->bindValue(':price', $current_price);
                $query->bindValue(':type', $type);
                $query->bindValue(':is_new', $is_new);
                $query->bindValue(':is_discounted', $is_discounted);
                $query->bindValue(':base_id', $base_id);
                $query->bindValue(':size_id', $size['pizza_size_id']);
                $query->bindValue(':pate_id', $pate['pizza_pate_id']);                
                $query->execute();              

            }

        }

         // Insère les relations dans `ingredients_dishes`
         foreach ($ingredients as $ingredient_id) {
            $sql = "INSERT INTO dish_ingredients (ingredient_id, dish_name)
                    VALUES (:ingredient_id, :dish_name)";
            $query = $db->prepare($sql);
            $query->bindValue(':ingredient_id', $ingredient_id);
            $query->bindValue(':dish_name', $name);
            $query->execute();
        }
    }


    else{
        echo "Le formulaire n'a pas été rempli correctement. REDIRECTION ICI";
    }

?>