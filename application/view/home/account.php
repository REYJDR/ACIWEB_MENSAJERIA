 <?php
 error_reporting(0);

if (isset($_POST['mail'])){

$mail=$_POST['mail'];
$name=$_POST['name'];
$lastname=$_POST['lastname'];
$pass=$_POST['pass_1'];
$role=$_POST['role'];
//$cliente_name = $_POST['cliente_id'];

$mail_verify = $this->model->Query_value('SAX_USER','email',"where email='".$mail."' and onoff='1'");

//echo $mail_verify;

if (!$mail_verify){

$pass = md5($pass);

$columns  = array( 'name' => $name,
	               'lastname' => $lastname,
	               'pass' => $pass,
	               'email' => $mail,
	               'role'=> $role,
	               'ORI_DIR1' => $_POST['ORG_CITY'],
	               'ORI_DIR2' => $_POST['ORG_DEPA'],
	               'ORI_DIR3' => $_POST['ORG_MUNI'],
	               'ORI_DIR4' => $_POST['ORG_CP'],
	               'ORI_DIR5' => $_POST['ORG_REF'],
	               'ORI_TELF' => $_POST['ORG_TEL'],
	                 );

$this->model->insert('SAX_USER',$columns);
/*
$this->model->Query("INSERT INTO SAX_USER (name,lastname,email,pass,role) values ('".$name."','".$lastname."','".$mail."','".$pass."','".$role."')");*/

?>
    <script>
      alert('El registro se ha agredago con exito'); 
    </script>

<?php }else{ ?>
    <script>
      alert('Error: El email de usuario ya existe');;
    </script>
<?php } } ?>

<script>
//TABLE OF ACCOUNT
  jQuery(document).ready(function($)
  {
   
   var table = $("#user").dataTable({
      aLengthMenu: [
        [5,10, 25,50,-1], [5,10, 25, 50,"All"]
      ]
    });

table.yadcf([
{column_number : 0 ,  
 column_data_type: "html",
  html_data_type: "text" },
{column_number : 1},
{column_number : 2},
{column_number : 3}

]); 

});
//TABLE OF ACCOUNT
</script>

<div class="page col-lg-12">

<div  class="col-lg-12">
<!-- contenido -->
<h2>Cuentas de usuarios</h2>
<div class="title col-lg-12"></div>


<div class="col-lg-12">
	

  <div class="col-lg-6"> 
	<fieldset >
	<legend>Agregar Usuarios</legend>
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
		<div class="col-lg-6">								
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
		<div class="col-lg-3">
	     <select class="form-control" id="role" name="role">
	     <?php if($this->model->active_user_role=='admin'){ ?>
			<option value="admin" >Administrador de Sistema</option>
			
		 <?php } ?>
		 <?php if($this->model->active_user_role=='admin' or $this->model->active_user_role=='user_admin'){ ?>
			<option value="user_admin" >Usuario Admin.</option>
			<option value="repar" >Repartidor</option>
			<option value="user"  >Cliente</option>
         <?php } ?>
		  </select>
	     </div>
	</div>


 <div class="title col-lg-12"></div>
<!-- INI FROM-->
		<div class="col-lg-12">
		<fieldset>
		<legend>Informacion de ubicacion</legend>
            <div class="col-lg-12">
			<table width="100%" border="0" >
				<tr><td width="50%" ><label style="display:inline">Ciudad </label></td><td width="50%" ><input style="width: 100%;"  type="text" id="ORG_CITY" name="ORG_CITY" value="" /></td></tr>
				<tr><td width="50%" ><label style="display:inline">Departamento </label></td width="50%" ><td><input style="width: 100%;" class="input-control"  type="text" id="ORG_DEPA" name="ORG_DEPA" value="" /></td></tr>
				<tr><td width="50%" ><label style="display:inline">Municipio</label></td><td width="50%" ><input style="width: 100%;" class="input-control"  type="text"  id="ORG_MUNI" name="ORG_MUNI" value=""/></td></tr>
				<tr><td width="50%" ><label style="display:inline">C.P</label></td><td width="50%" ><input style="width: 100%;" class="input-control"  type="text"  id="ORG_CP" name="ORG_CP" value="" /></td></tr>
			    <tr><td width="50%" ><label style="display:inline">Referencias</label></td><td width="50%" ><input style="width: 100%;" class="input-control"  type="text" id="ORG_REF" name="ORG_REF" value=""/></td></tr>
			    <tr><td width="50%" ><label style="display:inline">Telefono</label></td><td width="50%" ><input style="width: 100%;" class="input-control"  type="text"  id="ORG_TEL" name="ORG_TEL" value=""/></td></tr>
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

  <!--lista de usuario-->

  <div class="col-lg-6"> 

    <fieldset>
    <legend>Usuarios del sistema</legend>
	<table id="user" width='100%' class="table table-striped table-bordered" cellspacing="0"  >
	<thead>
	<tr>
	<th width="15%">Nombre</th>
	<th width="15%">Correo</th>
	<th width="15%">Role</th>
	<th width="10%">Login</th>
	</tr>
	</thead>
	<tbody>
	<?php

	$user = $this->model->Query('SELECT * FROM SAX_USER WHERE onoff="1" ORDER BY "name" desc;');
    
		foreach ($user as $datos) {

	     $user = json_decode($datos);
          
         $boton_editar = strtoupper($user->{'name'}).' '.strtoupper($user->{'lastname'});
         $style= '';
	
	     switch ($user->{'role'}) {
	     	case 'admin':
	     		$user_role= 'Administrador de sistema';
	     		$style='style="background-color:#F7BE81; "';

	     		if($this->model->active_user_role == 'admin'){

		           $boton_editar = '<a  href="'.URL.'index.php?url=home/edit_account/'.$user->{'id'}.'" >'.strtoupper($user->{'name'}).' '.strtoupper($user->{'lastname'}).'</a>';

		         }
	     		break;

	     	case 'user_admin':
	     		$user_role = 'Administrador';
	     		$style='style="background-color:#04B4AE; "';

	     		if($this->model->active_user_role == 'admin'){

		           $boton_editar = '<a  href="'.URL.'index.php?url=home/edit_account/'.$user->{'id'}.'" >'.strtoupper($user->{'name'}).' '.strtoupper($user->{'lastname'}).'</a>';

		         }

	     		break;

	     	case 'user':

	     		$user_role = 'Cliente';
	     		$boton_editar = '<a  href="'.URL.'index.php?url=home/edit_account/'.$user->{'id'}.'" >'.strtoupper($user->{'name'}).' '.strtoupper($user->{'lastname'}).'</a>';
	     		$style='style="background-color:#045FB4; color:white;"';
	     		break;

	     

	     }
         


	     $id="'".$user->{'id'}."'";
	     

	     echo '<tr>
			<th class="text-left" >'.$boton_editar.'</th>
			<th class="text-left">'.strtoupper($user->{'email'}).'</th>
			<th class="text-left" '.$style.' >'.strtoupper($user_role).'</th>
			<th class="numb">'.$user->{'last_login'}.'</th>
			</tr>';
	 // data-toggle="modal" data-target="#myModal";

	     }
	?>
	 </tbody>
	 </table>
	 </fieldset>

  </div>

 </div>




 </div>
</div>
