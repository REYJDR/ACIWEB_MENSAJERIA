<?php
 error_reporting(0);



 		if (isset($_POST['pass_1'])){


			$pass=$_POST['pass_1'];
	

			$pass = md5($pass);

			$columns  = array( 'pass' => $pass,
							   'Recover_key' => '0');

			$clause = "email = '".$mail."';";

			$this->model->update('SAX_USER',$columns,$clause);



?>
    <script>
    	alert('Contraseña modificada exitosamente');
		self.location= "<?php echo URL; ?>index.php?url=login/index";

    </script>

<?php } ?>



<div class="page col-lg-12">

<div  class="col-lg-12">
<!-- contenido -->
<h2>Recuperacion de Contraseña</h2>
<div class="title col-lg-12"></div>
<div class="separador col-lg-12"></div>


	
  <!--crear usuario-->

	<fieldset >
	<form action="" enctype="multipart/form-data" method="post" role="form" class="form-horizontal">
	<div class="separador col-lg-12"></div>

		<div class="separador col-lg-12"></div>
	<div class="col-lg-12" > 
		<label class="col-lg-2 control-label" >Nueva Contraseña</label>						
		<div class="col-lg-4">								
		
		<input type="password" class="form-control" id="pass_1" name="pass_1" required/>
		
		</div>
	</div>
	<div class="separador col-lg-12"></div>
	<div class="col-lg-12" > 
		<label class="col-lg-2 control-label" >Repetir Contraseña</label>					
		<div class="col-lg-4">								
		
		<input type="password" class="form-control" id="pass_2" name="pass_2" required/>
		
		</div>
	</div>

	<div class="separador col-lg-12"></div>
	
 
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