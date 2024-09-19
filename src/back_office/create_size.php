<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Ajouter une nouvelle taille</title>
</head>

<body>
    <?php include 'backoffice_nav.php'?>
    <!-- Ajout de la div pour centrer le formulaire -->
    <div class="d-flex justify-content-center mt-4">
        <div class="container mx-auto col-md-6">
            <h1 class="mb-4 text-center">Ajouter une nouvelle taille</h1>

            <form class="bg-light rounded-2 p-5" id="sizeForm" action="bo_create_size.php" method="POST"
                class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="name" class="form-label">Nom de la taille :</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                    <div class="invalid-feedback">
                        Ce champ est requis.
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description :</label>
                    <textarea id="description" name="description" class="form-control" rows="3" required></textarea>
                    <div class="invalid-feedback">
                        Ce champ est requis.
                    </div>
                </div>

                <div class="mb-3">
                    <label for="extra_price" class="form-label">Prix supplémentaire :</label>
                    <div class="input-group">
                        <span class="input-group-text">€</span>
                        <input type="number" id="extra_price" name="extra_price" class="form-control" step="0.1"
                            value="0" required>
                        <div class="invalid-feedback">
                            Veuillez entrer un prix valide.
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="mt-4 btn btn-success">Ajouter la taille</button>
                </div>
            </form>
        </div>
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