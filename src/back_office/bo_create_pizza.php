<?php
// ON DEMARRE DIRECTEMENT UNE SESSION POUR GERER LES MESSAGES A AFFICHER EN CAS DE PROBLEME
session_start();

    if (isset($_POST) && !empty($_POST['name']) && !empty($_POST['description']) && !empty($_FILES['image_url']) && 
    !empty($_POST['price']) && !empty($_POST['base_id']) && !empty($_POST['ingredients'])){
        
        // CONNEXION + MESSAGE TEMPORAIRE
        require_once('../php_sql/db_connect.php');

        // POST VALUES
        $name = strip_tags($_POST['name']);
        $description = strip_tags($_POST['description']);
        $image_url = strip_tags($_FILES['image_url']['name']);
        $base_price = strip_tags($_POST['price']); // Garde la valeur de base
        $is_new = !empty($_POST['is_new']) ? (strip_tags($_POST['is_new']) === 'on') : 0;        
        $is_discounted = strip_tags($_POST['is_discounted']) / 100 ;
        $base_id = strip_tags($_POST['base_id']);
        $ingredients = ($_POST['ingredients']);

        // AUTO VALUE
        $type = "pizza";
        

        //GESTION DE L'IMAGE
        
            $uploadDir = '../img/products/'; // DOSSIER OU L'ON STOCKERA NOS IMAGES
            $imageFileType = strtolower(pathinfo($_FILES['image_url']['name'], PATHINFO_EXTENSION)); // EXTENSION DU FICHIER UPLOADE
            $allowedTypes = array('jpg', 'jpeg', 'png', 'gif'); // EXTENSIONS AUTORISEES
        
            // Check if the file is an allowed image type
            if(in_array($imageFileType, $allowedTypes)){ // SI L'EXTENSION DU FICHIER UPLOADE EST AUTORISEE
                $newFileName = 'Pizza '. $name .'.'. $imageFileType;
                $image_filename = $uploadDir . $newFileName;
                move_uploaded_file($_FILES['image_url']['tmp_name'], $image_filename); // ON PUSH L'IMAGE DANS LE DOSSIER
                }
            else{
                echo 'extension d\'image incorrecte'; // ERREUR SESSION ICI
                $_SESSION['info_message'] = "Extension d'image incorrecte";
            }
            
            
                
            


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
                $query->bindValue(':image_url', $image_filename);
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
        $_SESSION['info_message'] = "Le produit a bien été ajouté.";
    }

    


    else{
        $_SESSION['info_message'] = "Le formulaire n'a pas été rempli correctement.";
        
        
    }
    header('Location: test_create_pizza.php');// TEMP
    exit(); // Bonne pratique d'ajouter un exit après un header pour arrêter l'exécution 
?>