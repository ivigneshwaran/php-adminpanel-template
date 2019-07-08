<?php
require("vendor/phpmailer/phpmailer/src/PHPMailer.php");
require("vendor/phpmailer/phpmailer/src/SMTP.php");

if(isset($_POST['submit'])){
    $day = $_POST['hoss-time'];
    $h_day = explode(',',$day);
    $date = $_POST['date'];
    $h_date = explode('/', $date);
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    
    //From email address and name
    $mail->From = "from@yourdomain.com";
    $mail->FromName = "your name";
    
    //To address and name
    $mail->addAddress("example@gmail.com", 'name');
    $mail->addAddress("example@gmail.com"); //Recipient name is optional
    
    //Address to which recipient will reply
    $mail->addReplyTo("examle@gmail.com", "Reply");
    
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
    				<td><strong>Hospital</strong></td><td>:</td><td>".$_POST['hospital']."</td>					
    			</tr>
    			<tr>
    				<td><strong>Day & Time</strong></td><td>:</td><td>".$h_day[1]."</td>					
    			</tr>
    			<tr>
    				<td><strong>Date</strong></td><td>:</td><td>".$h_date[1]."-".$h_date[0]."-".$h_date[2]."</td>					
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
            </script>";
    } 
    else 
    {
        echo "<script>
                alert('Email Sent Successfully!');
                window.history.back();
            </script>";
    }
}
