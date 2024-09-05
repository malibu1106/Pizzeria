<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/script.js" defer></script>
    <link rel="icon" type="png" href="../img/favicon.png" />
    <link rel="stylesheet" href="css/body_reset.css">
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="css/include_css/nav.css">
    <link rel="stylesheet" href="css/include_css/footer.css">
    <link rel="stylesheet" href="css/style.css">
    <title>El Chorizo</title>
</head>

<body>

    <header>
        <?php include_once './include/nav.php'; ?>

        <p>VIDEO A VENIR</p>
    </header>


    <main>
        <h1 class="title-color">La pizza du jour</h1>
        <p class="h1-sous-titre text-color">Chaque jour, découvrez une nouvelle pizza
            à l'honneur.</p>






        <div class="container-pizza-of-the-day">
            <figure>
                <img class="img-pizza-of-the-day" src="../img/exemple_pizza.png" alt="pizza">
            </figure>
            <div class="container-pizza-of-the-day-text box-color">
                <p class="pizza-name">Nom de la pizza</p>
                <p class="description-pizza-of-the-day text-color">Cette pizza est garnie de sauce tomate épicée, de
                    mozzarella
                    fondue, de chorizo, de
                    poivrons rouges
                    grillés et d'olives noires, le tout rehaussé d'une touche d'origan frais.</p>
            </div>
        </div>






        <h2 class="title-color">Notre carte</h2>
        <!-- grid notre carte à venir -->
        <div>
            <p>A VENIR</p>
        </div>
        <!-- grid notre carte à venir -->
    </main>

    <!-- bandeau fixed -->
    <!-- A FAIRE A LA FIN -->
    <div class="container-bandeau box-color">
        <figure>
            <a class="" href="">
                <img class="bandeau-logo" src="../img/logo_livraison.png" alt="logo livraison">
                <figcaption class="text-color">Livraison</figcaption>
            </a>
        </figure>
        <figure>
            <a class="" href="">
                <img class="bandeau-logo" src="../img/logo_a_emporter.png" alt="logo a emporter">
                <figcaption class="text-color">A emporter</figcaption>
            </a>
        </figure>
        <figure>
            <a class="" href="">
                <img class="bandeau-logo" src="../img/logo_sur_place.png" alt="logo sur place">
                <figcaption class="text-color">Sur place</figcaption>
            </a>
        </figure>
    </div>


    <section>
        <h3 class="notre-histoire-title title-color">Notre histoire</h3>
        <p class="sous-titre text-color">Bienvenue chez <span class="important-word">el chorizo</span>,
            là
            où la
            passion pour
            la pizza rencontre la tradition familiale !</p>


        <figure class="container-notre-histoire">
            <img src="../img/notre_histoire.png" alt="pizza qui sort du four">
            <figcaption class="box-color notre-histoire-description">
                <p class="title-color title-histoire">Plus Qu'une Simple Pizzeria</p>
                <p class="notre-histoire-para text-color">Tout a commencé il y a 5 ans, lorsque <span
                        class="important-word">gino
                        chorizo</span> a ouvert
                    les portes de notre
                    première pizzeria
                    avec une simple vision : partager l'amour de la vraie pizza italienne avec notre communauté.
                    Inspiré par les recettes de sa grand-mère et les saveurs authentiques de sa région natale,
                    <span class="important-word">gino chorizo</span> a décidé de recréer cette expérience unique en
                    utilisant uniquement
                    les meilleurs ingrédients, frais et locaux.
                </p>
            </figcaption>
        </figure>


        <figure class="container-une-passion-pour-la-qualiter">

            <div class="container-double-img">
                <img class="une-passion-pour-la-qualiter-img-1" src="../img/une_passion_pour_la_qualiter.png"
                    alt="fabrication d'une pizza">
                <img class="une-passion-pour-la-qualiter-img-2" src="../img/une_passion_pour_la_qualiter_2.png"
                    alt="pizza">
            </div>

            <figcaption class="box-color">
                <p class="title-color">Une Passion pour la Qualité</p>
                <p class="text-color">Chez <span class="important-word">el chorizo</span>, nous croyons que la
                    qualité commence par les
                    ingrédients. Nous
                    sélectionnons nos
                    tomates mûries au soleil, notre mozzarella fondante et nos herbes aromatiques avec le plus grand
                    soin. Chaque pizza est faite à la main, pétrie avec amour et cuite à la perfection dans notre
                    four traditionnel, pour une croûte croustillante et des saveurs inoubliables.</p>
            </figcaption>

        </figure>


        <figure class="container-une-histoire-de-famille">

            <img src="../img/une_histoire_de_famille.png" alt="partage_de_pizza">

            <figcaption class="box-color">
                <p class="title-color">Une Histoire de Famille</p>
                <p class="text-color">Nous sommes fiers d'être une entreprise familiale, où chaque membre de
                    l'équipe fait partie de
                    notre grande famille <span class="important-word">el chorizo</span>. Nous croyons en
                    l'importance des liens humains et
                    en la joie de
                    partager un bon repas ensemble. Que vous veniez pour une soirée en famille, une sortie entre
                    amis, ou simplement pour une pause gourmande, nous sommes là pour rendre chaque moment spécial.
                </p>
            </figcaption>

        </figure>


    </section>


    <section class="avis">
        <h4 class="title-color">Voici leurs avis</h4>
        <div class="container-avis">
            <div>
                <div>
                    <p class="title-color">Jean Dupont</p>
                    <p class="star-color">&#9733;&#9733;&#9733;&#9733;&#9733;</p>
                </div>
                <p class="text-color">Excellent restaurant ! La pizza était délicieuse, et le service irréprochable. Je
                    recommande vivement
                    !</p>
            </div>
            <div>
                <div>
                    <p class="title-color">Marie Leblanc</p>
                    <p class="star-color">&#9733;&#9733;&#9733;&#9733;</p>
                </div>
                <p class="text-color">Très bon restaurant, la pizza était savoureuse, mais le service un peu lent. Cela
                    reste une bonne
                    expérience !</p>
            </div>
            <div>
                <div>
                    <p class="title-color">Paul Martin</p>
                    <p class="star-color">&#9733;&#9733;&#9733;</p>
                </div>
                <p class="text-color">La pizza était correcte, mais je m'attendais à mieux. Le cadre est agréable, mais
                    le rapport
                    qualité-prix est moyen.</p>
            </div>
            <div>
                <div>
                    <p class="title-color">Claire Durand</p>
                    <p class="star-color">&#9733;&#9733;</p>
                </div>
                <p class="text-color">Décevant. La pâte de la pizza était trop cuite et le service manquait d'attention.
                    Je ne reviendrai
                    pas.</p>
            </div>
        </div>
        <h5 class="title-color">Newsletter</h5>
        <p class="text-color">Abonnez-vous à notre newsletter pour découvrir en avant-première nos
            nouvelles pizzas et profiter d'offres
            exclusives. Ne manquez aucune de nos délicieuses créations chez <span class="important-word">el
                chorizo</span> !</p>
        <form action="#" method="post">
            <input type="email" name="email" placeholder="Email" required>
            <button type="submit">S'inscrire</button>
        </form>
    </section>

    <?php include_once './include/footer.php'; ?>

    <?php include 'tests/liens_tests.html';?>

</body>

</html>