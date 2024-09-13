<?php 
session_start();
$_SESSION['loggedIn'] = 1; // TEMP : Réglage temporaire pour indiquer l'état de connexion
$_SESSION['logged_user_id'] = 1; // TEMP : Réglage temporaire pour stocker l'ID de l'utilisateur connecté
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Gestion</title>
    <!-- Inclure Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Barre de navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid d-flex align-items-center">
            <p class="text-white fw-bold fs-3 mb-0">Tableau de bord</p> <!-- Centré et plus gros/gras -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Retour au site</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../back_office/backoffice.php">Gestion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- Contenu principal -->
    <div class="container mt-3 rounded-2 p-5">

        <!-- Gestion des commandes et des utilisateurs -->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="mb-4 text-primary  text-center">Gestion globale</h3>
            </div>

            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header bg-success text-white text-center">Commandes</div>
                    <div class="card-body text-center">
                        <ul class="list-unstyled  mt-2"">
                            <li class=" mb-3"><a href="../back_office/orders.php"
                                class="btn btn-outline-success btn-sm">Voir les commandes</a></li>
                            <li class="mb-3"><a href="#" class="btn btn-outline-success btn-sm">Vue cuisine</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header bg-info text-white text-center">Gestion utilisateurs & stats</div>
                    <div class="card-body text-center">
                        <ul class="list-unstyled  mt-2"">
                            
                            <li class=" mb-3"><a href="#" class="btn btn-outline-info btn-sm">Messagerie</a></li>
                            <li class="mb-3"><a href="#" class="btn btn-outline-info btn-sm">Statistiques</a></li>
                            <li class=" mb-3"><a href="#" class="btn btn-outline-info btn-sm">Gestion des
                                    utilisateurs</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gestion des produits -->
        <div class="row mb-5">
            <div class="col-lg-12">
                <h3 class="mb-4 text-primary text-center">Gestion des produits</h3>
            </div>

            <!-- Création -->
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white text-center">Créer des produits</div>
                    <div class="card-body text-center">
                        <ul class="list-unstyled mt-2"">
                        <li class=" mb-3"><a href="../back_office/create_ingredient.php"
                                class="btn btn-outline-primary btn-sm">Ajouter un ingrédient</a></li>
                            <li class=" mb-3"><a href="../back_office/create_pizza.php"
                                    class="btn btn-outline-primary btn-sm">Ajouter une pizza</a></li>

                            <li class="mb-3"><a href="../back_office/create_pate.php"
                                    class="btn btn-outline-primary btn-sm">Ajouter une pâte</a></li>
                            <li class="mb-3"><a href="../back_office/create_base.php"
                                    class="btn btn-outline-primary btn-sm">Ajouter une base</a></li>
                            <li class="mb-3"><a href="../back_office/create_size.php"
                                    class="btn btn-outline-primary btn-sm">Ajouter une taille</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Modification -->
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header bg-secondary text-white text-center">Modifier des produits</div>
                    <div class="card-body text-center">
                        <ul class="list-unstyled mt-2">
                            <li class="mb-3"><a href="../back_office/test_edit_ingredient.php"
                                    class="btn btn-outline-secondary btn-sm">Modifier un ingrédient</a></li>
                            <li class="mb-3"><a href="../back_office/test_edit_pizza.php"
                                    class="btn btn-outline-secondary btn-sm">Modifier une pizza</a></li>

                            <li class="mb-3"><a href="../back_office/test_edit_pate.php"
                                    class="btn btn-outline-secondary btn-sm">Modifier une pâte</a></li>
                            <li class="mb-3"><a href="../back_office/test_edit_base.php"
                                    class="btn btn-outline-secondary btn-sm">Modifier une base</a></li>
                            <li class="mb-3"><a href="../back_office/test_edit_size.php"
                                    class="btn btn-outline-secondary btn-sm">Modifier une taille</a></li>
                            <li class="mb-3"><a href="" class="btn mt-4 btn-outline-secondary btn-sm">Gérer les
                                    disponibilités</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Suppression -->
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header bg-danger text-white text-center">Supprimer des produits</div>
                    <div class="card-body text-center">
                        <ul class="list-unstyled  mt-2"">
                        <li class=" mb-3"><a href="../back_office/test_delete_ingredient.php"
                                class="btn btn-outline-danger btn-sm">Supprimer un ingrédient</a></li>
                            <li class=" mb-3"><a href="../back_office/test_delete_pizza.php"
                                    class="btn btn-outline-danger btn-sm">Supprimer une pizza</a></li>

                            <li class="mb-3"><a href="../back_office/test_delete_pate.php"
                                    class="btn btn-outline-danger btn-sm">Supprimer une pâte</a></li>
                            <li class="mb-3"><a href="../back_office/test_delete_base.php"
                                    class="btn btn-outline-danger btn-sm">Supprimer une base</a></li>
                            <li class="mb-3"><a href="../back_office/test_delete_size.php"
                                    class="btn btn-outline-danger btn-sm">Supprimer une taille</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>



    </div>

    <!-- Inclure les scripts JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>