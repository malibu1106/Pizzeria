<?php 
session_start();
if (!empty($_SESSION['info_message'])) {
    echo '<div class="alert alert-info text-center">' . $_SESSION['info_message'] . '</div>';
} 
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Ajouter une Pâte</title>
</head>

<body>
    <div class="container mt-5 mx-auto">
        <a href="../index.php" class="btn btn-primary mb-4">Accueil</a>
        <h1 class="mb-4">Ajouter une nouvelle pâte</h1>

        <form class="bg-light" id="pateForm" action="bo_create_pate.php" method="POST" class="needs-validation"
            novalidate>
            <div class="mb-3 col-md-6">
                <label for="name" class="form-label">Nom de la pâte :</label>
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
                <label for="extra_price" class="form-label">Prix supplémentaire :</label>
                <div class="input-group">
                    <span class="input-group-text">€</span>
                    <input type="number" id="extra_price" name="extra_price" class="form-control" step="0.1" value="0"
                        required>
                    <div class="invalid-feedback">
                        Veuillez entrer un prix valide.
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Ajouter la pâte</button>
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