<?php
 error_reporting(0);

 if (isset($_POST['mail'])){

$mail=$_POST['mail'];
$name=$_POST['name'];
$lastname=$_POST['lastname'];
$pass=$_POST['pass_1'];
$role= 'user';



$mail_verify = $this->model->Query_value('SAX_USER','email',"where email='".$mail."' and onoff='1'");


if (!$mail_verify){

	$pass = md5($pass);

	$columns  = array( 'name' => $name,
	               'lastname' => $lastname,
	               'pass' => $pass,
	               'email' => $mail,
	               'role'=> $role,
	               'onoff'=> 0,
	               'ORI_DIR1' => $_POST['ORG_CITY'],
	               'ORI_DIR2' => $_POST['ORG_DEPA'],
	               'ORI_DIR3' => $_POST['ORG_MUNI'],
	               'ORI_DIR4' => $_POST['ORG_CP'],
	               'ORI_DIR5' => $_POST['ORG_REF'],
	               'ORI_TELF' => $_POST['ORG_TEL'],
	                 );

$this->model->insert('SAX_USER',$columns);


$subject = utf8_decode('Te Damos la Bienvenida a Mensajeria Express!');

$message_to_send ='<html>
<head>
<meta charset="UTF-8">
</head>
<body>
Correo de Activacion:<br><br>


Estimado usuario '.$name.' '.$lastname.', por favor haga click en el boton "Activar" para que cuenta sea confirmada exitosamente<br><br>

<a href="'.URL.'index.php?url=bridge_query/activate_user/'.$mail.'" type="button" id="activar" >ACTIVAR!</a>

</body>
</html>';


$this->model->send_mail($mail,$subject,$message_to_send);

?>
    <script>

      self.location= "<?php echo URL; ?>index.php?url=login/sign_up_success";

    </script>

<?php }else{ ?>
    <script>
      alert('Error: El email de usuario ya existe');;
    </script>
<?php } } ?>



<div class="page col-lg-12">

<div  class="col-lg-12">
<!-- contenido -->
<h2>Registro de usuario</h2>
<div class="title col-lg-12"></div>
<div class="separador col-lg-12"></div>


	
  <!--crear usuario-->

	<fieldset >
	<form action="" enctype="multipart/form-data" method="post" role="form" class="form-horizontal">
	<div class="separador col-lg-12"></div>

	<div class="col-lg-6" > 
		<label class="col-lg-4 control-label" >Nombre</label>							
		<div class="col-lg-7">								
		
		<input type="text" class="form-control" id="name" name="name"  required/>
		
		</div>
	</div>

	<div class="col-lg-6" > 
		<label class="col-lg-4 control-label" >Apellido</label>						
		<div class="col-lg-7">								
		
		<input type="text" class="form-control" id="lastname" name="lastname"  required/>
		
		</div>
	</div>
	<div class="separador col-lg-12"></div>

	<div class="col-lg-12" > 
		<label class="col-lg-2 control-label" for="tagsinput-1"> Email</label>								
		<div class="col-lg-4">								
		<div class="input-group">
		<input type="text" class="form-control" name="mail" id="mail" required />		
		<span class="input-group-addon"><i class= "fa fa-envelope-o"></i></span>
		</div>
		</div>
	</div>
	<div class="separador col-lg-12"></div>
	<div class="col-lg-12" > 
		<label class="col-lg-2 control-label" >Password</label>						
		<div class="col-lg-4">								
		
		<input type="password" class="form-control" id="pass_1" name="pass_1" required/>
		
		</div>
	</div>
	<div class="separador col-lg-12"></div>
	<div class="col-lg-12" > 
		<label class="col-lg-2 control-label" >Repetir Password</label>					
		<div class="col-lg-4">								
		
		<input type="password" class="form-control" id="pass_2" name="pass_2" required/>
		
		</div>
	</div>
	<div class="separador col-lg-12"></div>
	<div class="col-lg-12" > 

			<label class="col-lg-2 control-label" for="tagsinput-2">Role de usuario</label>

		<div class="col-lg-4">	
			<input type="text" class="form-control" id="role" name="role" value="user" disabled/>
		</div>

		
	</div>


 <div class="title col-lg-12"></div>
<!-- INI FROM-->
		<div class="col-lg-8">
		<fieldset>
		<legend>Informacion de ubicacion</legend>
            <div class="col-lg-12">
			<table width="100%" border="0" >
				<tr><td width="50%" ><label style="display:inline">Ciudad </label></td><td width="50%" ><input style="width: 100%;"  type="text" id="ORG_CITY" name="ORG_CITY" value="" required /></td></tr>
				<tr><td width="50%" ><label style="display:inline">Departamento </label></td width="50%" ><td><input style="width: 100%;" class="input-control"  type="text" id="ORG_DEPA" name="ORG_DEPA" value="" required /></td></tr>
				<tr><td width="50%" ><label style="display:inline">Municipio</label></td><td width="50%" ><input style="width: 100%;" class="input-control"  type="text"  id="ORG_MUNI" name="ORG_MUNI" value="" required /></td></tr>
				<tr><td width="50%" ><label style="display:inline">C.P</label></td><td width="50%" ><input style="width: 100%;" class="input-control"  type="text"  id="ORG_CP" name="ORG_CP" value="" required /></td></tr>
			    <tr><td width="50%" ><label style="display:inline">Referencias</label></td><td width="50%" ><input style="width: 100%;" class="input-control"  type="text" id="ORG_REF" name="ORG_REF" value="" required /></td></tr>
			    <tr><td width="50%" ><label style="display:inline">Telefono</label></td><td width="50%" ><input style="width: 100%;" class="input-control"  type="text"  id="ORG_TEL" name="ORG_TEL" value="" required /></td></tr>
			</table>
            </div>
		</fieldset>
		</div>
        <!-- END  FROM-->


 <div class="title col-lg-12"></div>

	<div class="col-lg-10"></div>
	<div class="col-lg-2">
	<button   class="btn btn-primary  btn-block text-left" type="submit" >Guardar</button>
	</div>		

	</form>
  </fieldset>
  

  





 </div>
</div>