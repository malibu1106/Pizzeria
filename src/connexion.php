<?php session_start();
if(!empty($_SESSION['info_message'])){
    // echo $_SESSION['info_message'];
} ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../img/favicon.png" />
    <link rel="stylesheet" href="../css/connexion.css">
    <link rel="stylesheet" href="../css/include_css/nav.css">
    <script src="js/login.js" defer></script>
    <title>El Chorizo Connexion</title>

</head>

<body>
    <header>
        <?php include_once './include/nav.php'; ?>
    </header>

    <h1>Connexion / Inscription</h1>

    <!-- Formulaire de Connexion -->
    <div class="login-container" id="login-form">
        <h2>Connexion</h2>
        <form action="php_sql/login_handler.php" method="POST">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" placeholder="Entrez votre email" required>

            <div class="password-container">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>
                <span class="toggle-password" onclick="togglePassword('password', this)">
                    <img class="show-hide-password" src="img/icons/show_password.png"
                        alt="Afficher/Masquer mot de passe">
                </span>
            </div>

            <input type="submit" value="Se connecter">

            <div class="forgot-password">
                <a href="#">Mot de passe oublié ?</a>
            </div>
        </form>
    </div>

    <!-- Formulaire d'Inscription -->
    <div class="signin-container" id="signin-form">
        <h2>Inscription</h2>
        <form id="signup-form" action="php_sql/signup_handler.php" method="POST">
            <label for="first_name">Prénom :</label>
            <input type="text" id="first_name" name="first_name" placeholder="Entrez votre prénom" required>

            <label for="last_name">Nom :</label>
            <input type="text" id="last_name" name="last_name" placeholder="Entrez votre nom" required>

            <label for="si_email">Email :</label>
            <input type="email" id="si_email" name="si_email" placeholder="Entrez votre email" required>

            <div class="password-container">
                <label for="si_password">Mot de passe :</label>
                <input type="password" id="si_password" name="si_password" placeholder="Entrez votre mot de passe"
                    required>
                <span class="toggle-password" onclick="togglePassword('si_password', this)">
                    <img class="show-hide-password" src="img/icons/show_password.png"
                        alt="Afficher/Masquer mot de passe">
                </span>
            </div>

            <div class="password-container">
                <label for="si_retyped_password">Confirmez le mot de passe :</label>
                <input type="password" id="si_retyped_password" name="si_retyped_password"
                    placeholder="Confirmez votre mot de passe" required>
                <span class="toggle-password" onclick="togglePassword('si_retyped_password', this)">
                    <img class="show-hide-password" src="img/icons/show_password.png"
                        alt="Afficher/Masquer mot de passe">
                </span>
            </div>

            <div id="error-message" style="color:red;"></div> <!-- Zone d'erreurs -->

            <input type="submit" value="S'inscrire">
        </form>
    </div>

    <!-- Boutons de bascule entre Connexion et Inscription -->
    <div class="toggle-buttons">
        <button id="show-signin-btn">S'inscrire</button>
        <button id="show-login-btn" style="display:none;">Se connecter</button>
    </div>

</body>

</html>