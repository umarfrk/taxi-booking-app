<?php
// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader (if installed via Composer)
require 'vendor/autoload.php';

// OR Manually load (if you included PHPMailer manually)
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

// Create an instance of PHPMailer
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host       = 'smtp.hostinger.com'; //smtp.gmail.com                 // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                             // Enable SMTP authentication
    $mail->Username   = 'info@QuickTrip.esanwin.com';           // SMTP username (Your email address)
    $mail->Password   = 'info@AMNZ2024';            // SMTP password (Your email password or App-specific password)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` for SSL
    $mail->Port       = 465;                              // TCP port to connect to (TLS: 587, SSL: 465)

    // Recipients
    $mail->setFrom('info@QuickTrip.esanwin.com', 'Theesan');  // Set sender email and name
    $mail->addAddress('tkmtheesan1996@gmail.com', 'Mohanatheesan'); // Add a recipient

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Test Email from PHPMailer';
    $mail->Body    = '<p>This is a <b>test email</b> sent using PHPMailer!</p>';
    $mail->AltBody = 'This is the plain text version for non-HTML email clients.';

    // Send the email
    $mail->send();
    echo 'Message has been sent successfully';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: { $mail->ErrorInfo }";
}
