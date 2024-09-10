<?php
session_start(); // Démarrer la session

if (isset($_POST['email']) && !empty($_POST['email'])) {
    $email = $_POST['email'];

    // CONNEXION A LA BDD
    require_once("db_connect.php");

    // REQUETE POUR VERIFIER SI L'EMAIL EXISTE DEJA
    $sql = "SELECT * FROM newsletter_subscribers WHERE email = :email";
    
    // PREPARATION DE LA REQUETE
    $query = $db->prepare($sql);
    $query->bindValue(':email', $email);

    // EXECUTION
    $query->execute();
    $user_exist = $query->fetch(PDO::FETCH_ASSOC);

    // SI L'UTILISATEUR EXISTE
    if ($user_exist) {
        $_SESSION['info_message'] = "Vous êtes déjà inscrit à notre newsletter ! Merci !";
    } else {
        // INSERER L'EMAIL DANS LA BDD
        $sql = "INSERT INTO newsletter_subscribers (email) VALUES (:email)";
        $query = $db->prepare($sql);
        $query->bindValue(':email', $email);
        
        // EXECUTION
        $query->execute();
        $_SESSION['info_message'] = "Inscription réussie à la newsletter ! Merci !";
    }

    // FERMER LA CONNEXION A LA BDD
    require_once("db_disconnect.php");

    // REDIRECTION OU MESSAGE
    header("Location: ../index.php#newsletter");
    exit();
} else {
    // Gérer le cas où l'email n'est pas fourni
    $_SESSION['info_message'] = "Veuillez entrer un email valide.";
    header("Location: ../index.php#newsletter");
    exit();
}
?>