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
