<div  class="col-lg-3"></div>
<div  class="page login col-lg-5">
<!--INI DIV ERRO-->

<!-- CODIGO PHP para enviar correo de recuperacion de contrasena-->

<?php



if(isset($_POST['flag']))
{

	//inicio variables de session
	$mail = $_POST['mail'];


	$mail_verify = $this->model->Query_value('SAX_USER','email',"where email='".$mail."' and onoff='1'");

	


if ($mail_verify){

	
		$control_key = rand(10,10000);

		$control_query = "UPDATE SAX_USER SET Recover_key = '".$control_key."' WHERE email = '".$mail."';";

		$this->model->Query($control_query);

		$control_key = $this->model->encriptar($control_key);
		
		$mail = $this->model->encriptar($mail);
		


$subject = utf8_decode('Recuperacion de Contraseña');

$message_to_send ='<html>
<head>
<meta charset="UTF-8">
</head>
<body>
Sistema de Recuperacion de Password:<br><br>


Estimado usuario por favor haga click en el boton "Recuperar Password" y defina un nuevo password.<br><br>

<a href="'.URL.'index.php?url=login/pass_recovery/'.$mail.'/'.$control_key.'" type="button" id="pass_recover" >Recuperar Password</a>

</body>
</html>';


$this->model->send_mail($mail_verify,$subject,$message_to_send);

?>
    <script>

      self.location= "<?php echo URL; ?>index.php?url=login/forgot_pass_succ";

    </script>

<?php }else{ ?>
    <script>
      alert('Error: El email de usuario no existe');
    </script>
<?php } } ?>
 



<!--INI DIV ERROR-->

			<div class="col-lg-12">
			
			
				<!-- Add class "fade-in-effect" for login form effect -->
				<form action="" method="POST" role="form" id="login" >

					<input type="hidden" name='flag' value="1" />
                                        
					<div class="col-lg-12 login-header">
					<div class="separador col-lg-12"></div>
						<a href="#" class="logo">
							<center><img src="img/logo.jpg" alt="" width="250" /></center>
							
						</a>
						
						
					</div>
                                        
                       
	               <div class="separador col-lg-12"></div>

					    <div class="col-lg-12">

							<div class="form-group col-lg-12">
							<h3 class="login_title" >Recuperacion de Contraseña</h3>
							</div>

							<div class="form-group col-lg-12">

								<p style="color:red"><strong>*Estimado usuario por favor ingrese su correo electronico donde recibira el procedimiento para recuperar su password</strong></p>

							<div class="separador col-lg-12"></div>
								<label class="control-label" for="username">Email</label>
								<input type="text" class="form-control" id="mail" name="mail"  autocomplete="off" />
							</div>	

							<div class="separador col-lg-12"></div>
							<div class="separador col-lg-12"></div>

							<div class="form-group col-lg-4">
								<button type="submit" class="btn btn-primary  btn-block text-left">
								<i style="color: white;" class="fa fa-lock"></i> Enviar Correo
								</button><br>
							</div>
	
	                        

							<div class="separador col-lg-12"></div>
 
					    </div>
					
				</form>
			
		</div>
		
	</div>
