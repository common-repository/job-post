<?php

require 'class.phpmailer.php';
include('class.smtp.php');

$smtp_host = get_option('rctjp_smtp_host');
$smtp_port = get_option('rctjp_smtp_port');
$smtp_username = get_option('rctjp_smtp_username');
$smtp_password = get_option('rctjp_smtp_password');

$mail = new PHPMailer;
$mail->SMTPDebug = 0;   
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->Host = "$smtp_host";
//	$mail->Port = 25,465,587
$mail->Username = "$smtp_username";
$mail->Password = "$smtp_password";
$mail->SMTPSecure = "ssl";       //tls , ssl
//Set TCP port to connect to 
$mail->Port = $smtp_port;   

$mail->SetFrom($smtp_username);
$mail->isHTML(true);
