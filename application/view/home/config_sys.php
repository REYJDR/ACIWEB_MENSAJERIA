<script type="text/javascript">
	
$(document).ready(function() {
    if (location.hash) {
        $("a[href='" + location.hash + "']").tab("show");
    }
    $(document.body).on("click", "a[data-toggle]", function(event) {
        location.hash = this.getAttribute("href");
    });
});
$(window).on("myTab", function() {
    var anchor = location.hash || $("a[data-toggle='tab']").first().attr("href");
    $("a[href='" + anchor + "']").tab("show");
});


</script>

 <?php

 if (isset($_REQUEST['smtp'])) {

	
$value  = array(
'ID' => '1',
'HOSTNAME' => $_REQUEST['emailhost'],
'PORT'     => $_REQUEST['emailport'],
'USERNAME' => $_REQUEST['emailusername'],
'PASSWORD' => $_REQUEST['emailpass'],
'Auth' => 'true',
'SMTPSecure' => 'false',
'SMTPDebug' => '');

$this->model->Query('DELETE from CONF_SMTP;');

$this->model->insert('CONF_SMTP',$value);

unset($_REQUEST);

echo '<script> alert("Se ha actualizado con exito"); window.open("'.URL.'index.php?url=home/config_sys","_self");</script>';


}

 if(isset($_REQUEST['logo'])){

	$target_dir = "img/";

	$target_file = $target_dir . basename($_FILES["imageFile"]["name"]);
 
	$target_file;
	$uploadOk = 1;

	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image

   if ($imageFileType=='jpg'){ 

	      
	        $uploadOk = 1;


	 	   if (move_uploaded_file($_FILES["imageFile"]["tmp_name"], $target_file)) {
	 			

	 		rename("img/".$_FILES["imageFile"]["name"], "img/logo.jpg");
	        

	        echo '<script> alert("Se ha actualizado el logo con exito","ok"); 
	             window.open("'.URL.'index.php?url=home/config_sys","_self");</script>';

            } 


	    } else {

	    	
	        $uploadOk = 0;

	    }

    if ($uploadOk==0){   echo '<script>
	         alert("Se produjo un error al subir la imagen","ok"); window.open("'.URL.'index.php?url=home/config_sys","_self");</script>'; }

}


//ACTUALIZA DATOS DE COMPAÑIA 
if (isset($_REQUEST['comp'])) {
	
$value  = array(
'company_name' => $_POST['company'],
'email' => $_POST['email_contact'],
'address' => $_POST['address'],
'Tel' => $_POST['tel1'],
'Fax' => $_POST['tel2'] );

$this->model->update('company_info',$value,'Where id="1";');

unset($_REQUEST);

echo '<script> alert("Se ha actualizado con exito"); window.open("'.URL.'index.php?url=home/config_sys","_self");</script>';


}




//LLAMO LOS VALORES ACTUALES DE LOS DATOS DE LA COMPAÑIA
$res= $this->model->Get_company_Info();
foreach ($res as $Comp_Info) {
	$Comp_Info = json_decode($Comp_Info);

	$name = $Comp_Info->{'company_name'};
	$email = $Comp_Info->{'email'};
	$address = $Comp_Info->{'address'};
	$tel= $Comp_Info->{'Tel'};
	$fax = $Comp_Info->{'Fax'};
}	 



//Recupero datos smtp
$sql = "SELECT * FROM CONF_SMTP WHERE ID='1'";

$smtp= $this->model->Query($sql);

foreach ($smtp as $smtp_val) {
  $smtp_val= json_decode($smtp_val);

  $hostname       = $smtp_val->{'HOSTNAME'};
  $emailport      = $smtp_val->{'PORT'};
  $emailusername  = $smtp_val->{'USERNAME'};
  $emailpass      = $smtp_val->{'PASSWORD'};

}

unset($_POST);

?>	
<div class="page col-xs-12">

<div  class="col-xs-12">
<!-- contenido -->
<h2>Configuracion del sistema</h2>
<div class="title col-xs-12"></div>


<DIV CLASS='SEPARADOR col-lg-12'></DIV>
<DIV class='col-lg-12'>
 <ul class="nav nav-tabs" id="myTab">
    <li class="active" ><a data-toggle="tab" href="#menu1">Compañia</a></li>
    <li><a data-toggle="tab" href="#menu2">Logo</a></li>
 <!--    <li><a data-toggle="tab" href="#menu3">Facturacion</a></li> -->
    <li><a data-toggle="tab" href="#menu4">SMTP</a></li>
   <!--  <li><a data-toggle="tab" href="#menu5">Modulos</a></li> -->
    <!-- <li><a data-toggle="tab" href="#menu6">Ctas. GL</a></li> -->
  </ul>

  <div class="tab-content">

     <!--CONFIGURACION GENERAL DE COMPAÑIA -->
    <div id="menu1" class="tab-pane fade in active">
      <fieldset >
		 <legend>Datos de generales</legend> 

		<form action="" role="form" class="form-horizontal" enctype="multipart/form-data" method="post" >

		<input type="hidden" id="comp" name="comp" value="1" />

		<div class="form-group">
		<label class="col-sm-2 control-label" for="field-1">Compañia</label>

		<div class="col-sm-10">
			<input type="text" class="form-control" id="company" name="company"  value="<?php echo $name; ?>"  /> 
		</div>
		</div>


		<div class="form-group">
		<label class="col-sm-2 control-label" >Dirección</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" id="address" name="address" value="<?php echo $address; ?>" />
		</div>
		</div>


		<div class="form-group">
		<label class="col-sm-2 control-label" >Email</label>
		<div class="col-sm-10">
		<input type="email" class="form-control" id="email_contact" name="email_contact" value="<?php echo $email; ?>" />
			<p class="help-block">Indique el email de contacto de su compañia.</p>
			</div>
		</div>


		<div class="form-group">
			<label class="col-sm-3 control-label" >Teléfono</label>
		<div class="input-group col-sm-2">
				<span class="input-group-addon">
					<i class="fa fa-phone"></i>
				</span>

		<input type="text" class="form-control" id="tel1" name="tel1" value="<?php echo $tel; ?>" />

		</div>


		<label class="col-sm-3 control-label" >Fax</label>
			<div class="input-group col-sm-2">
			<span class="input-group-addon">
				<i class="fa fa-phone"></i>
			</span>
		<input type="text" class="form-control" id="tel2" name="tel2" value="<?php echo $fax; ?>" />

			</div>
		</div>
										
		<div class="form-group col-lg-2">
		<input type="submit"  value="Guardar" class="btn btn-primary  btn-block text-lef"/>
		</div>
		</form>
										
		 </fieldset>
    </div>
     <!--CONFIGURACION DE LOGO-->
    <div id="menu2" class="tab-pane fade">
	 <fieldset>
	 	<legend>Logo</legend>

	<form action="" role="form" class="form-horizontal" enctype="multipart/form-data" method="POST">

	<div class="form-group">
	<input type="hidden" id="logo" name="logo" value="1" />
		

	    <img class="confLogo col-sm-2" src="img/logo.jpg" width="150" heigh="100" />

		<div class="col-sm-8">
			<input type="file" class="form-control" id="imageFile" name="imageFile">
				<p class="help-block">Formato de imagen permitido es jpg, tamaño maximo de 300k y dimensiones 150x150px</p>
		</div>
	</div>
	<div class="form-group col-lg-2">
	<input type="submit"  value="Cargar imagen" class="btn btn-primary  btn-block text-lef" name="submit" />
	</div>
	 </form>

	 </fieldset>
    </div>


     <!--CONFIGURACION DE CORREO SMTP-->
    <div id="menu4" class="tab-pane fade">
      
		<fieldset>
		  <legend>Configuracion SMTP</legend>
		<form action="" role="form" class="form-horizontal" enctype="multipart/form-data" method="POST">
		<input type="hidden" id="smtp" name="smtp" value="1" />

		<div class="form-group">
		<label class="col-sm-2 control-label" >Host</label>
		<div class="col-sm-8">
		<input class="form-control" id="emailhost" name="emailhost" type="text" maxlength="64" value="<?php echo $hostname; ?>" required>
		</div>
		</div>


		<div class="form-group">
		<label class="col-sm-2 control-label" >Puerto</label>
		<div class="col-sm-8">
		<input  class="form-control" id="emailport" name="emailport" type="text" value="<?php echo $emailport; ?>" required>
			</div>
		</div>

		<div class="form-group">
		<label class="col-sm-2 control-label" >Usuario</label>
		<div class="col-sm-8">
		<input class="form-control" id="emailusername" name="emailusername" type="text" maxlength="64" value="<?php echo $emailusername; ?>" required>
			</div>
		</div>

		<div class="form-group">
		<label class="col-sm-2 control-label" >Contraseña</label>
		<div class="col-sm-8">
		<input class="form-control" name="emailpass" id="emailpass" type="password" maxlength="64" value="<?php echo $emailpass; ?>" required>
			</div>
		</div>

		<div style='float:right;' class="col-sm-2">
		<input type="submit"  value="Guardar" class="btn btn-primary  btn-block text-lef"  />
		</div>

		</form>


		<script type="text/javascript">
		function send_test(){

		URL       = document.getElementById('URL').value;
		var email = document.getElementById('emailtest').value;
		var datos= "url=bridge_query/send_test_mail/"+email;
		var link= +"index.php";

		$('#notificacion').html('<P>Enviando...</P>');

		  $.ajax({
		      type: "GET",
		      url: link,
		      data: datos,
		      success: function(res){
		      
		       $('#notificacion').html(res);
		       // alert(res);
		        }
		   });

		}
		</script>


		<div class="separador col-lg-12"></div>

		<div class="form-group">
		<div class="col-sm-3">
		<input type='button' onclick="javascript: send_test(); return false;" class="btn btn-default  btn-block text-lef" id="testmail" name="testmail"  value='Enviar email de prueba' />
		</div>
		<div class="col-sm-7">
		<input class="form-control" name="emailtest" id="emailtest" type="email"  value="">
			</div>
		<div class="col-sm-12" id='notificacion'></div>
		</div>

		</fieldset>
    </div>


</div>


</div>
</div>
