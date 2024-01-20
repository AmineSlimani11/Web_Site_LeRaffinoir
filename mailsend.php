
<?php
require 'PHPMailer/PHPMailerAutoload.php';
    $mail = new PHPMailer;

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'leraffinoir62100@gmail.com'; 
    $mail->Password = 'vhyjgamxczjudwdw';  
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('leraffinoir62100@gmail.com', 'LeRaffinoir');
    $mail->addAddress($email);  
    $mail->isHTML(true);
    
?>