<?php

require 'database.php';

session_start();
if(isset($_SESSION['username']) && $_SESSION['username'] !== "") {
    $user = $_SESSION['username'];
}
else
{
    header("location:login.php");
}

$altError = $backgroundError = $campagneError = $alt = $background = $campagne = "";

if(!empty($_POST))
{

    $alt        = checkInput($_POST['alt']);
    $background             = checkInput($_FILES["background"]["name"]);
    $campagne   =$_GET['nom'];
    $imagePath          = '../'.$campagne.'/img/background/'.basename($background);
    $imageExtension     = pathinfo($imagePath,PATHINFO_EXTENSION);
    $isSuccess          = true;
    $isUploadSuccess    = false;

    if(empty($alt))
    {
        $altError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }

    if(empty($background))
    {
        $backgroundError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }

    if(empty($campagne))
    {
        $campagneError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }
    else
    {
        $isUploadSuccess = true;
        if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif" )
        {
            $backgroundError = "Les fichiers autorises sont: .jpg, .jpeg, .png, .gif";
            $isUploadSuccess = false;
        }
        if(file_exists($imagePath))
        {
            $backgroundError = "Le fichier existe deja";
            $isUploadSuccess = false;
        }
        if($_FILES["background"]["size"] > 500000)
        {
            $backgroundError = "Le fichier ne doit pas depasser les 500KB";
            $isUploadSuccess = false;
        }
        if($isUploadSuccess)
        {
            if(!move_uploaded_file($_FILES["background"]["tmp_name"], $imagePath))
            {
                $backgroundError = "Il y a eu une erreur lors de l'upload";
                $isUploadSuccess = false;
            }
        }
    }

    if($isSuccess && $isUploadSuccess)
    {
        $db = Database::connect();
        $statement = $db->prepare("INSERT INTO background (alt,background, campagne) values(?, ?, ?)");
        $statement->execute(array($alt,$background, $campagne));
        Database::disconnect();
        header("Location: ../".$campagne."/edit/majPos.php");
    }
}

function checkInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html>
<head>
    <?php
    $campagne = $_GET['nom'];
    echo'<title>'.$campagne.'</title>';
    ?>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<div class="row">
    <div class="col-sm-6">
        <h1><strong>Ajouter un background</strong></h1>
        <br>
        <form class="form" action="background.php?nom=<?php echo $campagne;?>" role="form" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <input type="hidden" class="form-control" id="alt" name="alt" placeholder="" value="background">
                <span class="help-inline"><?php echo $altError;?></span>
            </div>
            <div class="form-group">
                <label for="background">Sélectionner un background:</label>
                <input style="color: #325080;" type="file" id="background" name="background">
                <span class="help-inline" style="color: red"><?php echo $backgroundError;?></span>
            </div>
            <?php
            $campagne = $_GET['nom'];

            ?>
            <div class="form-group">
                <label for="campagne">campagne:</label>
                <input type="text" class="form-control" id="campagne" name="campagne" placeholder="" value="<?php echo $campagne;?>" disabled>
                <span class="help-inline"><?php echo $campagneError;?></span>
            </div>

            <br>
            <div class="form-actions">
                <a class="btn btn-primary" href="../<?php echo $campagne ?>/edit/majPos.php"> Retour</a>
                <button type="submit" class="btn btn-success"> Ajouter</button>

            </div>
        </form>
    </div>
</div>
</body>
</html>
