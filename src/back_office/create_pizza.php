<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Ajouter une nouvelle pizza</title>
</head>

<body class="container my-4">
    <div class="d-flex justify-content-between mb-4">
        <a href="../index.php" class="btn btn-primary">Retour au site</a>
        <a href="../back_office/backoffice.php" class="btn btn-primary">Gestion</a>
    </div>
    <br><br>
    <div class="container mt-5 mx-auto">
        <h1 class="mb-4 text-center">Ajouter une nouvelle pizza</h1>

        <form class="bg-light rounded-2 p-5" id="uploadForm" action="bo_create_pizza.php" method="POST"
            enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="mb-3 col-md-6">
                <label for="name" class="form-label">Nom de la pizza :</label>
                <input type="text" id="name" name="name" class="form-control" required>
                <div class="invalid-feedback">
                    Ce champ est requis.
                </div>
            </div>

            <div class="mb-3 col-md-6">
                <label for="description" class="form-label">Description :</label>
                <textarea id="description" name="description" class="form-control" rows="3" required></textarea>
                <div class="invalid-feedback">
                    Ce champ est requis.
                </div>
            </div>

            <div class="mb-3 col-md-6">
                <label for="image_url" class="form-label">URL de l'image :</label>
                <input type="file" id="image_url" name="image_url" class="form-control" accept=".jpg, .jpeg, .png, .gif"
                    required>
                <div class="invalid-feedback">
                    Ce champ est requis.
                </div>
            </div>

            <div class="mb-3 col-md-6">
                <label for="price" class="form-label">Prix :</label>
                <div class="input-group">
                    <span class="input-group-text">€</span>
                    <input type="number" id="price" name="price" class="form-control" step="0.1" value="8" required>
                    <div class="invalid-feedback">
                        Veuillez entrer un prix valide.
                    </div>
                </div>
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" id="is_new" name="is_new" class="form-check-input">
                <label for="is_new" class="form-check-label">Afficher dans les nouveautés</label>
            </div>

            <div class="mb-3 col-md-6">
                <label for="is_discounted" class="form-label">Réduction :</label>
                <div class="input-group">
                    <input type="number" id="is_discounted" name="is_discounted" class="form-control" step="1"
                        value="0">
                    <span class="input-group-text">%</span>
                </div>
            </div>

            <div class="mb-3 col-md-6">
                <label for="base_id" class="form-label">Base :</label>
                <select id="base_id" name="base_id" class="form-select" required>
                    <option default disabled selected>Sélectionnez une base</option>
                    <?php
                        require_once('../php_sql/db_connect.php');
                        $sql = "SELECT pizza_base_id, name, description FROM pizzas_bases";
                        $query = $db->prepare($sql);
                        $query->execute();
                        $bases = $query->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($bases as $base){
                            echo '<option value="'.$base['pizza_base_id'].'">'.$base['description'].'</option>';
                        }
                    ?>
                </select>
                <div class="invalid-feedback">
                    Veuillez sélectionner une base.
                </div>
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label">Ingrédients :</label>
                <div class="row">
                    <?php 
                        $sql = "SELECT ingredient_id, name, description FROM ingredients";
                        $query = $db->prepare($sql);
                        $query->execute();
                        $ingredients = $query->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($ingredients as $ingredient){
                            echo '<div class="col-md-4">';
                            echo '<div class="form-check">';
                            echo '<input type="checkbox" name="ingredients[]" value="'.$ingredient['ingredient_id'].'" class="form-check-input">';
                            echo '<label class="form-check-label">'.$ingredient['name'].'</label>';
                            echo '</div>';
                            echo '</div>';
                        }
                    ?>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Ajouter la Pizza</button>
        </form>
    </div>

    <script>
    (function() {
        'use strict'

        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()
    </script>
</body>

</html>