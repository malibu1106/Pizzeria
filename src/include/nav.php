        <nav>
            <a class="accueil" href="../index.php">
                <img class="logo-navbar" src="../img/el_chorizo_logo.png" alt="el chorizo logo">
            </a>
            <img class="burger-menu" src="../img/logo_burger_menu.png" alt="logo burger menu">

            <ul class="burger-menu-links">
                <li>
                    <a href="../carte.php?filter=all">Pizzas</a>
                </li>
                <?php
                if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== 1){
                echo'
                <li>
                    <a href="../connexion.php">Connexion</a>
                </li>';}
                else{
                    echo'
                    <li>
                        <a href="../php_sql/logout.php">Déconnexion</a>
                    </li>';
                }
                ?>
                <?php
                if (isset($_SESSION['role']) && $_SESSION['role'] !== "user"){
                echo'
                <li>
                    <a href="../back_office/backoffice.php">Gestion</a>
                </li>';}
                ?>
            </ul>
        </nav>