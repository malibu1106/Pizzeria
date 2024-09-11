<?php session_start();?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="png" href="../img/favicon.png" />
    <link rel="stylesheet" href="../css/carte.css">
    <link rel="stylesheet" href="../css/include_css/nav.css">
    <link rel="stylesheet" href="../css/include_css/footer.css">
    <title>El Chorizo Carte</title>
</head>

<body>
    <header>
        <?php include_once './include/nav.php'; ?>
    </header>
    <img class="header_carte" src="../img/header_carte_test.jpg" alt="pizza">

    <main>
        <h1>Carte</h1>
        <?php include 'pizzas/pizzas_filtered_search.php'?>



    </main>

    <?php include_once './include/footer.php'; ?>
</body>

</html>