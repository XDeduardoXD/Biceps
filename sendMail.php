<?php 
$mail = $_POST["mail"];
$dateNow = date('Y-m-d');
$palabra = $dateNow . $mail;
$token = hash('sha256', $palabra);
$url= 'https://biceps.cloudsoft.mx/new-password';
$para = $mail;
$titulo = 'BICEPS | RECUPERAR CONTRASEÑA';
$mensaje = '<html>
<head>
    <title>Recuperar Contraseña</title>
</head>
<body>
    <p></p>
    <p>Sigue las instrucciones a continuación para recuperar tu contraseña:</p><p></p>
    <center><img style="width:50%; height:auto;" src="https://biceps.cloudsoft.mx/recover.jpg"></center>
    
    <ul>
        <li>Paso 1: Accede a nuestro <a href=" '.$url.''."?token=".''.$token.''."&mail=".''.$mail.' ">formulario de recuperación de contraseña</a>.</li>
        <li>Paso 2: Ingresa tu correo, tu nueva contraseña</li>
        <li>Paso 3: Haz clic en "Guardar cambios".</li>
        <li>Paso 4: Acceda a su cuenta con sus nuevas credenciales.</li>
    </ul>
    <p>Si no has solicitado la recuperación de contraseña, por favor ignora este mensaje.</p>
</body>
</html>';
$cabeceras = 'From: soporte@cloudsoft.mx' . "\r\n" .
    'Reply-To: soporte@cloudsoft.mx' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
$cabeceras .= "\r\n" . 'MIME-Version: 1.0';
$cabeceras .= "\r\n" . 'Content-Type: text/html; charset=ISO-8859-1';

if (mail($para, $titulo, $mensaje, $cabeceras)) {
    echo 'Ok';
} else {
    echo 'No Ok';
}
