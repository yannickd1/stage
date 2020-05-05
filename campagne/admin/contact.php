<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] !='XMLHttpRequest'){
    exit;
}


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

$array = array("nom" => "", "ok" => "", "email" => "", "tel" => "", "call" => "", "nomError" => "", "okError" => "", "callError" => "", "telError" => "", "isSuccess" => false);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $array["nom"] = test_input($_POST["nom"]);
    $array["ok"] = test_input($_POST["ok"]);
    $array["email"] = test_input($_POST["email"]);
    $array["tel"] = test_input($_POST["tel"]);
    $array["call"] = test_input($_POST["call"]);
    $array["isSuccess"] = true;
    $emailText = "";


    if (!isNom($array["nom"])) {
        $array["nomError"] = "Merci de renseigner votre nom.";
        $array["isSuccess"] = false;
    } else {
        $emailText .= "nom: {$array['nom']}\n";
    }

    if (empty($array["ok"])) {
        $array["okError"] = "Merci d'accepter les conditions";
        $array["isSuccess"] = false;
    } else {
        $emailText .= "ok: {$array['ok']}\n";
    }

    if (!isEmail($array["email"])) {
        $array["emailError"] = "Merci de saisir une adresse email valide.";
        $array["isSuccess"] = false;
    } else {
        $emailText .= "Email: {$array['email']}\n";
    }


    if (empty(istel($array["tel"])) && !empty($array["call"])) {
        $array["telError"] = "Merci saisir votre numéro de télèphone si vous souhaitez être rappelé.";
        $array["isSuccess"] = false;
    } else {
        $emailText .= "tel: {$array['tel']}\n";
    }

    if($array["isSuccess"])
    {

        // require 'PHPMailer/src/Exception.php';
        // require 'PHPMailer/src/PHPMailer.php';
        // require 'PHPMailer/src/SMTP.php';

//Create a new PHPMailer instance
        $mail = new PHPMailer;


//Tell PHPMailer to use SMTP
        $mail->isSMTP();
        $mail->IsHTML(true);
        $mail->CharSet = "utf-8";
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
        $mail->SMTPDebug = 0;
//Set the hostname of the mail server
        $mail->Host = 'smtp.gmail.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6
//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $mail->Port = 587;
//Set the encryption system to use - ssl (deprecated) or tls
        $mail->SMTPSecure = 'tls';
//Whether to use SMTP authentication
        $mail->SMTPAuth = true;
//Username to use for SMTP authentication - use full email address for gmail
        $mail->Username = "yannickdia31@gmail.com";
//Password to use for SMTP authentication
        $mail->Password = "amadou31";
//Set who the message is to be sent from
        $mail->setFrom('yannickdia31@gmail.com', 'Yannick');
//Set an alternative reply-to address
//$mail->addReplyTo('replyto@example.com', 'First Last');
////Set who the message is to be sent to
        $mail->addAddress('yannick_dia@hotmail.com', 'John Doe');
//Set the subject line
        $mail->Subject = 'Fiche contact prospect';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.php'), __DIR__);
////Replace the plain text body with one created manually
        $mail->AltBody = '';
        $mail->Body    = '<p>Bonjour,</p><p>Voici un nouveau prospect :</p><p>Nom : '.$array["nom"].'</p><p>Email : ' .$array['email'].'</p><p>Numéro de télèphone : ' .$array['tel'].'</p><p>Mme/Mr '.$array['nom'].' souhaite être contacté par téléphone : ' .$array['call'].'</p><p>Mme/Mr '.$array['nom'].' a accepté les conditions rgpd : '.$array['ok'].'</p>';
//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');
//send the message, check for errors
        if ($mail->send()) {
//                echo "Message sent!";
            //Section 2: IMAP
            //Uncomment these to save your message in the 'Sent Mail' folder.
            #if (save_mail($mail)) {
            #    echo "Message saved!";
            #}
            $array["isSuccess"] = true;
        } else {

//                echo "Mailer Error: " . $mail->ErrorInfo;
        }

     }

    echo json_encode($array);

}
function isNom($nom)
{
    return filter_var($nom, FILTER_SANITIZE_STRING);
}

function isEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function istel($tel)
{
    return preg_match("/^(0|\+33)[1-9]([-. ]?[0-9]{2}){4}$/", $tel);
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
