<?php
error_reporting(0);

//GET ACCOUNT INFO
if($id){

$sql = 'SELECT * FROM SAX_USER  where SAX_USER.onoff="1" and SAX_USER.id="'.$id.'";';
 
$res = $this->model->Query($sql);
 
foreach ($res as $value) {

	$value = json_decode($value);

	$id = $value->{'id'};
	$name = $value->{'name'};
	$lastname = $value->{'lastname'};
	$email = $value->{'email'};
	$pass = $value->{'pass'};
	$role= $value->{'role'};
	$INF_OC= $value->{'notif_oc'};
	$INF_FC= $value->{'notif_fc'};
	$INF_PRICE= $value->{'mod_price'};
	                 

	if($INF_OC==1){//notificaciones

	$notif_oc = 'checked';

	}else{

	$notif_oc = '';	
	}

	if($INF_FC==1){//notificaciones

	$notif_fc = 'checked';

	}else{

	$notif_fc = '';	
	}

	if($INF_PRICE==1){//notificaciones

	$price_mod = 'checked';

	}else{

	$price_mod = '';	
	}

}

if($this->model->active_user_role!='admin'){ $notif_oc .= ' disabled'; $notif_fc .= ' disabled'; $price_mod .= ' disabled'; }

//UPDATE INFORMATION
if($_POST['flag2']=='1'){

		if($_POST['oc_chk']==true){//notificaciones

		$not_oc_value = '1';

		}else{

		$not_oc_value = '0';	
		}

		if($_POST['fc_chk']==true){//notificaciones

		$not_fc_value = '1';

		}else{

		$not_fc_value = '0';	
		}
		
		if($_POST['pri_chk']==true){//permite al usuario modificar precios

		$mod_price_value = '1';

		}else{

		$mod_price_value = '0';	
		}

$pass_ck = $this->model->Query_value('SAX_USER','pass','where SAX_USER.onoff="1" and SAX_USER.id="'.$id.'"');


	if($pass_ck==$_POST['pass_22']){

	$pass==$_POST['pass_22'];

	}else{

	$pass = md5($_POST['pass_22']);
		
	}

$columns  = array( 'name' => $_POST['name2'],
	               'lastname' => $_POST['lastname2'],
	               'pass' => $pass,
	               'role'=> $_POST['priv'],
	               'notif_oc' => $not_oc_value,
	               'notif_fc' => $not_fc_value,
	               'mod_price' => $mod_price_value);

$clause = 'id="'.$_POST['user_2'].'"';

$this->model->update('SAX_USER',$columns,$clause);



echo '<script>alert("Se ha actualizado los datos con exito");

self.location="'.URL.'index.php?url=home/edit_account/'.$id.'";


</script>';
}



}

?>

<div class="col-lg-3"></div>
<div class="page col-lg-6">

<div  class="col-lg-12">
<!-- contenido -->
    <!-- Modal content-->
    <div >
      <div >
       
        <h3 >Cuenta de cliente</h3>

<div class="separador col-lg-12"></div>
<fieldset>
<form action="" enctype="multipart/form-data" method="post" role="form" class="form-horizontal">

<input type="hidden" id="user_2" name="user_2" value="<?php echo $id; ?>" />

<!-- <div class="col-lg-12" > 
	<label class="col-lg-2 control-label" for="tagsinput-1">Compa&ntildeia/Cliente</label>
	 <div class="col-lg-6" > 
	<input type="text" class="form-control" id="cli" name="cli"  readonly/>
	</div>
</div> -->
<div class="separador col-lg-12"></div>

<div class="col-lg-6" > 
	<label class="col-lg-4 control-label" >Nombre</label>							
	<div class="col-lg-8">								
	
	<input type="text" class="form-control" id="name2" name="name2"  value="<?php echo $name; ?>" required/>
	
	</div>
</div>

<div class="col-lg-6" > 
	<label class="col-lg-4 control-label" >Apellido</label>						
	<div class="col-lg-8">								
	
	<input type="text" class="form-control" id="lastname2" name="lastname2"  value="<?php echo $lastname; ?>" required/>
	
	</div>
</div>
<div class="separador col-lg-12"></div>

<div class="col-lg-12" > 
	<label class="col-lg-2 control-label" for="tagsinput-1"> Email</label>								
	<div class="col-lg-8">								
	<div class="input-group">
	<input type="text" class="form-control" name="email2" id="email2"  value="<?php echo $email; ?>"readonly/>		
	<span class="input-group-addon"><i class= "fa fa-envelope-o"></i></span>
	</div>
	</div>
</div>
<div class="separador col-lg-12"></div>
<div class="col-lg-12" > 
	<label class="col-lg-2 control-label" >Password</label>						
	<div class="col-lg-4">								
	
	<input type="password" class="form-control" id="pass_12" name="pass_12"  value="<?php echo $pass; ?>" required/>
	
	</div>
</div>
<div class="separador col-lg-12"></div>
<div class="col-lg-12" > 
	<label class="col-lg-2 control-label" >Repetir Password</label>					
	<div class="col-lg-4">								
	
	<input type="password" class="form-control" id="pass_22" name="pass_22" value="<?php echo $pass; ?>" required/>
	
	</div>
</div>
<div class="separador col-lg-12"></div>
<div class="col-lg-12" > 
	<label class="col-lg-2 control-label" for="tagsinput-2">Privilegio</label>					
	<div class="col-lg-3">
     <input type="text" class="form-control" id="priv" name="priv" value="<?php echo $role; ?>" readonly/>
	
     </div>
</div>	
<input type="hidden"  name="flag2" value="1" />

<?php 
if($this->model->active_user_role='user_admin' || $this->model->active_user_role='admin'){

   $readonly = 'readonly';

 }else{

  $readonly = '';

 } ?>

<div class="title col-lg-12"></div>
<div class="col-lg-6">
<fieldset>
<legend><h4>Notificaciones</h4></legend>
<input type="CHECKBOX" name="oc_chk" <?php echo $notif_oc.' '.$readonly; ?> />&nbsp<label>Solicitudes de envio</label><br>

</fieldset>
</div>

<div class="col-lg-6">
<fieldset>
<legend><h4>Opciones</h4></legend>
<input type="CHECKBOX" name="pri_chk" <?php echo $price_mod.' '.$readonly; ?> />&nbsp<label>Modificacion de Precios</label>
</fieldset>
</div>



 

<div class="title col-lg-12"></div>
<div class="col-lg-6"></div>

<div class="col-lg-4">
<button   class="btn btn-primary  btn-block text-left" type="submit" >Actualizar</button>
</div>		

</form>
<div class="col-lg-2">
<button  onclick="erase_user('<?php echo URL; ?>');" class="btn btn-danger btn-sm btn-icon icon-left"  >Eliminar</button>
</div>	
</fieldset>
<div class="separador col-lg-12"></div>


      <!-- -->
     </div>
   </div>
 </div>
</div>

