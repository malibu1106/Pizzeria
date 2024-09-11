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
        <img class="header_carte" src="../img/header_carte.jpg" alt="pizza">
    </header>

    <main>
        <h1>Carte</h1>
        <?php include 'tests/test_filtered_search.php'?>
        <div class="container-pizza">
            <figure class="container-pizza-info">
                <img src="" alt="">
                <figcaption class="pizza-descritpion">
                    <p>Title pizza</p>
                    <p>Cette pizza est garnie de sauce tomate épicée, de mozzarella fondue, de chorizo, de poivrons
                        rouges grillés et d'olives noires, le tout rehaussé d'une touche d'origan frais. </p>
                    <a class="btn-commander" href="">Commander</a>
                </figcaption>
            </figure>

            <!-- this block can be delete after -->
            <!-- this block can be delete after -->
            <figure class="container-pizza-info">
                <img src="" alt="">
                <figcaption class="pizza-descritpion">
                    <p>Title pizza</p>
                    <p>Cette pizza est garnie de sauce tomate épicée, de mozzarella fondue, de chorizo, de poivrons
                        rouges grillés et d'olives noires, le tout rehaussé d'une touche d'origan frais. </p>
                    <a class="btn-commander" href="">Commander</a>
                </figcaption>
            </figure>
            <figure class="container-pizza-info">
                <img src="" alt="">
                <figcaption class="pizza-descritpion">
                    <p>Title pizza</p>
                    <p>Cette pizza est garnie de sauce tomate épicée, de mozzarella fondue, de chorizo, de poivrons
                        rouges grillés et d'olives noires, le tout rehaussé d'une touche d'origan frais. </p>
                    <a class="btn-commander" href="">Commander</a>
                </figcaption>
            </figure>
            <figure class="container-pizza-info">
                <img src="" alt="">
                <figcaption class="pizza-descritpion">
                    <p>Title pizza</p>
                    <p>Cette pizza est garnie de sauce tomate épicée, de mozzarella fondue, de chorizo, de poivrons
                        rouges grillés et d'olives noires, le tout rehaussé d'une touche d'origan frais. </p>
                    <a class="btn-commander" href="">Commander</a>
                </figcaption>
            </figure>
            <figure class="container-pizza-info">
                <img src="" alt="">
                <figcaption class="pizza-descritpion">
                    <p>Title pizza</p>
                    <p>Cette pizza est garnie de sauce tomate épicée, de mozzarella fondue, de chorizo, de poivrons
                        rouges grillés et d'olives noires, le tout rehaussé d'une touche d'origan frais. </p>
                    <a class="btn-commander" href="">Commander</a>
                </figcaption>
            </figure>
            <!-- this block can be delete after -->
            <!-- this block can be delete after -->

        </div>

    </main>

    <?php include_once './include/footer.php'; ?>
</body>

</html>