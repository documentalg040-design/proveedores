<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // si usas Composer

if(isset($_FILES['archivo'])){
    $destino = "uploads/";
    if(!is_dir($destino)){
        mkdir($destino, 0777, true);
    }

    foreach($_FILES['archivo']['tmp_name'] as $key => $tmp_name){
        $nombre = basename($_FILES['archivo']['name'][$key]);
        move_uploaded_file($tmp_name, $destino.$nombre);
    }

    // Configuración de PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'tu_correo@gmail.com'; // tu correo
        $mail->Password = 'tu_contraseña_o_app_password'; // contraseña o App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Remitente y destinatario
        $mail->setFrom('tu_correo@gmail.com', 'Notificaciones Atilatán');
        $mail->addAddress('aehernandezg@grupohame.com');
        $mail->addCC('nhenao@grupohame.com');

        // Contenido
        $mail->isHTML(true);
        $mail->Subject = 'Nuevo documento cargado';
        $mail->Body    = 'Un proveedor ha subido documentos al sistema.<br>Revisa la carpeta <b>uploads/</b>.';

        $mail->send();
        echo "✅ Documentos enviados y notificación enviada.";
    } catch (Exception $e) {
        echo "❌ Error al enviar correo: {$mail->ErrorInfo}";
    }
}
?>
