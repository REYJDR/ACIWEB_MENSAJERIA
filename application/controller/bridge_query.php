<?php

class bridge_query extends Controller

{

public function SESSION(){

  $this->model->verify_session();

}

public function erase_account($id){

$query='UPDATE SAX_USER SET onoff="0" where id="'.$id.'"';

$this->model->Query($query);

}

public function get_Cust_info($custid){

$query = 'SELECT * FROM SAX_USER WHERE id="'.$custid.'";';

$res = $this->model->Query($query);

echo $res[0];

}

public function get_sol_item_lines($id){

$this->SESSION();

$count = $this->model->Query_value('MSG_SOL_DETAIL','COUNT(*)', 'WHERE NO_SOL="'.$id.'"');

echo $count;

}

//*****************************************************************

//SECCION DE REPORTES

public function get_report($type,$sort,$limit,$date1,$date2){

$this->SESSION();

switch ($type) {

//CASE 1

case "MgsSol":

$table = '';

$clause='';

if ($this->model->active_user_role == 'user' ){

$clause .= 'WHERE MSG_SOL_HEADER.USER ="'.$this->model->active_user_id.'"';

    if($date1!=''){

       if($date2!=''){

          $clause.= ' and DATE >= "'.$date1.'%" and DATE <= "'.$date2.'%" ORDER BY NO_SOL '.$sort.' limit '.$limit.';';           

        }

       if($date2==''){ 

         $clause.= ' and DATE like "'.$date1.'%" ORDER BY NO_SOL '.$sort.' limit '.$limit.';';

       }

    }elseif ($date1 == '' && $date2 == '') {

      $clause.='ORDER BY NO_SOL '.$sort.' limit '.$limit.' ;';

    }

}elseif ($this->model->active_user_role == 'repar' ) {

$clause .= 'WHERE MSG_SOL_HEADER.REP_ASIG ="'.$this->model->active_user_id.'"';

    if($date1!=''){

       if($date2!=''){

          $clause.= ' and DATE >= "'.$date1.'%" and DATE <= "'.$date2.'%" ORDER BY NO_SOL '.$sort.' limit '.$limit.';';           

        }

       if($date2==''){ 

         $clause.= ' and DATE like "'.$date1.'%" ORDER BY NO_SOL '.$sort.' limit '.$limit.';';

       }

    }elseif ($date1 == '' && $date2 == '') {

      $clause.='ORDER BY NO_SOL '.$sort.' limit '.$limit.' ;';

    }

}else{

    if($date1!=''){

       if($date2!=''){

          //CORREGIR LOS NOMBRE DE LOS CAMPOS CON LA DB

          $clause.= ' WHERE DATE >= "'.$date1.'%" and DATE <= "'.$date2.'%" ORDER BY NO_SOL '.$sort.' limit '.$limit.';';           

        }

       if($date2==''){ 

         $clause.= ' WHERE  DATE like "'.$date1.'%" ORDER BY NO_SOL '.$sort.' limit '.$limit.';';

       }

    }elseif ($date1 == '' && $date2 == '') {

      $clause.='ORDER BY NO_SOL '.$sort.' limit '.$limit.' ;';

    }

}

 $table.= '<script type="text/javascript">

 jQuery(document).ready(function($)

  {

table = $("#MsgSol").dataTable({

      responsive: false,

      bSort: false,

      bPaginate: true,

      select:false

    });

table.yadcf(

[

{column_number : 0 ,  

 column_data_type: "html",

  html_data_type: "text" },

{column_number : 2},
{column_number : 3},

{column_number : 4}

],

{cumulative_filtering: true}); 

});

  </script>

  <table id="MsgSol" class="table table-striped table-bordered responsive" cellspacing="0">

    <thead>

      <tr>

        <th width="5%">No. Seguimiento</th>

        <th width="5%">Fecha</th>

        <th width="10%">Solicitante</th>

        <th width="10%">Rep. Asignado</th>

        <th width="40%">Observaciones</th>

        <th width="5%" >Estatus</th>  

      </tr>

    </thead>

    <tbody>';

$table.= $this->get_msg_sol_br($clause);

$table.= '</tbody></table>';

break;

}

//IMPRIME LA TABLA DEL REPORTE SELECCIONADO

echo $table; 

}

//MENSAJERIA//////////////////////////////////////////////////////////////////////////////////////////////////////////

  //INI OBTIENE CONSECUTIVO DE LA SOLICITUD

  public function get_sol_no(){

    $SOL_NO = $this->model->Query_value(

                       'MSG_SOL_HEADER',

                       'NO_SOL', 

                       'ORDER BY NO_SOL DESC LIMIT 1');

    if(!$SOL_NO) { $SOL_NO = 0;}

    $SOL_NO = number_format((int)$SOL_NO+1);

    $SOL_NO = str_pad($SOL_NO, 9 ,"0",STR_PAD_LEFT);

    if($SOL_NO< '1'){

        $SOL_NO=0;

        $SOL_NO = str_pad($SOL_NO, 9 ,"0",STR_PAD_LEFT);

    }

   return $SOL_NO; 

  }

  //FIN OBTIENE CONSECUTIVO DE LA SOLICITUD

  //INI INSERTA CABECERA DEL DOCUMENTO DE SOLICITUD

  public function set_sol_header($DIR_ORI,$NAME,$TELF,$MAIL,$DATE,$NOTA,$NOREG){

    $this->SESSION();

    $SOLC_NO = $this->get_sol_no();

    $value_to_set  = array( 

      'NO_SOL' => $SOLC_NO,   

      'DATE' => date('Y-m-d H:i:s'), 

      'ORI_DIR' =>  $DIR_ORI, 

      'ORI_NAME' => $NAME, 

      'ORI_TELF' => $TELF,

      'ORI_MAIL' => $MAIL, 

      'ORI_NOTA' => $NOTA,

      'NOPIEZA' => $NOREG,

      'USER' => $this->model->active_user_id

      );

    $res = $this->model->insert('MSG_SOL_HEADER',$value_to_set);

echo $SOLC_NO;

}

//FIN INSERTA CABECERA DEL DOCUMENTO DE SOLICITUD

//INI INSERTA DETALLE DEL DOCUMENTO DE SOLICITUD

public function set_sol_items($SOLC_NO){

$this->SESSION();

$data = json_decode($_GET['Data']);

foreach ($data as $value) {

  if($value){

       list($null,$ITEMID,$ITEMDESC,$DESTEMPRE,$DESTENVIO,$DESTNAME,$DESTTELF,$NOTA ) = explode('@', $value );

       $value_to_set  = array( 

                'NO_SOL'  => $SOLC_NO,   

                'PRODUCT' => $ITEMDESC,

                'ITEMID'  => $ITEMID,  

                'DEST_EMPRESA' => $DESTEMPRE, 

                'DEST_DIR' =>  $DESTENVIO,

                'DEST_NAME' => $DESTNAME,

                'DEST_TELF' => $DESTTELF,

                'NOTA'=> $NOTA

                );

      $res = $this->model->insert('MSG_SOL_DETAIL',$value_to_set);

      }

  }

     echo '1';

} 

//FIN INSERTA DETALLE DEL DOCUMENTO DE SOLICITUD

//INI INFO CORTA DE  SOLICITUD

public function get_msg_sol_br($clause){

$TR='';

$SQL = 'SELECT * FROM MSG_SOL_HEADER '.$clause;

$BR = $this->model->Query($SQL);

foreach ($BR as $VALUE){

$VALUE = json_decode($VALUE);

$STATUS_GEN = $this->model->get_status_gen($VALUE->{'NO_SOL'});

   switch ($STATUS_GEN) {

    case 5:

       $style = 'style="background-color:#D8D8D8;"';//GRIS

      break;

    case 4:

       $style = 'style="background-color:#BCF5A9;"';//verder

      break;

    case 3:

       $style = 'style="background-color:#F2F5A9;"';//AMARILLO

      break;

    case 2:

       $style = 'style="background-color:#F7BE81;"';//NARANJA

      break; 

    case 1:

       $style = 'style="background-color:#F5A9A9;"';//ROJO

      break; 

  }

if($VALUE->{'REP_ASIG'}!=null){

$asignado = $this->model->Get_User_Name($VALUE->{'REP_ASIG'});

}else{

$asignado = 'NO ASIGNADO';

}

     $TR .= '<tr>

              <td class="numb"><a href="'.URL.'index.php?url=ges_mensajeria/msg_entrega/'.$VALUE->{'NO_SOL'}.'">'.$VALUE->{'NO_SOL'}.'</a></td>

              <td class="numb">'.$VALUE->{'DATE'}.'</td>

              <td>'.$this->model->Get_User_Name($VALUE->{'USER'}).'</td>

              <td>'.$asignado.'</td>

              <td>'.$VALUE->{'ORI_NOTA'}.'</td>

              <td '.$style.' >'.$this->model->Query_value('MSG_SOL_GEN_STATUS','STATUS', 'WHERE ID="'.$STATUS_GEN.'"').'</td>

              </tr>';

}

return $TR;

}

//FIN INFO CORTA DE  SOLICITUD

//INI BUSCAR DETALLE DEL DOCUMENTO DE SOLICITUD

public function get_msg_info($id){

  $this->SESSION();

  if($this->model->active_user_role == 'user'){

    $USER_ID = $this->model->Query_value('MSG_SOL_HEADER','USER','WHERE MSG_SOL_HEADER.NO_SOL="'.$id.'"');

    if($USER_ID != $this->model->active_user_id){
     
      die("<script>MSG_ERROR('No se encontro el No. de solicitud', 0);</script>");

    }

  }

  if($this->model->active_user_role == 'repar'){

    $ASIGN_ID = $this->model->Query_value('MSG_SOL_HEADER','REP_ASIG','WHERE MSG_SOL_HEADER.NO_SOL="'.$id.'"');

    if($ASIGN_ID != $this->model->active_user_id){
     
      die("<script>MSG_ERROR('No se encontro el No. de solicitud, o no se encuentra asignada a su perfil', 0);</script>");

    }

  }

  //IF ExsIST

  $EXIST_ID = $this->model->Query_value('MSG_SOL_HEADER','NO_SOL','WHERE MSG_SOL_HEADER.NO_SOL="'.$id.'"');

  if($EXIST_ID!=''){

  $msg_detail = $this->model->Query('SELECT * FROM  MSG_SOL_HEADER WHERE MSG_SOL_HEADER.NO_SOL="'.$id.'";');

  echo '<script>

    var table = $("#table_info").dataTable({

        bSort: false,

        select: false,

        scrollY: "800px",

        scrollX: "100%",

        scrollCollapse: true,

        responsive: false,

        searching: false,

        paging:    false,

        info:      false });

   var table = $("#table_mov").dataTable({

        bSort: false,

        select: false,

        scrollY: "800px",

        scrollX: "100%",

        scrollCollapse: true,

        responsive: false,

        searching: false,

        paging:    false,

        info:      false });

    var table = $("#table_log").dataTable({

        bSort: false,

        select: false,

        scrollX: "100%",

        scrollY: "800px",

        scrollCollapse: true,

        responsive: false,

        searching: false,

        paging:    false,

        info:      false });

  </script>';

  echo '<br/><br/>

  <fieldset>

  <div class="col-lg-6" >

  <legend>Detalle de envio</legend>';

  foreach ($msg_detail as $datos) {

  $msg_detail  = json_decode($datos);

  $STATUS_GEN = $this->model->get_status_gen($id);

   switch ($STATUS_GEN) {

    case 5:

       $style = 'style="background-color:#D8D8D8;"';//GRIS

      break;

    case 4:

       $style = 'style="background-color:#BCF5A9;"';//verder

      break;

    case 3:

       $style = 'style="background-color:#F2F5A9;"';//AMARILLO

      break;

    case 2:

       $style = 'style="background-color:#F7BE81;"';//NARANJA

      break; 

    case 1:

       $style = 'style="background-color:#F5A9A9;"';//ROJO

      break; 

  }

  echo     '

<div class="col-12-lg border="1">
 <div class="col-12-lg"><strong>No. Guía</strong>&nbsp'.$msg_detail->{'NO_SOL'}.'</div>
 <div class="col-12-lg"><strong>Fecha</strong>&nbsp   '.$msg_detail->{'DATE'}.'</div>
 <div class="col-12-lg"><strong>Cliente</strong>&nbsp '.$msg_detail->{'ORI_NAME'}.'</div>
 <div class="col-12-lg"><strong>Telf.</strong>&nbsp   '.$msg_detail->{'ORI_TELF'}.'</div>
 <div class="col-12-lg"><strong>E-mail</strong>&nbsp  '.$msg_detail->{'ORI_MAIL'}.'</div>
 <div class="col-12-lg"><strong>Dirección de retiro</strong>&nbsp'.$msg_detail->{'ORI_DIR'}.'</div>
 <div class="col-12-lg"><strong>Nota</strong>&nbsp   '.$msg_detail->{'ORI_NOTA'}.'</div>
 <div class="col-12-lg"><strong>Estado</strong>&nbsp<span '.$style.' >'.$this->model->Query_value('MSG_SOL_GEN_STATUS','STATUS', 'WHERE ID="'.$STATUS_GEN.'"').'</span>
 </div>
</div>';


  }

  echo "</fieldset>";

  echo '<fieldset>

        <table id="table_mov" width="100%" class="table  table-striped table-bordered " cellspacing="0"  >

        <thead>

        <tr>

        <th width="5%" >No.</th>

        <th width="5%" class="text-center">Producto</th>

        <th width="25%" class="text-center">Destinatario (Empresa)</th>

        <th width="25%" class="text-center">Direccion de envio</th>

        <th width="10%" class="text-center">Datos de destinatario</th>

        <th width="25%" class="text-center">Nota</th>

        <th width="5%" class="text-center">Estado</th> ';

      if($this->model->active_user_role == 'admin' or 
         $this->model->active_user_role == 'user_admin' or 
         $this->model->active_user_role == 'repar'){

    echo '<th width="10%" class="text-center">Cambiar estado</th>

          <th width="5%" >Cancelar</th>';

        }

    echo  '</tr></thead><tbody>';

        $sql = 'SELECT * FROM  MSG_SOL_DETAIL WHERE NO_SOL="'.$id.'";';

        $msg_items = $this->model->Query($sql);

        $c = 0;

    foreach ($msg_items as $datos) {

        $msg_items  = json_decode($datos);        

        $ID_SOL= "'".$id."'";

        $ID_ITEM = "'".$msg_items->{'ITEMID'}."'";

        $status_color = $this->set_color_item_status($id,$msg_items->{'ITEMID'});

       if($msg_items->{'STATUS'} == 3){ $delivered = ' &nbsp;<i data-toggle="modal" data-target="#ViewModal" onclick= "javascript:view_modal('.$ID_SOL.','.$ID_ITEM.');" class="fa fa-pencil-square-o fa-2x"  ></i>&nbsp;'; }else{ $delivered=''; }

        echo '<tr '.$status_color.' >

              <td>'.$msg_items->{'ITEMID'}.'</td>

              <td>'.$msg_items->{'PRODUCT'}.'</td>

              <td>'.$msg_items->{'DEST_EMPRESA'}.'</td>

              <td>'.$msg_items->{'DEST_DIR'}.'</td>

              <td>'.$msg_items->{'DEST_NAME'}.', '.$msg_items->{'DEST_DIR'}.', '.$msg_items->{'DEST_TELF'}.'</td>

              <td>'.$msg_items->{'NOTA'}.'</td>

              <td>'.$delivered.'  '.$this->model->Query_value('MSG_SOL_STATUS','STATUS', 'WHERE ID="'.$msg_items->{'STATUS'}.'"').'</td>';

      if($this->model->active_user_role == 'admin' or 
         $this->model->active_user_role == 'user_admin' or 
         $this->model->active_user_role == 'repar'){
         echo '<td>';

          if($STATUS_GEN!=5){

                  if($STATUS_GEN!=1){   

                    if($msg_items->{'STATUS'}==1){//ESTATUS NO RETIRADO -> EN TRANSITO

                     echo '<a  title="SELECCIONAR COMO RETIRADO"   href="javascript:void(0)"  onclick= "javascript:PICKUP_ITEM('.$ID_SOL.','.$ID_ITEM.');"   class="btn btn-block   btn-secondary btn-icon  btn-icon-standalone btn-icon-standalone-right btn-single text-left" >

                            <img  class="icon" src="img/Button White Check.png" /> Retirado

                          </a>'; 

                      }

                    if($msg_items->{'STATUS'}==2){//ESTATUS EN TRANSITO -> ENTREGADO

                      $ID_SOL= "'".$id."'";

                      $ID_ITEM = "'".$msg_items->{'ITEMID'}."'";

                     echo '<a  title="SELECCIONAR COMO ENTREGADO"  data-toggle="modal" data-target="#DeliveryModal"   href="javascript:void(0)" onclick= "javascript:close_modal('.$ID_SOL.','.$ID_ITEM.');"   class="btn btn-block   btn-secondary btn-icon  btn-icon-standalone btn-icon-standalone-right btn-single text-left" >

                            <img  class="icon" src="img/Button White Check.png" /> Entregado 

                          </a>'; 

                      }

                  }

               }    

        echo '</td>';

        }

        
      if($this->model->active_user_role == 'admin' or 
         $this->model->active_user_role == 'user_admin' or 
         $this->model->active_user_role == 'repar'){
        echo '<td>';

          if($STATUS_GEN!=5){

                  if($STATUS_GEN!=1){

                    if($msg_items->{'STATUS'}!=4 AND $msg_items->{'STATUS'} !=3 ){//ESTATUS NO RETIRADO

                      $id_sol = "'".$id."'";

                      $id_item = "'".$msg_items->{'ITEMID'}."'";

                    echo '<a style="white-space: nowrap;" title="CANCELAR RETIRO" data-toggle="modal" data-target="#SpecModal" href="javascript:void(0)" onclick= "javascript:close_modal('.$id_sol.','.$id_item.');" class="btn btn-block   btn-secondary btn-icon  btn-icon-standalone btn-icon-standalone-right btn-single text-left">

                            <img  class="icon" src="img/Stop.png" />

                          </a>'; 

                      }

                  }

               }    

         echo '</td>';

        }

         echo '</tr>';  

        }

echo '</tbody></table></fieldset>';


echo '<div class="separador col-lg-12"></div>

<fieldset>

<div class="col-lg-12">

<div  style="float:left;"  class="col-lg-4">
  <a href="'.URL.'index.php?url=ges_mensajeria/msg_print/'.$id.'"  class="btn btn-block btn-secondary btn-icon btn-icon-standalone btn-icon-standalone-right btn-single text-left">

     <img  class="icon" src="img/Printer.png" />

    <span>Imprimir</span>

  </a>
</div>';

if($STATUS_GEN!=5){

 if($STATUS_GEN != 4){

    $check_status_byItem = $this->check_sol_item_stat($id);

    if ($check_status_byItem == 1) {

       if($this->model->active_user_role=='user_admin' or $this->model->active_user_role=='admin' ){ 

    echo '<div style="float:left;"  class="col-lg-4">
            <a title="CANCELAR SOLICITUD" data-toggle="modal" data-target="#GenModal" href="javascript:void(0)"  class="btn btn-block btn-secondary btn-icon btn-icon-standalone btn-icon-standalone-right btn-single text-left">

              <img  class="icon" src="img/Stop.png" />

              <span>CANCELAR</span>

            </a>
          </div>';

    }

    }

    if($STATUS_GEN== 1){

      if($this->model->active_user_role=='user_admin' or $this->model->active_user_role=='admin' ){ 

    echo '<div style="float:left;" class="col-lg-4">
            <a  data-toggle="modal" data-target="#AsigModal" href="javascript:void(0)" class="btn btn-block btn-secondary btn-icon btn-icon-standalone btn-icon-standalone-right btn-single text-left">

               <img  class="icon" src="img/Button Check.png" />

              <span>CONFIRMAR</span>

            </a>
          </div>';
//href="'.URL.'index.php?url=bridge_query/set_sol_started/'.$id.'" 


    }

  }

 }

}

//LOG DE PROCESO

ECHO '</div></fieldset>

<div class=" separador col-lg-12"></div>

  <div class="col-lg-12">

    <fieldset>

    <legend>Registro de cambios</legend>

        <table id="table_log" width="100%" class="table  table-striped table-bordered " cellspacing="0" >

          <thead> 

            <th>Registro</th>

            <th>Fecha</th>

            <th>Operador</th>            

          </thead>

          <tbody>';

$CREACION = $this->model->Query("SELECT DATE, USER FROM MSG_SOL_HEADER WHERE  NO_SOL='".$id."'");

        foreach ($CREACION as $value ){

        $value = json_decode($value);

        echo '<tr><td>SE HA GENERADO UNA SOLICITUD DE ENVIO</td><td class="numb" >'.$value->{'DATE'}.'</td><td>'.$this->model->Get_User_Name($value->{'USER'}).'</td></tr>';

        }

$CONFIRMACION = $this->model->Query("SELECT DATE, USER FROM MSG_SOL_STARTED WHERE  NO_SOL='".$id."'");

        foreach ($CONFIRMACION as $value ){

        $value = json_decode($value);

        echo '<tr><td>SOLICITUD CONFIRMADA. <strong> "EN PROCESO" </strong> </td><td class="numb" >'.$value->{'DATE'}.'</td><td>'.$this->model->Get_User_Name($value->{'USER'}).'</td></tr>';

        }

$DELIVERY = $this->model->Query("SELECT DATE, USER, ID_STATUS, ITEM FROM MSG_SOL_DELIVERY WHERE   NO_SOL='".$id."'

                                                                                            ORDER BY DATE ASC");

        foreach ($DELIVERY as $value ){

        $value = json_decode($value);

        echo '<tr><td>EL ITEM '.$value->{'ITEM'}.' HA CAMBIADO DE ESTADO A <strong>"'.$this->model->Query_value('MSG_SOL_STATUS','STATUS', 'WHERE ID="'.$value->{'ID_STATUS'}.'"').'" </strong>  </td><td class="numb" >'.$value->{'DATE'}.'</td><td>'.$this->model->Get_User_Name($value->{'USER'}).'</td></tr>';

        } 

if ($STATUS_GEN != 5) {

  $CANCELED = $this->model->Query("SELECT ITEMID, PRODUCT, desc_closed, LAST_CHANGE, USER_CLOSED FROM MSG_SOL_DETAIL WHERE   NO_SOL='".$id."' and STATUS = 4  ORDER BY LAST_CHANGE ASC");

        foreach ($CANCELED as $value ){

        $value = json_decode($value);

        echo '<tr><td>EL ITEM: '.$value->{'ITEMID'}.' '.$value->{'PRODUCT'}.' HA SIDO <strong>CANCELADO</strong> POR: '.$value->{'desc_closed'}.'</td><td class="numb" >'.$value->{'LAST_CHANGE'}.'</td><td>'.$this->model->Get_User_Name($value->{'USER_CLOSED'}).'</td></tr>';

        }

      }

if($STATUS_GEN==4){

  $FIN =  $this->model->Query("SELECT DATE FROM MSG_SOL_DELIVERY WHERE   NO_SOL='".$id."' ORDER BY DATE DESC limit 1");

   foreach ($FIN as $value ){

     $value = json_decode($value);

     echo '<tr><td><strong>PROCESO FINALIZADO</strong></td><td class="numb" >'.$value->{'DATE'}.'</td><td>SISTEMA ACIWEB</td></tr>';

   }

}

if($STATUS_GEN==5){

 $CERRADO = $this->model->Query_value('MSG_SOL_HEADER','LAST_CHANGE',"WHERE NO_SOL='".$id."'");

 $MOTIVO  = $this->model->Query_value('MSG_SOL_HEADER','DESC_CLOSED',"WHERE NO_SOL='".$id."'");

 $USER    = $this->model->Query_value('MSG_SOL_HEADER','USER_CLOSED',"WHERE NO_SOL='".$id."'");

 echo '<tr><td>LA SOLICITUD HA SIDO CANCELADA POR: '. $MOTIVO.'</td><td class="numb" >'.$CERRADO.'</td><td>'.$this->model->Get_User_Name( $USER ).'</td></tr>';

}

ECHO   '</tbody>

        </table></fieldset></div>';

//MODA PARA CIERRE FORZOSO DE LA SOLICITUD

$id = "'".$id."'";

$MODAL = '

<!-- Modal -->

<div id="GenModal" class="modal fade" role="dialog">

  <div class="modal-dialog modal-lg">

    <!-- Modal content-->

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal">&times;</button>

        <h3 >Motivo de cancelación</h3>

      </div>

      <div class="col-lg-12 modal-body">

      <!--ini Modal  body-->  

        <textarea class="textinput" rows="5" cols="70" id="msg_sol_reason_close" name="msg_sol_reason_close"></textarea>  

        <p class="help-block" >Indique la razón del cierre de la solicitud</p>  

      <!--fin Modal  body-->

      </div>

      <div class="modal-footer">

        <button type="button" onclick="javascript:cancel_sol('.$id.');" data-dismiss="modal" class="btn btn-primary" >Aceptar</button>

        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

      </div>

    </div>

  </div>

</div>


<!-- Modal -->

<div id="AsigModal" class="modal fade" role="dialog">

  <div class="modal-dialog modal-lg">

    <!-- Modal content-->

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal">&times;</button>

        <h3 >Asignacion de solicitud</h3>

      </div>

      <div class="col-lg-12 modal-body">

      <!--ini Modal  body-->  
         <select id="msg_sol_asing" name="msg_sol_asing">
          $this->ReparList();
         </select>
      <!--fin Modal  body-->

      </div>

      <div class="modal-footer">

        <button type="button" onclick="javascript:cancel_sol('.$id.');" data-dismiss="modal" class="btn btn-primary" >Aceptar</button>

        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

      </div>

    </div>

  </div>

</div>



<div id="SpecModal" class="modal fade" role="dialog">

  <div class="modal-dialog modal-lg">

    <!-- Modal content-->

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal">&times;</button>

        <h3 >Motivo de cancelación</h3>

      </div>

      <div class="col-lg-12 modal-body">

      <!--ini Modal  body-->  

        <textarea class="textinput" rows="5" cols="70" id="msg_item_reason_close" name="msg_item_reason_close"></textarea>  

        <p class="help-block" >Indique la razón del cierre de la solicitud</p>  

      <!--fin Modal  body-->

      </div>

      <div class="modal-footer">

        <button type="button" onclick="javascript:cancel_item();" data-dismiss="modal" class="btn btn-primary" >Aceptar</button>

        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

      </div>

    </div>

  </div>

</div>

<div id="DeliveryModal" class="modal fade" role="dialog">

  <div class="modal-dialog modal-lg">

    <!-- Modal content-->

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal">&times;</button>

        <h3 >Confirmacion de entrega</h3>

      </div>

      <div class="col-lg-12 modal-body">

      <!--ini Modal  body-->  

      <div class="col-lg-12">

        <div class="col-lg-2" >Nombre de quien recibe: </div>

        <div class="col-lg-8" ><input type="text" class="col-lg-12" id="deliName"  required/></div>

      </div>

      <div class="title col-lg-12"></div>

      <div class="col-lg-6">

        <label>Firma: </label>

        <div class="wrapper col-lg-12">

          <canvas id="signature-pad" class="signature-pad"  style="border:1px solid #000000;" ></canvas>

        </div>

        <div class="col-lg-4">

        <button id="clear" class="btn btn-success" >Limpiar</button>

        </div>

      </div>

      <div  class="col-lg-6">

            <label class="btn btn-primary">

               Subir foto&hellip;

               <form id="fotoform" >

               <input  id="imageFile" type="file" onchange="readURL(this);"  style="display: none;" />

               </form>

            </label>

            <fieldset style="display: block;"  width="100%" height="50%" >

            <img id="blah" src="#" width="100%" height="20%"  style="display: none;" alt="your image" />

            </fieldset>

        </div>

      </div>

      <!--fin Modal  body-->

      <div class="title col-lg-12"></div>

      <div class="modal-footer">

        <button  id="save" type="button"  data-dismiss="modal" class="btn btn-primary" >Aceptar</button>

        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

      </div>

    </div>

</div>

</div>

<div id="ViewModal" class="modal fade" role="dialog">

  <div class="modal-dialog modal-lg">

    <!-- Modal content-->

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal">&times;</button>

        <h3 >Confirmacion de entrega</h3>

      </div>

      <div class="col-lg-12 modal-body">

      <!--ini Modal  body-->  

      <div class="col-lg-12">

        <div class="col-lg-6" >Recibió: </div>

        <div class="col-lg-6" ><input type="text" class="col-lg-12" id="RcvName"  value="" readonly/></div>

      </div>

      <div class="title col-lg-12"></div>

      <div class="col-lg-6">

        <label>Firma: </label>

            <fieldset style="display: block;"  width="100%" height="50%" >

            <img id="ViewSing" src="#" width="100%" height="20%"   />

            </fieldset>

      </div>

      <div  class="col-lg-6">

            <fieldset style="display: block;"  width="100%" height="50%" >

            <img id="ViewImage" src="#" width="100%" height="20%"   />

            </fieldset>

        </div>

      </div>

      <!--fin Modal  body-->

      <div class="title col-lg-12"></div>

      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

      </div>

    </div>

</div>

';

ECHO $MODAL;

      }else{

        echo '<div id="ERROR" class="alert alert-danger">EL No. <strong>'.$id.'</strong> DE GUÍA NO EXISTE</div>';

      }

}

  //FIN BUSCAR  DETALLE DEL DOCUMENTO DE SOLICITUD

//FIN MENSAJERIA//////////////////////////////////////////////////////////////////////////////////////////////////////

public function check_sol_item_stat($id){

  $NO_ITEMS = $this->model->Query_value('MSG_SOL_DETAIL' ,'COUNT(*)','WHERE NO_SOL="'.$id.'";');

  $NO_ITEMS_STAT = $this->model->Query_value('MSG_SOL_DETAIL' ,'COUNT(*)','WHERE NO_SOL="'.$id.'" AND STATUS="1";');

    if($NO_ITEMS == $NO_ITEMS_STAT ){

        return  1;

    }else{

         return 0;

    }

}

///////////////////////////////////////////////////////////////////////////////////

public function set_color_item_status($id,$item){

 $status = $this->model->Query_value('MSG_SOL_DETAIL','STATUS','WHERE NO_SOL="'.$id.'" 

                                                                      AND ITEMID="'.$item.'";');

  switch ($status) {

    case 4:

       $style = 'style="background-color:#D8D8D8 ;"';//GRIS

      break;

    case 3:

       $style = 'style="background-color:#BCF5A9 ;"';//verder

      break;

    case 2:

       $style = 'style="background-color:#F7BE81;"';//NARANJA

      break; 

    case 1:

       $style = 'style="background-color:#F5A9A9;"';//ROJO

      break; 

  }

  return $style;

}

///////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////

//LISTA DE ESTATUS PARA ITEMS

public function get_status_list_item($actual){

  $list_status ='';

  $sql = 'SELECT * FROM MSG_SOL_STATUS WHERE ID > "'.$actual.'"';

  $item_list_status = $this->model->Query($sql);

  foreach ($item_list_status  as $value) {

    $value = json_decode($value);

    $list_status .= '<option value="'.$value->{'ID'}.'">'.$value->{'STATUS'}.'</option>';

    }

return $list_status;

}

///////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////

//CAMBIA STATUS DE ITEMS POR SOLICITUD

public function change_item_st($NO_SOL,$ITEMID,$ST){

$this->SESSION();

if($_GET['RevName']!=''){

$value_del  = array( 'ITEM' => $ITEMID ,

                     'NO_SOL' => $NO_SOL,

                     'USER' => $this->model->active_user_id,

                     'USER_RECV'  => $_REQUEST['RevName'] );

$this->model->insert('MSG_SOL_DELI_REG',$value_del);

}

usleep(500);

$value_del  = array( 'ID_STATUS' => $ST ,

                     'ITEM' => $ITEMID ,

                     'NO_SOL' => $NO_SOL,

                     'USER' => $this->model->active_user_id );

$this->model->insert('MSG_SOL_DELIVERY',$value_del);

usleep(500);

$clause = ' NO_SOL ="'.$NO_SOL.'" AND ITEMID="'.$ITEMID.'"';

$value  = array( 'STATUS' => $ST );

$this->model->update('MSG_SOL_DETAIL',$value,$clause);

ECHO "1";

/*echo "<script>

       window.history.go(-1);

      </script>";

*/

}

////////////////////////////////////////////////////////////////////////////////////

//SET CONFIRMACION DE ENVIO PARA INICIAR EL PROCESO

public function set_sol_started($id){

$this->SESSION();

if($_SESSION){

$id_user = $this->model->active_user_id;

$VALID   = $this->model->Query_value('MSG_SOL_STARTED','NO_SOL','WHERE  NO_SOL ="'.$id.'"');

  if(!$VALID){

       $value_to_set  = array( 

        'NO_SOL' => $id,   

        'USER' => $this->model->active_user_id

        );

      $res = $this->model->insert('MSG_SOL_STARTED',$value_to_set);

    echo '<script>  alert("Se confirma correctamente  la solicitud No. '.$id.'");  

                   self.location="'.URL.'index.php?url=ges_mensajeria/msg_entrega/'.$id.'"; 

         </script>';

  }else{

    echo '<script>  alert("La solicitud No. '.$id.' ya ha iniciado la cotnfirmada");  

                    self.location="'.URL.'index.php?url=ges_mensajeria/msg_entrega/'.$id.'"; 

          </script>';

  }

}

}

////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////

//PROCESO DE ENVIO DE EMAIL (TEST)

public function send_test_mail($emailtest){

require 'PHP_mailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

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

$mail->Subject = utf8_decode('Prueba de configurarión SMTP (ACI-WEB)');

$message_to_send ='<html>

<head>

<meta charset="UTF-8">

<title>Prueba de configurarión SMTP (ACI-WEB)</title>

</head>

<body>Este es un correo de prueba del sistema ACI-WEB de APCON Consulting, 

para certificar el funcionamiento de su configuracion SMTP.</body>

</html>';

$mail->Body = $message_to_send;

$mail->AddAddress($emailtest);

if(!$mail->send()) {

   $alert .= 'El correo no puede ser enviado.';

   $alert .= 'Error: ' . $mail->ErrorInfo;

} else {

  $alert = 'El correo de verificacion ha sido enviado';

}

echo $alert;

}

public function activate_user($mail){

$query = "SELECT onoff FROM SAX_USER WHERE email = '".$mail."';";

$res = $this->model->Query($query);

foreach ($res as $val) {

  $val = json_decode($val);

    if ($val->{'onoff'} == 0) {

        $update = "UPDATE SAX_USER SET onoff = 1 WHERE email = '".$mail."';";

        $this->model->Query($update);

        echo '<script>  alert("El usuario '.$mail.' ha sido activado exitosamente");  

                 self.location="'.URL.'index.php?url=login/index"; 

       </script>';

    }

    else{

  echo '<script>  alert("El usuario '.$mail.' ya ha sido activado anteriormente");  

                 self.location="'.URL.'index.php?url=login/index"; 

        </script>';

    }

}

}

public function cancel_item($id_sol,$id_item,$cancel_desc){

$this->SESSION();

$values  = array( 'STATUS' => 4 ,

                     'closed' => 1 ,

                     'desc_closed' => $cancel_desc,

                     'USER_CLOSED' => $this->model->active_user_id,

                     );

$clause = "NO_SOL = '".$id_sol."' and ITEMID = '".$id_item."';";

$this->model->update('MSG_SOL_DETAIL',$values,$clause);

}

public function cancel_sol($id_sol,$cancel_desc){

$this->SESSION();

  $cancel_head = "UPDATE MSG_SOL_HEADER SET ST_CLOSED = 1, USER_CLOSED = ".$this->model->active_user_id.", DESC_CLOSED = '".$cancel_desc."' WHERE NO_SOL = '".$id_sol."';";

      $this->model->Query($cancel_head);

  $cancel_detail = "UPDATE MSG_SOL_DETAIL SET STATUS = 4, closed = 1, desc_closed = '".$cancel_desc."', USER_CLOSED = ".$this->model->active_user_id." WHERE NO_SOL = '".$id_sol."';";

      $this->model->Query($cancel_detail);

}

///////////////////////////////////////////////////////////////////////

//INFO DE ENTRAGA

public function view_singed_info($id,$item){

$sql = 'SELECT * FROM MSG_SOL_DELI_REG WHERE NO_SOL="'.$id.'" AND ITEM="'.$item.'"';

$RES = $this->model->Query($sql);

echo $RES[0];

}


public function ReparList(){

$list = '';

$repar = $this->model->Query('SELECT id, name, lastname FROM SAX_USER WHERE onoff="1" and role="repar";');

foreach ($repar as $value) {

  $value = json_decode($value);

    $list .='<option value="'.$value->{'id'}.'" >'.$value->{'name'}.' '.$value->{'lastname'}.'</option>';
  }
  
return  $list;

}


//DEBAJO DE ESTA LINEA TERMINA LA LLAVE QUE CIERRA LA CLASE -----NO BORRAR-------!

}

?>