<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
App\General::root_include('app/tpl/includes/classes/Mail/vendor/autoload.php');

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'dkclay@memphis.edu';                     //SMTP username
    $mail->Password   = 'U$ArmyR0TCBN006!!';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;
    $mail->SMTPDebug = 3;
    $mail->Debugoutput = function($str, $level) {echo "debug level $level;<br /> message $str<br/>";};                         //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('bregenzer@theoldmountain.com', 'Jessie Bregenzer');
    $mail->addReplyTo('clay@theoldmountain.com');
    //$mail->addAddress('test-68coh3ucb@srv1.mail-tester.com', 'Joe User');     //Add a recipient
    /*$list = [
      "jbetancourt2313@yahoo.com",
      "savyybet@aol.com",
      "nikhilherur@gmail.com",
      "jovannabetancourt@gmail.com",
      "jovannabetancourt@yahoo.com",
      "damundclay@gmail.com"
   ]*/

    $list = ["damundclay@gmail.com"];

    foreach($list as $email)
    {
      $mail->addBCC($email);
    }

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Memorandum For Record (Betancourt v Old Mountain)';
    $mail->Body    = file_get_contents('body.php');

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
