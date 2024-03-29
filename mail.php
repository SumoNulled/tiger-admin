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
    $mail->Host       = '';                     		//Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = '';                     		//SMTP username
    $mail->Password   = '';                               	//SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('', 'Jessie Bregenzer');
    $mail->addReplyTo('');
    //$mail->addAddress('test-68coh3ucb@srv1.mail-tester.com', 'Joe User');     //Add a recipient
    $list = [
      "@yahoo.com",
      "@aol.com",
      "@gmail.com",
      "@gmail.com",
      "@yahoo.com",
      "@gmail.com"
    ];

    foreach($list as $email)
    {
      $mail->addBCC($email);
    }

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Subject';
    $mail->Body    = file_get_contents('body.php');

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
