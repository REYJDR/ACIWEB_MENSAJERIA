<?php   


$message = $this->model->get_sol_to_mailing($id);



$message_to_send ='<html>
<head>
<meta charset="UTF-8">
<title>Requisición de materiales</title>
</head>
<body>
<p>SE HA RECIBIDO UNA SOLICITUD DE ENVIO DESDE ACIWEB</p>

'.$message.'


<a href="'.URL.'index.php?url=ges_mensajeria/msg_entrega/'.$id.'" type="button" id="INICIAR" >VER SEGUIMIENTO</a>
  
</body>
</html>';

$mail->IsMAIL(); // enable SMTP
$mail->IsHTML(true);


$sql = "SELECT * FROM CONF_SMTP WHERE ID='1'";

$smtp= $this->model->Query($sql);

foreach ($smtp as $smtp_val) {
  $smtp_val= json_decode($smtp_val);

  $mail->Host =     $smtp_val->{'HOSTNAME'};
  $mail->Port =     $smtp_val->{'PORT'};
  $mail->Username = $smtp_val->{'USERNAME'};
  $mail->Password = $smtp_val->{'PASSWORD'};
  $mail->SMTPAuth = $smtp_val->{'Auth'};
  $mail->SMTPSecure=$smtp_val->{'SMTPSecure'};
  $mail->SMTPDebug= $smtp_val->{'SMTPSDebug'};

  $mail->SetFrom($smtp_val->{'USERNAME'});

}



$mail->Subject = utf8_decode("Solicitud de envio - ".$id);
$mail->Body = $message_to_send;




//VERIFICA USUARIOS CON OPCION D ENOTIFICACION DE ORDEN DE COMPRAS
$sql = 'SELECT name, lastname, email from SAX_USER WHERE notif_oc="1" and onoff="1"';
$address = $this->model->Query($sql);

foreach ($address as  $value) {
$value = json_decode($value);

$mail->AddAddress($value->{'email'}, $value->{'name'}.' '.$value->{'lastname'});

}

$user_mail = $this->model->Query_value('MSG_SOL_HEADER','ORI_MAIL','WHERE NO_SOL="'.$id.'"');

//agrego correo del cliente
$mail->AddAddress($user_mail, '');


if(!$mail->send()) {
 

   $alert .= 'Message could not be sent.';
   $alert .= 'Mailer Error: ' . $mail->ErrorInfo;

     echo '<script> alert("'.$alert.'"); </script>';

} else {
  ECHO '1';
   // echo '<script> alert("Message has been sent"); </script>';
}

?>

</div>
</div>



