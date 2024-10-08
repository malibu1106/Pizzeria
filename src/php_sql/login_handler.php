<?php
// ON DEMARRE DIRECTEMENT UNE SESSION POUR GERER LES MESSAGES A AFFICHER EN CAS DE PROBLEME
session_start();

// ON VERIFIE POST + QUE LES CHAMPS NE SONT PAS VIDES ET ON RECUPERE LES VALEURS DU FORMULAIRE
if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email']) && !empty($_POST['password'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    // CONNEXION A LA BDD
    require_once("db_connect.php");

    // REQUETE AVEC CE QU'IL NOUS FAUT A STOCKER EN $_SESSION SI BESOIN 
    $sql = "SELECT * FROM users WHERE email = :email";

    // PREPARATION DE LA REQUETE
    $query = $db->prepare($sql);    
        $query->bindValue(':email', $email);
    
    // EXECUTION + CLOSE BDD
    $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);
        require_once("db_disconnect.php");

    // SI $USER N'EST PAS VIDE > UN COMPTE AVEC CETTE ADRESSE EMAIL EXISTE
    if($user){
    $hashed_password = $user['password']; // ON RECUPERE LE MOT DE PASSE HASHÉ DE CE COMPTE

    // SI LE MOT DE PASSE EST CORRECT
        if (password_verify($password, $hashed_password)) { 
            $_SESSION["info_message"] = "Connexion réussie";
            $_SESSION['loggedIn'] = 1;
            $_SESSION['logged_user_id'] = $user['user_id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['email'] = $user['email'];
            header('Location: ../index.php');} // REDIRECTION, CHECK URL PLUS TARD

    // SI LE MOT DE PASSE EST INCORRECT
        else {
            $_SESSION["info_message"] = "Adresse mail ou mot de passe incorrect";
            header('Location: ../connexion.php');} // REDIRECTION, CHECK URL PLUS TARD
    }
    // USER EST VIDE > AUCUN COMPTE AVEC CETTE ADRESSE EMAIL
    else {
        $_SESSION["info_message"] = "Adresse mail inconnue";
        header('Location: ../connexion.php');} // REDIRECTION, CHECK URL PLUS TARD

}
// SI METHOD != POST OU UN CHAMP EST VIDE
else{
    $_SESSION["info_message"] = "Erreur de traitement";
    header('Location: ../connexion.php');} // REDIRECTION, CHECK URL PLUS TARD

?>