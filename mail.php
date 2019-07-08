<?php
require("vendor/phpmailer/phpmailer/src/PHPMailer.php");
require("vendor/phpmailer/phpmailer/src/SMTP.php");

if(isset($_POST['submit'])){
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    
    //From email address and name
    $mail->From = "info@aapscbsc.com";
    $mail->FromName = "Kneecareindia";
    
    //To address and name
    $mail->addAddress("chennaimedinfo.in@gmail.com", "vicky");
    $mail->addAddress("knee.news@gmail.com"); //Recipient name is optional
    
    //Address to which recipient will reply
    $mail->addReplyTo("info@aapscbsc.com", "Reply");
    
    //CC and BCC
    $mail->addCC("cc@example.com");
    $mail->addBCC("bcc@example.com");
    
    //Send HTML or Plain Text email
    $mail->isHTML(true);
    
    $mail->Subject = "Enquiry From Kneecareindia.in";
    $mail->Body = "<html>
        <head>
            <title>HTML email</title>
        </head>
        <body>
            <table>
                <tr>
    				<td><strong>FullName</strong></td><td>:</td><td>".$_POST['name']."</td>					
    			</tr>
    			<tr>
    				<td><strong>EmailID</strong></td><td>:</td><td>".$_POST['email']."</td>					
    			</tr>
    			<tr>
    				<td><strong>Country</strong></td><td>:</td><td>".$_POST['country']."</td>					
    			</tr>
    			<tr>
    				<td><strong>Mobile</strong></td><td>:</td><td>".$_POST['phone']."</td>					
    			</tr>
    			<tr>
    				<td><strong>Message</strong></td><td>:</td><td>".$_POST['message']."</td>					
    			</tr>
            </table>
        </body>
    </html>";
    $mail->AltBody = "This is the plain text version of the email content for Testing.";
    
    if(!$mail->send()) 
    {
        echo "<script>
                alert('Sorry mail was not send due to some server problem, please try again later!');
                window.history.back();
            </script>" . $mail->ErrorInfo;
    } 
    else 
    {
        echo "<script>
                alert('Email Sent Successfully!');
                window.history.back();
            </script>";
    }
}





/*===============================================================================================================
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';
if(isset($_POST['submit'])){
// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 2;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'ns7-777.999servers.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'info@aapscbsc.com';                     // SMTP username
    $mail->Password   = 'kwaapscbsc@987';                               // SMTP password
    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 465;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('info@aapscbsc.com', 'Mailer');
    $mail->addAddress('vickydevu007@gmail.com', 'vicky');     // Add a recipient
    $mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}*/