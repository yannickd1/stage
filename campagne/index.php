<?php
require 'admin/database.php';


session_start();
if(!isset($_SESSION['username'])){
    header("location:login.php");
}

?>



<!DOCTYPE html>
<html>
<head>
<title>campagne</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="style.css">
    <script src="js/script.js"></script>


</head>

<body>


<div class="container">
<form method="POST" id="createFolder">
    <h2>Créer une nouvelle campagne:</h2>

    <div class="form-group">
        <input class="form-control" type="text" id="cname" name="cname"  placeholder="Saisissez un nom" maxlength="20" >
        <p class="comments comments_nom"></p>
    </div>

    <div class="form-group">
        <input type="text" class="form-control" id="titreCampagne" name="titreCampagne" placeholder="Saisissez un titre de campagne :" maxlength="40" value="">
        <p class="comments comments_titreCampagne"></p>
    </div>

    <div class="form-actions">
        <button class="btn btn-primary" type="submit" id="submit" name="submit" value="Valider">Valider</button>
    </div>
</form>
    <br><br>

<?php


$dir=getcwd();

echo'<form method="post" action="">';
echo'<h2>Choisir une campagne:</h2>';
    echo'<select class="form-control" name="dname">';
$repertoires=array_diff( scandir($dir), array(".", "..", "admin", ".idea","js") );
    foreach($repertoires as $repertoire) {
    if(is_dir($repertoire)) {

        echo'<option value="'.$repertoire.'">'.$repertoire.'</option>';

        }
    }
echo'</select><br><br>';
    echo'<div class="form-actions">';
    echo'<button class="btn btn-primary" type="submit" value="Valider">Valider</button>';
    echo'</div>';
echo'</form>';


?>

   <?php


   if(isset($_POST["dname"])){

       header('Location:'.$_POST["dname"].'/edit/view.php');
       exit();

   }
                      ?>

</div>
</body>
</html>
