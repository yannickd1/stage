<?php

if($_SERVER["REQUEST_METHOD"] == "GET") {


    require 'database.php';

    $id = $_GET['id'];
    $top = $_GET['newPosition'];
    $db = Database::connect();
    $statement = $db->query('UPDATE tranche SET top ='.$top.'  WHERE id='.$id);
    return true;

}

