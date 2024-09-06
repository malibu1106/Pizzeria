<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="png" href="../img/favicon.png" />
    <link rel="stylesheet" href="../css/carte.css">
    <link rel="stylesheet" href="../css/include_css/nav.css">
    <title>El Chorizo Carte</title>
</head>

<body>
    <header>
        <?php include_once './include/nav.php'; ?>

    </header>
    <h1>Carte</h1>
    <a href="carte.php">Toutes nos pizzas</a>
    <a href="carte.php?selected_global_filter=is_classic">Les classiques</a>
    <a href="carte.php?selected_global_filter=is_new">Les nouveautés</a>
    <a href="carte.php?selected_global_filter=sells_count">Les + demandées</a>
    ICI VOIR POUR :
    IF global filter is set : requete sql >
    ELSE > filtered_search_pizzas (puisque toutes les pizzas affichées par defaut)

</body>

</html>