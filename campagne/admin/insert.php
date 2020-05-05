<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location:login.php");
}
require 'database.php';





$altError = $topError = $imageError = $campagneError = $buttonError = $alt = $top = $image = $campagne = $button = "";



if(!empty($_POST))
{

    $alt        = checkInput($_POST['alt']);
    $top           = checkInput($_POST['top']);
    $image              = checkInput($_FILES["image"]["name"]);
    $campagne   =$_GET['nom'];
    $button          = checkInput($_POST['libelle']);
    $imagePath          = '../'.$campagne.'/img/'. basename($image);
    $imageExtension     = pathinfo($imagePath,PATHINFO_EXTENSION);
    $isSuccess          = true;
    $isUploadSuccess    = false;

    if(empty($alt))

    {
        $altError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }
    if(empty($top) )
    {
        $topError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }

    if( $top < 0 )
    {
        $topError = 'Ce champ doit être positif';
        $isSuccess = false;
    }

    if( $top == 0 )
    {

        $isSuccess = true;
    }
    if(empty($image))
    {
        $imageError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }

    if(empty($campagne))
    {
        $campagneError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }

    if(empty($button))
    {
        $buttonError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }

    else
    {
        $isUploadSuccess = true;
        if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif" )
        {
            $imageError = "Les fichiers autorises sont: .jpg, .jpeg, .png, .gif";
            $isUploadSuccess = false;
        }
        if(file_exists($imagePath))
        {
            $imageError = "Le fichier existe deja";
            $isUploadSuccess = false;
        }
        if($_FILES["image"]["size"] > 500000)
        {
            $imageError = "Le fichier ne doit pas depasser les 500KB";
            $isUploadSuccess = false;
        }
        if($isUploadSuccess)
        {
            if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath))
            {
                $imageError = "Il y a eu une erreur lors de l'upload";
                $isUploadSuccess = false;
            }
        }
    }

    if($isSuccess && $isUploadSuccess)
    {

        $db = Database::connect();
        $statement = $db->prepare("INSERT INTO tranche (alt,top,image, campagne,button) values(?, ?, ?, ?,?)");
        $statement->execute(array($alt,$top,$image, $campagne,$button));
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
        <h1><strong>Ajouter une tranche</strong></h1>
        <br>
        <form class="form" action="insert.php?nom=<?php echo $campagne;?>" role="form" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="alt">alt:</label>
                <input type="text" class="form-control" id="alt" name="alt" placeholder="" value="<?php echo $alt;?>">
                <span class="help-inline" style="color: red"><?php echo $altError;?></span>
            </div>
            <div class="form-group">
                <label for="top">top (en px):</label>
                <input type="number" class="form-control" id="top" name="top" placeholder="" value="<?php echo $top;?>">
                <span class="help-inline" style="color: red"><?php echo $topError;?></span>
            </div>

            <div class="form-group">
                <label for="libelle">Bouton onclick Formulaire:</label>
                <select class="form-control" id="libelle" name="libelle">
                    <?php
                    $db = Database::connect();
                    foreach ($db->query('SELECT * FROM button') as $row)
                    {
                        echo '<option value="'. $row['id_button'] .'">'. $row['libelle'] . '</option>';
                    }
                    Database::disconnect();
                    ?>
                </select>
                <span class="help-inline"><?php echo $buttonError;?></span>
            </div>

            <div class="form-group">
                <label for="campagne">campagne:</label>
                <input type="text" class="form-control" id="campagne" name="campagne" placeholder="" value="<?php echo $campagne;?>" disabled>
                <span class="help-inline" style="color: red"><?php echo $campagneError;?></span>
            </div>

            <div class="form-group">
                <label for="image">Sélectionner une image:</label>
                <input style="color: #325080;" type="file" id="image" name="image">
                <span class="help-inline" style="color: red"><?php echo $imageError;?></span>
            </div>
            <br>
            <div class="form-actions">

                <a class="btn btn-primary" id="back" href="../<?php echo $campagne ?>/edit/majPos.php">Retour</a>


                <button type="submit" id="validate" class="btn btn-success"> Ajouter</button>

            </div>
        </form>
    </div>
</div>
</body>
</html>
