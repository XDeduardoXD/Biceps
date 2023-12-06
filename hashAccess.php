<?php
$mail = $_POST["user"] ;
$dateNow = date('Y-m-d');
$palabra = $dateNow.$mail;
$token = hash('sha256', $palabra);
echo $token;