<?php

$array = array("nom" => "","titreCampagne" => "", "nomError" => "","titreCampagneError" => "", "isSuccess" => false);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $array["nom"] = test_input($_POST["cname"]);
    $array["titreCampagne"] = test_input($_POST["titreCampagne"]);


    $array["isSuccess"] = true;



    if (!cleanName($array["nom"])) {
        $array["nomError"] = "Merci de saisir un nom valide.";
        $array["isSuccess"] = false;
    }

    if (empty($array["nom"])) {
        $array["nomError"] = "Merci de renseigner le nom du dossier.";
        $array["isSuccess"] = false;
    }

    if(isset($array["nom"]) && file_exists($array["nom"])){
      $array["nomError"] ="Le fichier existe déjà! Veuillez modifier le nom.";
        $array["isSuccess"] = false;
}

    if (!cleanTitle($array["titreCampagne"])) {
        $array["titreCampagneError"] = "Merci de saisir un titre de campagne valide.";
        $array["isSuccess"] = false;
    }

    if (empty($array["titreCampagne"])) {
        $array["titreCampagneError"] = "Merci de renseigner un titre de campagne.";
        $array["isSuccess"] = false;
    }



    if($array["isSuccess"] )
    {


        require 'admin/database.php';


        $db = Database::connect();
        $statement = $db->prepare("INSERT INTO campagne (nom, titreCampagne) values(?,?)");
        $statement->execute(array($array["nom"], $array["titreCampagne"]));
        Database::disconnect();

            /*current folder*/
            $dir=getcwd();
            /* Source directory  */
            $src = '/'.$dir.'/gabarit';

            /* Full path to the destination directory */
            $dst = '/'.$dir.'/'.$array["nom"];
            // create folder
            mkdir($array["nom"], 0777); // Creates a folder in this directory named whatever value returned by pname input


            function copieGabarit($src, $dst) {

                /* Returns false if src doesn't exist */
                $dir = @opendir($src);

                /* Make destination directory. False on failure */
                if (!file_exists($dst)) @mkdir($dst);

                /* Recursively copy */
                while (false !== ($file = readdir($dir))) {

                    if (( $file != '.' ) && ( $file != '..' )) {
                        if ( is_dir($src . '/' . $file) ) copieGabarit($src . '/' . $file, $dst . '/' . $file);
                        else copy($src . '/' . $file, $dst . '/' . $file);
                    }
                }
                closedir($dir);
            }


            //       /* Usage */
                  copieGabarit($src, $dst);


    }

    echo json_encode($array);
}


function cleanName($nom){
    return preg_match("/^[a-zA-Z0-9]+$/", $nom);

}

function cleanTitle($titreCampagne){
    return preg_match("/^[a-zA-Z0-9]+$/", $titreCampagne);

}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

