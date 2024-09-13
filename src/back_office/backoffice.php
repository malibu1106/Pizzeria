<?php 
session_start();
$_SESSION['loggedIn'] = 1; // TEMP : Réglage temporaire pour indiquer l'état de connexion
$_SESSION['logged_user_id'] = 1; // TEMP : Réglage temporaire pour stocker l'ID de l'utilisateur connecté
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Affichage des commandes</title>
    <!-- Inclure Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container my-4">
    <div class="d-flex justify-content-between mb-4">
        <a href="../index.php" class="btn btn-primary">Retour au site</a>
        <a href="../back_office/backoffice.php" class="btn btn-primary">Gestion</a>
    </div>
    <br><br>


    <p style="color:red"><span style="text-decoration:underline;">Nourriture</span><br>
        <a href="../back_office/create_pizza.php">Ajouter une pizza</a><br>
        <a href="../back_office/create_ingredient.php">Ajouter un ingrédient</a><br>
        <a href="../back_office/create_pate.php">Ajouter une pate</a><br>
        <a href="../back_office/create_base.php">Ajouter une base</a><br>
        <a href="../back_office/create_size.php">Ajouter une taille </a><br>
    </p>

    <p style="color:red"><span style="text-decoration:underline;">Gestion</span><br>
        <a href="../back_office/orders.php">Commandes admin</a>
    </p>
    <hr>

    <p style="color:red"><span style="text-decoration:underline;">A faire nourriture</span><br>
        <a href="../back_office/test_edit_pizza.php">Modifier/supprimer une pizza</a>
        < Tableau + tri !<br>
            <a href="../back_office/test_edit_ingredient.php">Modifier/supprimer un ingrédient</a><br>
            <a href="../back_office/test_edit_pate.php">Modifier/supprimer une pate</a><br>
            <a href="../back_office/test_edit_base.php">Modifier/supprimer une base</a><br>
            <a href="../back_office/test_edit_size.php">Modifier/supprimer une taille </a><br>

    </p>

    <p style="color:red"><span style="text-decoration:underline;">A faire gestion</span><br>
        <a href="">Gestion des utilisateurs</a><br>
        <a href="">Page commandes en live</a><br>
        caisse < toutes<br>
            cuisine < cmd à faire seulement < alertes visuelles/sonores, mode auto / mode manuel <br>
                <a href="">Gestion des tickets</a>
                < séparer les normaux / commandes </p>

                    <p style="color:red"><span style="text-decoration:underline;">Potentiellement + tard</span><br>
                        <a href="">Pages stats</a><br>
                        <a href="">Ajouter un plat</a><br>
                        <a href="">Modifier/supprimer un plat</a><br>
                        <a href="">Ajouter une offre spéciale</a><br>
                        <a href="">Modifier/supprimer une offre spéciale</a><br>
                    </p>




</body>

</html>