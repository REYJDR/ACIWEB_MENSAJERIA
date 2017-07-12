<script type="text/javascript">
$(window).load(function(){
$('[data-submenu]').submenupicker();
});
</script> 

<?php
//RECUPERO INFO DE DETALLES DE FACTURACION
$SQL = 'SELECT * FROM MOD_MENU_CONF';

$MOD_MENU = $this->model->Query($SQL);

foreach ($MOD_MENU as $value) {

$value = json_decode($value);

if($value->{'mod_sales'}=='1'){ $mod_sales_CK = 'checked'; }else{ $mod_sales_CK = '';  }
if($value->{'mod_fact'}=='1'){ $mod_fact_CK  = 'checked'; }else{ $mod_fact_CK = '';  }
if($value->{'mod_invt'}=='1'){ $mod_invt_CK = 'checked'; }else{ $mod_invt_CK  = '';  }
if($value->{'mod_rept'}=='1'){ $mod_rept_CK = 'checked'; }else{ $mod_rept_CK = '';  }
if($value->{'mod_stock'}=='1'){ $mod_stoc_CK = 'checked'; }else{ $mod_stoc_CK = '';  }

}
?>
<div  class='menu_header col-xs-12'>

<nav id='menu' class="navbar navbar-default">
  <div class="navbar-header">
    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
      <span class="sr-only"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>

   <a  class="navbar-brand" onClick="history.go(-1); return true;" ><img title="Atras" class='icon' src="img/Arrow Left.png" /></a>
   <a  class="navbar-brand" onClick="history.go(+1); return true;" ><img title="Adelante" class='icon' src="img/Arrow Right.png" /></a>
   <a  class="navbar-brand" onClick="location.reload();" ><img title="Actualizar" class='icon' src="img/Button White Load.png" /></a>
   <a  class="navbar-brand" href="<?PHP ECHO URL; ?>index.php?url=home/index"><img title="Dashboard"  class='icon' src="img/Dashboard.png" /></a>
  </div>


<div class="collapse navbar-collapse">

<ul class="nav navbar-nav">

<?php if($this->model->active_user_role=='user' ){ ?>
      <li class="dropdown">
              <a tabindex="0"  data-toggle="dropdown" data-submenu="" aria-expanded="false">
                <img class='icon'  src="img/service.png" />Servicios<span class="caret"></span>
              </a>

      <ul class="dropdown-menu">
        <li><a tabindex="0" href="<?PHP ECHO URL; ?>index.php?url=ges_mensajeria/msg_sol"><img class='icon' src="img/mailbox.png" />Solicitud de envio</a></li> 
      </ul>
      </li>
<?php }else{ ?>


      <li><a tabindex="0" href="<?PHP ECHO URL; ?>index.php?url=ges_mensajeria/msg_sol"><img class='icon' src="img/mailbox.png" />Solicitud de envio</a></li> 


 <?php  } ?>

 <?php if($this->model->active_user_role!='user' ){ ?>

  <li><a tabindex="0" href="<?PHP ECHO URL; ?>index.php?url=ges_mensajeria/msg_entrega/0"><img class='icon' src="img/history.png" />Registro de entregas</a></li> 
  
 <?php  } ?>


  <!--<li><a tabindex="0" href="<?PHP ECHO URL; ?>index.php?url=ges_mensajeria/msg_rep"><img class='icon' src="img/history.png" />Historico</a></li> -->


</ul>






<!--left side-->
<ul class="nav navbar-nav navbar-right">
   <li class="dropdown">
        <a tabindex="0" data-toggle="dropdown" data-submenu="" aria-expanded="false">
        <img class='icon' src="img/options.png" />Opciones<span class="caret"></span>
        </a>

<ul class="dropdown-menu">
  
<li><a tabindex="0" title="Ir al perfil de usuario"  href="<?PHP ECHO URL; ?>index.php?url=home/edit_account/<?php echo $this->model->active_user_id; ?>"><img class='icon' src="img/Contact.png" /><?php echo $this->model->active_user_name.' '.$this->model->active_user_lastname; ?>&nbsp;&nbsp;</a></li>

<?php if($this->model->active_user_role=='admin' or $this->model->active_user_role=='user_admin'){ ?>
<li><a tabindex="0" title="Administrar Usuarios" href="<?PHP ECHO URL; ?>index.php?url=home/accounts" ><img class='icon' src="img/Users.png" />Usuarios</a></li>
<?php } ?>
<?php if($this->model->active_user_role=='admin'){ ?>
<li><a tabindex="0" title="Configuracion"  href="<?PHP ECHO URL; ?>index.php?url=home/config_sys" ><img  class='icon' src="img/Cog.png" />Configuracion</a></li>
<?php } ?>
         
<li class="divider"></li>

<li><a  title="Salir del sistema" href="<?PHP ECHO URL; ?>index.php?url=login/login_out/" ><img  class='icon' src="img/Shut.png" />Salir</a></li>

</ul>
      </li>
    </ul>
  </div>
</nav>

</div>


