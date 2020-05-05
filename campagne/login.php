<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/interactjs@1.3.4/dist/interact.min.js"></script>

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="admin/css/style.css">
    <script src="admin/js/script.js"></script>
    <?php

  $path= getcwd();
    $name = basename($path);
    echo'<title>'.$name.'</title>';
    ?>
</head>
<body>
<div id="containerLogin">
    <!-- zone de connexion -->

    <form id="formu" style="text-align: center" action="admin/checkLogin.php" method="POST">
        <div class="contact"><h1>Connexion</h1></div>
        <br>
        <br>
        <div class="form-champ">
        <input class="formInp" type="text" size="30" placeholder="Nom d'utilisateur" name="username"><br><br>
        </div>

        <div class="class-form-champ">
        <input class="formInp" type="password" size="30" placeholder="Mot de passe" name="password">
        <input class="formInp" type="hidden" size="30" name="campagne" value="<?php echo $name?>">
        </div>
        <br>
        <br>
        <br>
        <div class="col ">
            <input class="formSubmit form-champ"  type="submit" id='submitLogin' name="submit" value='Se connecter'>
        </div>


        <?php

        
        if(isset($_GET['erreur'])){
            $err = $_GET['erreur'];
            if($err==1 || $err==2)
                echo "<p style='color:red'>Utilisateur ou mot de passe incorrect</p>";
        }
        ?>
    </form>

</div>
</body>
</html>
