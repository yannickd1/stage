<?php
require '../../admin/database.php';


session_start();
if(!isset($_SESSION['username'])){
    header("Location:../login.php");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=600">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-61929808-5"></script>
    <script data-cookieconsent="statistics">
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}

        gtag('js', new Date());
        gtag('config', 'UA-61929808-5' );



    </script>

    <script id="Cookiebot" src="https://consent.cookiebot.com/uc.js" data-cbid="41ed9fe6-f4c8-424b-a7e6-417fda15b67e" type="text/javascript" async></script>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/interactjs@1.3.4/dist/interact.min.js"></script>
    <script src="../../admin/js/script.js"></script>
    <link rel="stylesheet" href="../../admin/css/style.css">
    <link rel="stylesheet" href="../../admin/css/animation.css">
    <!--    <link rel="stylesheet" href="http://www.justinaguilar.com/animations/css/animations.css">-->

    <?php


    $db = Database::connect();
    $upOne = dirname(__DIR__, 1);
    $name = basename($upOne);

    $statement = $db->query('SELECT * FROM campagne WHERE nom="'.$name.'"');

    while($item = $statement->fetch())
    {
        echo'<title>'.$name.'</title>';
        Database::disconnect();
    }

    ?>

    <style>
        .star {
            visibility: hidden;
        }

        .fadeIn {
            -webkit-animation: animat_show 0.8s;
            animation: animat_show 0.8s;
            visibility: visible !important;
        }

        @-webkit-keyframes animat_show{
            0%{opacity:0}
            100%{opacity:1}
        }
    </style>




</head>

<body>
<h1>Cookie Declaration</h1>
<script id="CookieDeclaration" src="https://consent.cookiebot.com/41ed9fe6-f4c8-424b-a7e6-417fda15b67e/cd.js" type="text/javascript" async></script>
<div id="menuView" style="display: flex">

    <div>
        <a href="../../index.php" id="accueilBtn" class="btn btn-success btn-lg majPos"><span class="glyphicon glyphicon-plus"></span>Accueil</a>
        <a href="majPos.php" class="btn btn-success btn-lg majPos"><span class="glyphicon glyphicon-plus"></span>Modifier</a>
    </div>

    <div>
        <form method="get" action="../../admin/logout.php">
            <input type="hidden" name="nom" value="<?php echo $name ?>">
            <button id="disconnect" class="btn btn-danger btn-lg" type="submit">Se déconnecter</button>
        </form>
    </div>

</div>

<?php

$db = Database::connect();

$upOne = dirname(__DIR__, 1);
$name = basename($upOne);
$db = Database::connect();

$statement = $db->query('SELECT * FROM tranche JOIN background  WHERE tranche.campagne ="'.$name.'" ORDER BY top DESC LIMIT 1 ');




$up = dirname(__DIR__, 2);
$nameFolder = basename($up);

while($item = $statement->fetch())
{

    $base = dirname(__DIR__, 3);

    $filename= $base.'/'.$nameFolder.'/'.$name.'/img/'.$item['image'];
    $size = getimagesize($filename);
    $dimensions = getimagesize($filename);

    $a =$item['top'];
    $b =$dimensions[1];
//              $c= 100;

    $height = $a + $b;

    echo'<div class="container" id="star" style="height:'.$height.'px;background-image: url(../img/background/'.$item['background'].')" >';

    Database::disconnect();
}


$db = Database::connect();
$upOne = dirname(__DIR__, 1);
$name = basename($upOne);

$form = 1;


$statement = $db->query('SELECT * FROM tranche WHERE  campagne ="'.$name.'" AND button >'.$form);

$cpt=1;
while($item = $statement->fetch())
{


    echo'<div id="'.$cpt.'" class="test" style="top:'.$item['top'].'px; position: absolute;margin-left: -15px"><img class="star" id="'.$item['id'].'" src="../img/'.$item['image'].'" alt=""></div>';

    $cpt++;
    Database::disconnect();
}


$db = Database::connect();
$form = 1;
$statement = $db->query('SELECT * FROM tranche WHERE  campagne ="'.$name.'" AND button='.$form);


while($item = $statement->fetch())
{
    echo'<div id="drag-'.$item['id'].'" class="test" style="top:'.$item['top'].'px; position: absolute;margin-left: -15px"><a id="parIci" onclick="document.getElementById(\'modal-wrapper\').style.display=\'block\'; gtag(\'event\', \'evenement onclick '.$name.'\', {\'event_category\': \'onclick\',\'event_label\': \'accès au formulaire '.$name.'\'})"><img id="'.$item['id'].'" src="../img/'.$item['image'].'" alt=""></div></a>';
    Database::disconnect();
}

?>


</div>

</div>


<div id="modal-wrapper" class="modal">

    <form class="modal-content animate" id="formulaire" method="post" action="" role="form">
        <div class="formu">
            <div class="contact"><h1>On vous rappelle !</h1></div>

            <button type="button" class="close" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <br>

            <div class="form-champ">
                <input class="formInp" type="text" id="nom" name="nom" size="30" placeholder="VOTRE NOM" />
                <p class="comments comments_nom"></p>
            </div> <br>

            <div class="form-champ">
                <span></span><input class="formInp" type="email" id="email" name="email" size="30" placeholder="VOTRE EMAIL" />
                <p class="comments comments_email"></p>
            </div><br>

            <div class="form-champ">
                <input class="formInp" type="tel" id="tel" name="tel" size="30" placeholder="NUMERO DE TELEPHONE" />
                <p class="comments comments_tel"></p>
            </div><br>

            <div class="form-champ">
                <input type="checkbox" id="call" value="Oui" name="call">
                <label style="color:#33517b;" for="call"><p class="rappel">Je souhaite être rappelé.</p></label>
                <p class="comments comments_call"></p>
            </div>

            <div style="padding-left: 20px;padding-right: 20px"  class="form-champ">
                <input type="checkbox" value="Oui" id="ok" name="ok"/>
                <label style="color:#33517b;" for="ok"><p class="soumettre">En soumettant ce formulaire, j'accepte que les informations saisies soient exploitées dans le cadre de la demande de renseignement et de la relation commerciale qui peut en découler.<span style="color:#33517b;">*</span></p></label>
                <p class="comments comments_ok"></p>
                <!-- <p style="color:blue" >Champs obligatoires<span style="color:white;">*</span></p> -->
            </div>

            <div class="col ">
                <input class="formSubmit form-champ" onclick="gtag('event', 'Click', {'event_category': 'Action User','event_label': 'Soumission du formulaire '.'<?php echo $name ;?>'.'})" type="submit" id="submit" name="submit" value="Envoyer">
                <div id="loader"></div>
                <div id="confirmation">
                    <h1>Votre message a bien été envoyé !</h1>
                </div>
                <br><br>


                <a href=" https://www.digeek.fr/-politique-de-confidentialite-.html"><p class="droits">*Pour connaître et exercer vos droits, notamment de retrait de votre consentement à l'utilisation des données collectées par ce formulaire, veuillez consulter notre politique de confidentialité.</p></a>

            </div>


        </div>


    </form>

</div>






<script>






    $(function() {

        $('#formulaire').submit(function(e) {

            e.preventDefault();
            $('.comments').empty();
            var postdata = $('#formulaire').serialize();
            $('#loader').fadeIn(100);

            $.ajax({
                type: 'POST',
                url: '../../admin/contact.php',
                data: postdata,
                dataType: 'json'
            })
                .done(function( json ) {
                    $('#loader').fadeOut( "slow", function() {
                        // Animation complete.
//                        console.log(json);

                        if (json.isSuccess) {
                            /*$('.formu').append("<p id='thank-you'>Votre message a bien été envoyé !</p>");*/
                            $('.form-champ').fadeOut(250, function(){
                                $('#confirmation').fadeIn();
                                $('#formulaire')[0].reset();
                                setTimeout(function() {
                                    $('.modal').fadeOut(500,function(){
                                        $('#confirmation').hide();
                                        $('.form-champ').show();
                                    });
                                }, 5000);
                            });
                        } else {
                            $('.comments_nom').html(json.nomError);
                            $('.comments_email').html(json.emailError);
                            $('.comments_tel').html(json.telError);
                            $('.comments_call').html(json.callError);
                            $('.comments_ok').html(json.okError);
                        }
                    })
                })
                .fail(function() {
                    $('.comments_ok').html('Une erreur est survenue, essayez à nouveau');
                });

        });






        var titreCampagne = $(document).attr("title");


        gtag('event', 'Affichage page', {'event_category': 'General','event_label': '' + titreCampagne +''});



        function showImages(el) {
            var windowHeight = $(window).scrollTop();
            var cpt =1;
            $(el).each(function(){
                var thisPos = $(this).offset().top;

                var topOfWindow = $(window).scrollTop();
                if (topOfWindow + windowHeight + 200 > thisPos ) {
                    $(this).addClass("fadeIn");
                    // console.log($(this).addClass("fadeIn"));
                    gtag('event', 'Apparition bloc', {'event_category': 'Animation','event_label': 'bloc ' + cpt + ' '+ titreCampagne});
                    cpt++;
                    // console.log(cpt);
                }
            });
        }


        // if the image in the window of browser when the page is loaded, show that image
        showImages('.star');

        $(window).scroll(function() {

            showImages('.star');

        });


        <?php
        if(isset($_GET['display_contact'])){
        if($_GET['display_contact']==true){
        ?>

        document.getElementById('modal-wrapper').style.display='block';
        $('#formulaire').show();

        <?php
        }
        } else {
        ?>
        $('#formulaire').hide();
        <?php
        }
        ?>


        $('#confirmation').hide();


        $('#parIci').on("click", function() {
            $('#formulaire').show();
            $('.testBlur').css("color", "blue");

        });

        $('.close').on("click", function() {
            $('#formulaire').hide();
            $('#modal-wrapper').hide();
            $('.container').show();

        });

    });

    // If user clicks anywhere outside of the modal, Modal will close
    var modal = document.getElementById('modal-wrapper');
    window.onclick = function(event) {
        if (event.target == modal) {
            $(modal).fadeOut(500,function(){
                modal.style.display = "none";
            })
        }
    }

</script>

</body>

</html>
