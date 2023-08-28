<?php
ini_set('display_errors', '1');
require 'includes/PHPMailer.php';
require 'includes/SMTP.php';
require 'includes/Exception.php';
//Define name spaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>
<?php
// OTP GENERATOR
function generateOTP($length = 6)
{
    $otp = "";
    $characters = "0123456789"; // Characters to use for OTP

    $character_count = strlen($characters);

    for ($i = 0; $i < $length; $i++) {
        $random_index = mt_rand(0, $character_count - 1);
        $otp .= $characters[$random_index];
    }

    return $otp;
}

if (isset($_POST['otp'])) {
    error_reporting(E_ALL);

    $email = $_POST["email"];
    $otp = generateOTP();

    //Create instance of PHPMailer
    $mail = new PHPMailer();
    //Set mailer to use smtp
    $mail->isSMTP();
    //Define smtp host
    $mail->Host = "mail.loremipsum.com";
    //Enable smtp authentication
    $mail->SMTPAuth = true;
    //Set smtp encryption type (ssl/tls)
    $mail->SMTPSecure = "tls";
    //Port to connect smtp
    $mail->Port = "587";
    //Set gmail username
    $mail->Username = "support@loremipsum.com";
    //Set gmail password
    $mail->Password = ".loremipsum.com[m8";
    //Email subject
    $mail->Subject = "Your OTP";
    //Set sender email
    $mail->setFrom('support@loremipsum.com', 'Support');
    //Enable HTML
    $mail->isHTML(true);
    //Attachment

    //Email body
    $mail->Body = "<!DOCTYPE html>
    <html>
      <head>
        <meta charset='UTF-8' />
        <meta name='viewport' content='width=device-width, initial-scale=1.0' />
        <title>Email Template</title>
        <style>
          body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
          }
    
          .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
          }
    
          .header {
            text-align: center;
            margin-bottom: 20px;
          }
    
          .content {
            padding: 20px;
            border-top: 1px solid #ccc;
          }
    
          .otp {
            text-align: center;
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #007bff;
          }
    
          .message {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
          }
    
          .footer {
            text-align: center;
            margin-top: 20px;
            color: #888;
          }
    
          .footer a {
            color: #007bff;
            text-decoration: none;
          }
    
          @media (max-width: 768px) {
            .container {
              max-width: 100%;
              padding: 10px;
            }
          }
        </style>
      </head>
      <body>
        <div class='container'>
          <div class='header'>
            <h2 style='color: #007bff'>One Time Password</h2>
          </div>
          <div class='content'>
            <p>Hello there,</p>
            <p>Your OTP for secure access is:</p>
            <p class='otp'>$otp</p>
            <p class='message'>This OTP will expire in 10 minutes.</p>
            <p>Thank you for using our service!</p>
          </div>
          <div class='footer'>
            <p>&copy; 2023 copyright. All rights reserved.</p>
          </div>
        </div>
      </body>
    </html>
    ";
    $mail->addAddress("$email");
    if ($mail->send()) {
        echo "
        <script> 
        alert('Your One Time Password has been Sent To Your Email.');
        window.location.href = '../index.html';
        </script>";
    };
}
