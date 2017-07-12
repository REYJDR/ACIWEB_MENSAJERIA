
 <!DOCTYPE html>
<html lang="en">
<head>

<!-- Latest compiled and minified CSS -->
<script src="js/jquery-2.2.1.min.js" ></script>


<!-- Optional theme--> 
<link rel="stylesheet" href="css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/buttons.dataTables.min.css" >
<link rel="stylesheet" href="css/selectDatatables.css" rel="stylesheet">
<link rel="stylesheet" href="css/bootstrap-theme.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" href="dist/css/bootstrap-submenu.min.css">
<link rel="stylesheet" href="css/rowReorder.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/responsive.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/style.css" rel="stylesheet">

<!-- SELECT2 --> 
<link rel="stylesheet" href="js/select2/select2.css" rel="stylesheet">
<link rel="stylesheet" href="js/select2/select2-bootstrap.css" rel="stylesheet">


<!-- GRAPHS --> 
<!-- <link rel="stylesheet" href="morris/morris.css" rel="stylesheet"> -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">



<!--  CUSTOM JS  --> 
<script src="js/sax_script.js" ></script>


<!--  BOOTSTRAP JS  --> 
<script src="js/bootstrap.min.js" ></script>
<script src="dist/js/bootstrap-submenu.min.js" defer></script>


<!--  DATATABLES  JS --> 

<script  src="js/jquery.dataTables.min.js" ></script>
<script  src="js/selectDatatables.js" ></script>
<script  src="js/dataTables.buttons.min.js" ></script>
<script  src="js/buttons.flash.min.js" ></script>
<script  src="js/jszip.min.js" ></script>
<script  src="js/pdfmake.min.js" ></script>
<script  src="js/vfs_fonts.js" ></script>
<script  src="js/buttons.html5.min.js" ></script>
<script  src="js/buttons.print.min.js" ></script>
<script  src="js/buttons.colVis.min.js" ></script> 
<script  src="js/dataTables.colVis.js" ></script> 
<script  src="js/jquery.dataTables.columnFilter.js" ></script>
<script  src="js/jquery.dataTables.yadcf.js" ></script>
<script  src="js/dataTables.rowReorder.min.js" ></script>
<script  src="js/dataTables.responsive.min.js" ></script>


<!-- SELECT2  JS --> 
<script src="js/select2/select2.min.js"></script>

<!--  GRAPHS  JS --> 
<!-- <script src="morris/morris.js"></script> -->

<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head> 
<body>
<div class="loader"></div>
<div id="allDocument">
<?php header('Content-Type: text/html; charset=utf-8'); ?>


<!--/////////////////////////////////////////////////////////////////////////-->

<!-- FIN DE CARGA DE CLASES-->


 <?php
 error_reporting(0);

        //CARGA DE CLASES PHP NECESARIAS PARA INSERTAR EN DB DESDE PUBLIC

define('ROOT', dirname(__DIR__) . '/');


// set a constant that holds the project's "application" folder, like "/var/www/application".
define('APP', ROOT . 'application' . '/');

// load application config (error reporting etc.)

require APP . 'config/config.php';

// FOR DEVELOPMENT: this loads PDO-debug, a simple function that shows the SQL query (when using PDO).
// If you want to load pdoDebug via Composer, then have a look here: https://github.com/panique/pdo-debug
require APP . 'libs/helper.php';


// load application class
require APP . 'core/application.php';
require APP . 'core/controller.php';
require APP . 'controller/bridge_query.php';

// start the application
$app = new Controller();
$BQ = new bridge_query();
 
        //Insercion de usuario en DB desde public


if (isset($_POST['mail'])){

$mail=$_POST['mail'];
$name=$_POST['name'];
$lastname=$_POST['lastname'];
$pass=$_POST['pass_1'];
$role= 'user';



$mail_verify = $app->model->Query_value('SAX_USER','email',"where email='".$mail."' and onoff='1'");

echo $mail_verify;

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

$app->model->insert('SAX_USER',$columns);


$subject = utf8_decode('Te Damos la Bienvenida a Mensajeria Express!');

$message_to_send ='<html>
<head>
<meta charset="UTF-8">
<title>Correo de Activacion</title>
</head>
<body>Estimado usuario '.$name.' '.$lastname.', por favor haga click en el boton "Activar" para que cuenta sea confirmada exitosamente<br><br>

<a href="'.URL.'index.php?url=bridge_query/activate_user/'.$mail.'" type="button" id="activar" >ACTIVAR!</a>

</body>
</html>';


$BQ->send_mail($mail,$subject,$message_to_send);

?>
    <script>
      alert('El registro se ha agredago con exito'); 
      self.location= "<?php echo URL; ?>index.php?url=login/index";
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


<div class="col-lg-12">
	
<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#menu1">Agregar usuario</a></li>
</ul>

<div class="tab-content">
  <!--crear usuario-->
  <div id="menu1" class="tab-pane in fade active">
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

  
 </div>
</div><!-- aqui termina el tab -->	



 </div>
</div>
</body>
</html>