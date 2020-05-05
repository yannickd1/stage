<?php

if($_SERVER["REQUEST_METHOD"] == "GET") {

    require 'database.php';
    $name = $_GET['campagne'];
    $id = $_GET['id'];
    $db = Database::connect();
    $statement=$db->prepare('SELECT * FROM tranche WHERE id='.$id);
    $statement->execute(array($id));
    $imgRow=$statement->fetch(PDO::FETCH_ASSOC);
    unlink("../".$name."/img/".$imgRow['image']);
    $statement = $db->prepare("DELETE FROM tranche WHERE id =".$id);
    $statement->execute(array($id));
    Database::disconnect();
    header("location: ../".$name."/edit/majPos.php");


}