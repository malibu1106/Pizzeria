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
    <!-- <?php include 'tests/liens_tests.html';?> -->

    <header>
        <?php include_once './include/nav.php'; ?>

        <p class="a-venir">VIDEO A VENIR</p>
    </header>

    <main>
        <h1 class="title-color">La pizza du jour</h1>
        <p class="h1-sous-titre text-color">Chaque jour, découvrez une nouvelle pizza à l'honneur.</p>

        <!-- a changer chaque jours en php pour afficher une pizza différente -->
        <figure class="container-pizza-of-the-day">
            <img class="img-pizza-of-the-day" src="../img/exemple_pizza.png" alt="pizza">
            <figcaption class="container-pizza-of-the-day-text box-color">
                <p class="pizza-name">Nom de la pizza</p>
                <p class="description-pizza-of-the-day text-color">Cette pizza est garnie de sauce tomate épicée, de
                    mozzarella
                    fondue, de chorizo, de
                    poivrons rouges
                    grillés et d'olives noires, le tout rehaussé d'une touche d'origan frais.</p>
            </figcaption>
        </figure>
        <!-- a changer chaque jours en php pour afficher une pizza différente -->


        <!-- grid notre carte -->
        <h2 class="title-color">Notre carte</h2>
        <div class="container-grid">
            <div class="item item1">
                <a href="">
                    <img src="../img/grid/les_classiques.png" alt="image de pizza">
                    <span class="btn-grid">Les classiques</span>
                </a>
            </div>
            <div class="item item2">
                <a href="">
                    <img src="../img/grid/toutes_les_pizzas.png" alt="image de pizza">
                    <span class="btn-grid">toutes les pizzas</span>
                </a>
            </div>
            <div class="item item3">
                <a href="">
                    <img src="../img/grid/sur_mesure.png" alt="image de pizza">
                    <span class="btn-grid">sur mesure</span>
                </a>
            </div>
            <div class="item item4">
                <a href="">
                    <img src="../img/grid/les_plus_demandés.png" alt="image de pizza">
                    <span class="btn-grid">les plus demandés</span>
                </a>
            </div>
            <div class="item item5">
                <a href="">
                    <img src="../img/grid/nos_offres_spéciales.png" alt="image de pizza">
                    <span class="btn-grid">Nos offres spéciales</span>
                </a>
            </div>
        </div>
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

    <!-- section notre histoire -->
    <section>
        <h3 class="notre-histoire-title title-color box-color">Notre histoire</h3>
        <p class="sous-titre text-color">Bienvenue chez <span class="important-word">el chorizo</span>,
            là
            où la
            passion pour
            la pizza rencontre la tradition familiale !</p>

        <!-- histoire partie 1 -->
        <figure class="container-notre-histoire container-notre-histoire-desktop">
            <img class="notre-histoire-img-desktop" src="../img/notre_histoire.png" alt="pizza qui sort du four">
            <figcaption class="box-color notre-histoire-description notre-histoire-description-desktop">
                <p class="title-color notre-histoire-title-card">Plus Qu'une Simple Pizzeria</p>
                <p class="text-color">Tout a commencé il y a 5 ans, lorsque <span class="important-word">gino
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

        <!-- histoire partie 2 -->
        <figure class="container-notre-histoire container-notre-histoire-partie-2-desktop">
            <div class="container-double-img">
                <img class="une-passion-pour-la-qualiter-img-1" src="../img/une_passion_pour_la_qualiter.png"
                    alt="fabrication d'une pizza">
                <img class="une-passion-pour-la-qualiter-img-2" src="../img/une_passion_pour_la_qualiter_2.png"
                    alt="pizza">
            </div>
            <figcaption class="box-color notre-histoire-description-2">
                <p class="notre-histoire-title-card title-color">Une Passion pour la Qualité</p>
                <p class="text-color">Chez <span class="important-word">el chorizo</span>, nous croyons que la
                    qualité commence par les
                    ingrédients. Nous
                    sélectionnons nos
                    tomates mûries au soleil, notre mozzarella fondante et nos herbes aromatiques avec le plus grand
                    soin. Chaque pizza est faite à la main, pétrie avec amour et cuite à la perfection dans notre
                    four traditionnel, pour une croûte croustillante et des saveurs inoubliables.</p>
            </figcaption>
        </figure>

        <!-- histoire partie 3 -->
        <figure class="container-notre-histoire container-notre-histoire-desktop">
            <img src="../img/une_histoire_de_famille.png" alt="partage_de_pizza">
            <figcaption class="box-color notre-histoire-description notre-histoire-description-desktop">
                <p class="notre-histoire-title-card title-color">Une Histoire de Famille</p>
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


    <section class="avis box-color">
        <h4 class="title-color">Voici leurs avis</h4>

        <!-- section avis -->
        <div class="container-avis">


            <!-- foreach pour afficher un maximum de 4 commentaire -->

            <!-- <div class="avis">
                <div class="container-name-avis">
                    <p class="title-color">NOM DE LA PERSONNE</p>
                    <p class="star-color">NOMBRE D'ETOILES &#9733;&#9733;&#9733;&#9733;&#9733;</p>
                </div>
                <p class="text-color">COMMENTAIRE</p>
            </div> -->



            <!-- a remplacer par des commentaire récupérer en bdd, dois etre supprimer une fois cela fait -->
            <div class="avis">
                <div class="container-name-avis">
                    <p class="title-color">Jean Dupont</p>
                    <p class="star-color">&#9733;&#9733;&#9733;&#9733;&#9733;</p>
                </div>
                <p class="text-color">Excellent restaurant ! La pizza était délicieuse, et le service irréprochable. Je
                    recommande vivement
                    !</p>
            </div>
            <div class="avis">
                <div class="container-name-avis">
                    <p class="title-color">Marie Leblanc</p>
                    <p class="star-color">&#9733;&#9733;&#9733;&#9733;</p>
                </div>
                <p class="text-color">Très bon restaurant, la pizza était savoureuse, mais le service un peu lent. Cela
                    reste une bonne
                    expérience !</p>
            </div>
            <div class="avis">
                <div class="container-name-avis">
                    <p class="title-color">Paul Martin</p>
                    <p class="star-color">&#9733;&#9733;&#9733;</p>
                </div>
                <p class="text-color">La pizza était correcte, mais je m'attendais à mieux. Le cadre est agréable, mais
                    le rapport
                    qualité-prix est moyen.</p>
            </div>
            <div class="avis">
                <div class="container-name-avis">
                    <p class="title-color">Claire Durand</p>
                    <p class="star-color">&#9733;&#9733;</p>
                </div>
                <p class="text-color">Décevant. La pâte de la pizza était trop cuite et le service manquait d'attention.
                    Je ne reviendrai
                    pas.</p>
            </div>
            <!-- a remplacer par des commentaire récupérer en bdd, dois etre supprimer une fois cela fait -->
        </div>



        <div class="container-newsletter">
            <h5 class="title-color">Newsletter</h5>
            <p class="text-color">Abonnez-vous à notre newsletter pour découvrir en avant-première nos
                nouvelles pizzas et profiter d'offres
                exclusives. Ne manquez aucune de nos délicieuses créations chez <span class="important-word">el
                    chorizo</span> !</p>
        </div>
        <form action="#" method="post">
            <div class="form-group">
                <input class="form-input" type="email" name="email" placeholder=" " id="Email" />
                <label class="form-label" for="Email">Email</label>
            </div>
            <button type="submit">S'inscrire</button>
        </form>
    </section>

    <?php include_once './include/footer.php'; ?>
</body>

</html>