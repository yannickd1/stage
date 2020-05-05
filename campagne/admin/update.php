<?php

require 'database.php';



$db = Database::connect();
    if(!empty($_GET['id']))
    {
        $id = checkInput($_GET['id']);
    }


    $altError = $topError = $imageError = $campagneError = $alt = $top = $image = $campagne = "";

    if(!empty($_POST))
    {

        $upOne = dirname(__DIR__, 1);
        $name = basename($upOne);
        $alt        = checkInput($_POST['alt']);
        $top          = checkInput($_POST['top']);
        $image              = checkInput($_FILES["image"]["name"]);
        $campagne   = checkInput($_POST["campagne"]);
        $imagePath          = '../'.$campagne.'/img/'. basename($image);
        $imageExtension     = pathinfo($imagePath,PATHINFO_EXTENSION);
        $isSuccess          = true;

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

        if(empty($image)) // le input file est vide, ce qui signifie que l'image n'a pas ete update
        {
            $isImageUpdated = false;
        }

        else
        {
            $isImageUpdated = true;
            $isUploadSuccess =true;
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

        if (($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated))
        {
            $db = Database::connect();
            if($isImageUpdated)
            {
                $statement = $db->prepare("UPDATE tranche  set alt = ?, top = ?, image = ? WHERE id = ?");
                $statement->execute(array($alt,$top,$image,$id));
            }
            else
            {
                $statement = $db->prepare("UPDATE tranche set alt = ?, top = ? WHERE id = ?");
                $statement->execute(array($alt,$top,$id));
            }
            Database::disconnect();
            header("Location: ../".$campagne."/edit/majPos.php");

        }
        else if($isImageUpdated && !$isUploadSuccess)
        {
            $db = Database::connect();
            $statement = $db->prepare("SELECT * FROM tranche where id = ?");
            $statement->execute(array($id));
            $item = $statement->fetch();
            $image          = $item['image'];
            Database::disconnect();

        }
    }
    else
    {
        $db = Database::connect();
        $statement = $db->prepare("SELECT * FROM tranche where id = ?");
        $statement->execute(array($id));
        $item = $statement->fetch();
        $alt    = $item['alt'];
        $top       = $item['top'];
        $image          = $item['image'];
        $campagne       = $item['campagne'];
        Database::disconnect();
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

        echo'<title>'.$campagne.'</title>';
        ?>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/style.css">


    </head>

    <body>
         <div class="">
            <div class="row">
                <div class="col-sm-6">
                    <h1><strong>Modifier une tranche</strong></h1>
                    <br>
                    <form class="form" action="<?php echo 'update.php?id='.$id;?>" role="form" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="alt">alt:
                            <input type="text" class="form-control" id="alt" name="alt" placeholder="alt" value="<?php echo $alt;?>">
                            <span class="help-inline" style="color: red"><?php echo $altError;?></span>
                        </div>

                        <div class="form-group">
                        <label for="top">Top (en px):
                            <input type="number" class="form-control" id="top" name="top" placeholder="" value="<?php echo $top;?>">
                            <span class="help-inline" style="color: red"><?php echo $topError;?></span>
                        </div>


                        <div class="form-group">
                            <input type="hidden" class="form-control" id="campagne" name="campagne" placeholder="" value="<?php echo $campagne;?>" >
                        </div>
                        <div class="form-group">
                            <label for="image">Image:</label>
                            <p><?php echo $image;?></p>
                            <label for="image">Sélectionner une nouvelle image:</label>
                            <input style="color: #325080;" type="file" id="image" name="image">
                            <span class="help-inline" style="color: red"><?php echo $imageError;?></span>
                        </div>
                        <br>
                        <div class="form-actions">
                            <?php   echo'<a class="btn btn-primary" id="back" href="../'.$campagne.'/edit/majPos.php">Retour</a>'; ?>
                            <button type="submit" id="validate" class="btn btn-success">Modifier</button>

                       </div>
                    </form>
                </div>
                <div class="col-sm-6 site">
                    <div class="thumbnail">
                     <?php   echo'<img src="../'.$campagne.'/img/'.$image.'" alt="">'; ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
