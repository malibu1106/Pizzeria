<?php
const DBHOST = "db";
const DBNAME = "pizzeria";
const DBUSER = "pizzaiolo";
const DBPASS = "pizzaiolito_password";

$dsn = 'mysql:host=' . DBHOST . ';dbname=' . DBNAME . ';charset=utf8';

try {
    $db = new PDO($dsn, DBUSER, DBPASS);
    // echo "Connexion BDD réussie";
} catch (PDOException $error) {
    echo "Problème de connexion : ";
    echo $error->getMessage();
}
?>