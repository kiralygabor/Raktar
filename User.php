<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once("DBUsers.php");
require_once("UsersDbTools.php");
require_once("AbstractPage.php");
require 'vendor/autoload.php';

$usersDbTools = new UsersDbTools();
class User{

    function __construct(){
        $this->db = new DBUsers();
    }

    function getNewToken(){
        return str_replace(["=", "+"], ["", ""], base64_encode(random_bytes(160/8)));
    }

    function getValidUntil(){
        $validUntil = new DateTime();
        $validUntil->add(new DateInterval('PT1H'));
        return $validUntil->format("Y-m-d H:i:s");
    }

    /*
    function getToken(){
        $sql = "SELECT token FROM users WHERE name = ;";
        $result = $this->mysqli->query($sql);
    }
    */

    function sendRegistrationEmail($token, $email){
        $mail = new PHPMailer(true);

        try {
            //Server settings                     //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'localhost';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = false;                                   //Enable SMTP authentication
            //$mail->Username   = 'user@example.com';                     //SMTP username
            //$mail->Password   = 'secret';                               //SMTP password
            //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port = 1025;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('from@example.com', 'Mailer');
            //$mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
            $mail->addAddress($email);               //Name is optional
            $mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC('cc@example.com');
            $mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('PDF/raktar.pdf');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Regisztracio';
            $mail->Body    = '<b>Kattintson a linkre!</b>';
            $mail->Body    = '<a href="http://localhost:8090/Warehouse/login.php?token='.$token.'"></a>';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
?>