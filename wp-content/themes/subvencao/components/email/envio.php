<?php

$nomeFrom = FROM_NAME;
$emailFrom = FROM_EMAIL;
$params = "-f {$emailFrom}";
$assunto = '';
$headers = "From: SITE SUBVENÇÃO<{$emailFrom}>\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
$email = ADMIN_EMAIL;
$html = '';

if ($formEnviado) {
    $assunto = "Prestação de contas recebida no site da Subvenção";
    // $email = SUBVENCAO_EMAIL;
} else {
    $assunto = "Falha no envio de prestação de contas";
}

require_once 'corpo-email.php';
@mail($email, $assunto, $html, $headers, $params);
