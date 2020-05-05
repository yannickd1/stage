<?php

if($_SERVER["REQUEST_METHOD"] == "GET") {

    require 'database.php';


    $name = $_GET['nom'];
    $db = Database::connect();
    $statement=$db->prepare('SELECT * FROM background WHERE campagne="'.$name.'"');
    $statement->execute(array());
    $imgRow=$statement->fetch(PDO::FETCH_ASSOC);
    unlink("../".$name."/img/background/".$imgRow['background']);
    $statement = $db->prepare('DELETE FROM background WHERE campagne="'.$name.'"');
    $statement->execute(array());
    Database::disconnect();
    header("location: ../".$name."/edit/majPos.php");

}