<?php

 require 'database.php';
session_start();
if(isset($_POST['username']) && isset($_POST['password']))
{

$campagne = $_POST['campagne'];
    // connexion à la base de données
    $db_username = 'root';
    $db_password = 'root';
    $db_name     = 'campagne';
    $db_host     = 'localhost';
    $db = mysqli_connect($db_host, $db_username, $db_password,$db_name)
    or die('could not connect to database');

    $username  = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $password= filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

    if($username !== "" && $password !== "")
    {
        $requete = "SELECT count(*) FROM user where login = '".$username."' and mdp = '".sha1($password)."'";
        $exec_requete = mysqli_query($db,$requete);
        $reponse      = mysqli_fetch_array($exec_requete);

        $count = $reponse['count(*)'];
        if($count!=0) // nom d'utilisateur et mot de passe correctes
        {
            $_SESSION['username'] = $username;
            header('Location:../index.php');
        }
        else
        {
            header('Location:../login.php?erreur=1'); // utilisateur ou mot de passe incorrect
        }
    }
    else
    {
        header('Location:../login.php?erreur=2'); // utilisateur ou mot de passe vide
    }
}
else
{
    header('Location:../login.php');
}
mysqli_close($db); // fermer la connexion
