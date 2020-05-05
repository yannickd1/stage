<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location:../../login.php");
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/interactjs@1.3.4/dist/interact.min.js"></script>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="../../admin/css/style.css">
    <script src="../../admin/js/script.js"></script>
    <?php
    $upOne = dirname(__DIR__, 1);
    $name = basename($upOne);
    echo'<title>'.$name.'</title>';
    ?>
</head>
<body>
<div id="menu">


    <h5 id="confirmationPos" style="">Les positions ont été sauvegardées!</h5>


    <?php

    require '../../admin/database.php';

    $upOne = dirname(__DIR__, 1);
    $name = basename($upOne);

    echo'<div><a href="../../index.php" id="accueilBtn" class="btn btn-success btn-lg majPos"><span class="glyphicon glyphicon-plus"></span>Accueil</a></div>&nbsp&nbsp';
    echo '<div><a href="view.php" class="btn btn-primary btn-lg majPos">Aperçu</a></div>&nbsp&nbsp';
    ?>

    <div>
        <form method="get" action="../../admin/insert.php">
            <input type="hidden" name="nom" value="<?php echo $name ?>">
            <button class="btn btn-success btn-lg ajouter" type="submit">Ajouter une tranche</button>
        </form>
    </div>&nbsp&nbsp

    <div>

        <form method="get" action="../../admin/background.php">
            <input type="hidden" name="nom" value="<?php echo $name ?>">
            <button class="btn btn-success btn-lg ajouter" type="submit">Ajouter un background</button>
        </form>
    </div>&nbsp&nbsp


    <div>
        <form method="get" action="../../admin/deleteBackground.php">
            <input type="hidden" name="nom" value="<?php echo $name ?>">
            <button class="btn btn-success btn-lg ajouter" type="submit">Supprimer background</button>
        </form>
    </div>&nbsp&nbsp

    <div><button id="valider" class="btn btn-success btn-lg majPos">Valider </button></div>
    <form method="get" action="../../admin/logout.php">
        <input type="hidden" name="nom" value="<?php echo $name ?>">
        <button class="btn btn-danger btn-lg" type="submit">Se déconnecter</button>
    </form>
</div>

<div class="container">

    <?php



    $upOne = dirname(__DIR__, 1);//on récupère le
    $name = basename($upOne);//on récupère le chemin du dossier parent
    $db = Database::connect();// on récupère le nom de la composante finale du chemin $upOne

// on sélectionne tous les enregistrements de la table tranche et background ou la campagne de la tranche est égale au nom du dossier parent, on les classe  en fonction de leur position top de manière décroissante et on selecionne le premier enregistrement.
    $statement = $db->query('SELECT * FROM tranche JOIN background  WHERE tranche.campagne ="'.$name.'" ORDER BY top DESC LIMIT 1 ');

    //Applications/MAMP/htdocs/campagne
    $up = dirname(__DIR__, 2);
    //dossier campagne
    $nameFolder = basename($up);

    while($item = $statement->fetch())
    {

        $base = dirname(__DIR__, 3);

        ///Applications/MAMP/htdocs/campagne/gabarit/img/
        // on récupère le chemin de la tranche ayant la position top la plus élevée
        $filename= $base.'/'.$nameFolder.'/'.$name.'/img/'.$item['image'];

        //nous retourne un tableau contenant les informations de l'image
        $dimensions = getimagesize($filename);

        // la taille de l'image est retourné à l'indice 1.
        $a =$dimensions[1];

        //position top la plus élevées des tranches
        $b =$item['top'];




        $height = $a + $b ;

        echo'<div class="container" id="star" style="height:'.$height.'px;background-image: url(../img/background/'.$item['background'].')" >';

        Database::disconnect();
    }

    $db = Database::connect();
    $form = 1;
    $statement = $db->query('SELECT * FROM tranche WHERE campagne ="'.$name.'" AND button >'.$form);
    $upOne = dirname(__DIR__, 1);
    $name = basename($upOne);


    while($item = $statement->fetch())
    {
        echo'<div id="drag-'.$item['id'].'" class="test draggable" style="top:'.$item['top'].'px; position: absolute;margin-left: -15px"><a class="modif"  href="../../admin/update.php?id='.$item['id'].'"><img src="../../admin/img/svg/edit.svg"width="25px" ></a>';
        echo'<a href="../../admin/delete.php?id='.$item['id'].'&campagne='.$item['campagne'].'" class="suppr"><img src="../../admin/img/svg/delete.svg" width="25px"></a><img  id="'.$item['id'].'" src="../img/'.$item['image'].'" alt=""></div>';
        Database::disconnect();
    }

    $db = Database::connect();
    $form = 1;
    $statement = $db->query('SELECT * FROM tranche WHERE campagne="'.$name.'" AND button ='.$form);


    while($item = $statement->fetch())
    {
        echo'<div id="drag-'.$item['id'].'" class="test draggable" style="top:'.$item['top'].'px; position: absolute;margin-left: -15px"><a class="modif"  href="../../admin/update.php?id='.$item['id'].'"><img src="../../admin/img/svg/edit.svg"width="25px" ></a>';
        echo'<a href="../../admin/delete.php?id='.$item['id'].'&campagne='.$item['campagne'].'" class="suppr"><img src="../../admin/img/svg/delete.svg" width="25px"></a><img  id="'.$item['id'].'" src="../img/'.$item['image'].'" alt=""></div>';
        Database::disconnect();
    }


    ?>

</div>

</body>
</html>
