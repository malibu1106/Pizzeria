<?php
session_start();

if (isset($_POST) && !empty($_POST['first_name']) && !empty($_POST['last_name']) 
    && !empty($_POST['email']) && !empty($_POST['password'])) {

    try {
        // Assainir et hacher les données de formulaire
        $first_name = strip_tags($_POST['first_name']);
        $last_name = strip_tags($_POST['last_name']);
        $email = strip_tags($_POST['email']);
        $password = strip_tags($_POST['password']);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        require_once('../php_sql/db_connect.php');

        // Vérifier si l'email existe déjà
        $sql = "SELECT * FROM users WHERE email = :email";
        $query = $db->prepare($sql);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->execute();
        $emailAlreadyUsed = $query->fetch(PDO::FETCH_ASSOC);

        if ($emailAlreadyUsed) { // SI L'ADRESSE MAIL EST DEJA UTILISEE
            $_SESSION['info_message'] = "Adresse email déjà utilisée.";
            header('Location: test_create_user.php'); // Redirection vers la page d'inscription
            exit();
        } else { // SI L'ADRESSE MAIL EST DISPONIBLE
            // Inscription de l'utilisateur dans la base de données
            $sql = "INSERT INTO users (first_name, last_name, email, password)
                    VALUES (:first_name, :last_name, :email, :password)";
            $query = $db->prepare($sql);
            $query->bindValue(':first_name', $first_name, PDO::PARAM_STR);
            $query->bindValue(':last_name', $last_name, PDO::PARAM_STR);
            $query->bindValue(':email', $email, PDO::PARAM_STR);
            $query->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
            $query->execute();

            $_SESSION['info_message'] = "Inscription réussie.";
            header('Location: ../index.php'); // Redirection vers la page d'accueil
            exit();
        }

    } catch (PDOException $e) {
        // Gestion des erreurs de base de données
        $_SESSION['info_message'] = "Erreur lors de l'inscription : " . $e->getMessage();
        header('Location: test_create_user.php'); // Redirection vers la page d'inscription
        exit();
    }

} else {
    $_SESSION['info_message'] = "Formulaire mal rempli.";
    header('Location: test_create_user.php'); // Redirection vers la page d'inscription
    exit();
}
?>