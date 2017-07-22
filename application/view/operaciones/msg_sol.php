
<script type="text/javascript">
// ********************************************************
// * Aciones cuando la pagina ya esta cargada
// ********************************************************

$(window).load(function(){


    var table = $("#table_sol_tb").DataTable({
      

      bSort:      false,
      responsive: false,
      searching: false,
      paging:    false,
      info:      false,
      collapsed: false

  });

  $('#ERROR').hide();

});

// Variables globales
URL = document.getElementById('URL').value;
link = URL+"index.php";
cantLineas = '';



init(0); //llamo a construir tabla  


function init(lines)

{

cantLineas = lines; 
var listitem = '';
var i = 1;



$('#table_req').html(''); //limpio la tabla 


while(i <= cantLineas){


			var line_table_req = '<tr><td  width="5%" >'+i+'</td>'+
		    '<td width="5%" contenteditable id="PROD'+i+'" ></td>'+
			'<td width="25%" contenteditable id="DEST'+i+'"></td>'+
			'<td width="25%" contenteditable id="DIRC'+i+'"></td>'+
			'<td width="5%" contenteditable id="NAME'+i+'" ></td>'+
			'<td width="5%" contenteditable id="TELF'+i+'" ></td>'+
			'<td width="30%" contenteditable id="NOTA'+i+'" ></td>'+
			'</tr>' ;

			 i++
			 $('#table_req').append(line_table_req); //limpio la tabla 
			}

       
      



}
/////////////////////////////////////////////////////////////////////////////////////////////////
</script>

<?php

if($this->model->active_user_role=='user'){


$sql = 'SELECT * FROM SAX_USER  where SAX_USER.onoff="1" and SAX_USER.id="'.$this->model->active_user_id.'";';
 
$res = $this->model->Query($sql);
 
foreach ($res as $value) {

	$value = json_decode($value);
	$name = $value->{'name'};
	$lastname = $value->{'lastname'};
	$NAME = $value->{'name'}.' '. $value->{'lastname'};
	$EMAIL = $value->{'email'};
	$DIR1=   $value->{'ORI_DIR1'};
	$DIR2=   $value->{'ORI_DIR2'};
	$DIR3=   $value->{'ORI_DIR3'};
	$DIR4=   $value->{'ORI_DIR4'};
	$DIR5=   $value->{'ORI_DIR5'};
	$TELF=   $value->{'ORI_TELF'};
}



}






?>

<!--/////////////////////////////////////////////////////////////////////////////////////////////////-->

<div class="page col-lg-12">

<!--INI DIV ERRO-->
<div id="ERROR" class="alert alert-danger"></div>
<!--INI DIV ERROR-->

<div  class="col-lg-12">
<!-- contenido -->
<h2>Solicitud</h2>
<div class="title col-lg-12"></div>

<div class="col-lg-12">

 <!-- INI VENTANA -->

<input type="hidden" id='URL' value="<?php ECHO URL; ?>" />


<div class="col-lg-12"">
        <div class="separador col-lg-12"></div>

		<!-- INI FECHA -->
		<div class="col-lg-3">
		<fieldset>
			<table width="100%" border="0" >			   
			  <tr><td width="50%" ><h4>Fecha de envio </h4></td><td width="100%" ><input style="width: 100%;" class="numb" type="date" id='date' name="date"  value="<?php echo date("Y-m-d"); ?>" /></td></tr>				
			</table>
		</fieldset>
		</div>
       <!-- FIN FECHA -->

       <div class="separador col-lg-12"></div>

		<?php if($this->model->active_user_role!='user' ){ ?>
		  
		        <!-- INI  CLIENTE -->
				<div class="col-lg-3">
				<fieldset>
						<table width="100%" border="0" >			   
						  <tr><td width="50%" ><h4>Cliente</h4></td><td width="100%" >


							<select id="customer" name="customer" class="select col-lg-12 select2-offscreen" onchange="sendval(this.value);" required="" tabindex="-1" title="">

						       <option selected="" disabled=""></option>
								
								<?php  
								$CUST = $this->model-> Get_User_list(); 

								foreach ($CUST as $datos) {
																					
								$CUST_INF = json_decode($datos);
								echo '<option value="'.$CUST_INF->{'id'}.'" >'.$CUST_INF->{'name'}.' '.$CUST_INF->{'lastname'}."</option>";

								}
								?>

							</SELECT>



						  </td></tr>				
						</table>
                

				</fieldset>
				</div>
		       <!-- FIN  CLIENTE -->		 



		<?php } ?>


       

        <div class="separador col-lg-12"></div>

        <!-- INI FROM-->
		<div class="col-lg-6">
		<fieldset>
		<legend>Origen</legend>
            <div class="col-lg-12">
			<table width="100%" border="0" >
               <tr><td width="50%" ><h4>Direccion </h4></td><td width="50%" > </td></tr>
               <tr><td width="50%" ><label style="display:inline">Ciudad </label></td><td width="50%" ><input style="width: 100%;"  type="text" id="ORG_CITY" name="ORG_CITY" value="<?php echo $DIR1; ?>" /></td></tr>
				<tr><td width="50%" ><label style="display:inline">Departamento </label></td width="50%" ><td><input style="width: 100%;" class="input-control"  type="text" id="ORG_DEPA" name="ORG_DEPA" value="<?php echo $DIR2; ?>" /></td></tr>
				<tr><td width="50%" ><label style="display:inline">Municipio</label></td><td width="50%" ><input style="width: 100%;" class="input-control"  type="text"  id="ORG_MUNI" name="ORG_MUNI" value="<?php echo $DIR3; ?>"/></td></tr>
				<tr><td width="50%" ><label style="display:inline">C.P</label></td><td width="50%" ><input style="width: 100%;" class="input-control"  type="text"  id="ORG_CP" name="ORG_CP" value="<?php echo $DIR4; ?>" /></td></tr>
			    <tr><td width="50%" ><label style="display:inline">Referencias</label></td><td width="50%" ><input style="width: 100%;" class="input-control"  type="text" id="ORG_REF" name="ORG_REF" value="<?php echo $DIR5; ?>"/></td></tr>
			    <tr><td width="50%" ><label style="display:inline">Nombre </label></td><td width="50%" ><input style="width: 100%;" class="input-control"  type="text"  id="ORG_NAME" name="ORG_NAME"  value="<?php echo $NAME; ?>" /></td></tr>
			    <tr><td width="50%" ><label style="display:inline">Telefono</label></td><td width="50%" ><input style="width: 100%;" class="input-control"  type="text"  id="ORG_TEL" name="ORG_TEL" value="<?php echo $TELF; ?>"/></td></tr>
			    <tr><td width="50%" ><label style="display:inline">Email</label></td><td width="50%" ><input style="width: 100%;" class="input-control"  type="text"  id="ORG_EMAIL" name="ORG_EMAIL" value="<?php echo $EMAIL; ?>"/></td></tr>
			</table>
            </div>
		</fieldset>
		</div>
        <!-- END  FROM-->

		<!-- DETALLES -->
	   <div class="col-lg-6">
         <fieldset>
       	   <legend>Observaciones</legend>
         	<div class="comment-text-area col-lg-12">
         		<textarea class="textinput" rows="5" cols="70" id="NOTA" name="NOTA">  </textarea>
        		
         	</div>
         </fieldset>
	   </div> 
	   <!--END DETALLES -->

	   <div class="separador col-lg-12"></div>		

	  <!--INI LINEAS -->
		<div class="col-lg-3">
		<fieldset>
			<table width="100%" border="0" >			   
			  <tr><td width="50%" ><label style="display:inline">No. de Piezas</label></td><td width="100%" ><input style="width: 100%;" class="numb" id="NOREG" onfocusout="javascript: init(this.value);" type="number"  /></td></tr>				
			</table>
		</fieldset>
		</div>	
       <!--END  LINEAS -->
</div>


<div class="separador col-lg-12"></div>	


<!--INI TABLA DE ITEMS A ENVIAR-->
<div class=" col-lg-12"> 
<fieldset class="table_req" >
<table id="table_sol_tb" class="display table table-striped table-condensed table-bordered " cellspacing="0">
	<thead>
		<tr >
			<th width="5%" >No.</th>
			<th width="5%" class="text-center">Producto</th>
 			<th width="25%" class="text-center">Destinatario (Empresa)</th>
			<th width="25%" class="text-center">Direccion de envio</th>
			<th width="5%" class="text-center">Nombre receptor</th>
			<th width="5%" class="text-center">Telefono</th>
			<th width="30%" class="text-center">Nota</th>
     	</tr>
	</thead>

	<tbody id="table_req" >	

	</tbody>
</table>
</fieldset>

<div  class="separador col-lg-12" ></div>
</div>
<!--END TABLA DE ITEMS A ENVIAR-->

	  <!--INI BOTON ENVIO -->
	    <div class="col-lg-9"></div>
		<div class="col-lg-3">
		<input   onclick="send_sol();" type="buttom" class="btn btn-primary  btn-sm btn-icon icon-right" value="ENVIAR"  />				
		</div>	
       <!--END  BOTON ENVIO  -->
<div  class="separador col-lg-12" ></div>

</div>
</div>
</div>


<script type="text/javascript">

//VALIABLES GLOBALES
CHK_VALIDATION = false;
vendorID = '';
falta = 0;
LineArray = [];
FaltaArray = [];
SOLC_NO = '';
//VALIABLES GLOBALES


function sendval(ID){



URL = document.getElementById('URL').value;

var datos= "url=bridge_query/get_Cust_info/"+ID;
var link= URL+"index.php";

  $.ajax({
      type: "GET",
      url: link,
      data: datos,
      success: function(res){

        res = JSON.parse(res);

		document.getElementById('ORG_CITY').value= res.ORI_DIR1;
		document.getElementById('ORG_DEPA').value= res.ORI_DIR2;
		document.getElementById('ORG_MUNI').value= res.ORI_DIR3;
		document.getElementById('ORG_CP').value= res.ORI_DIR4;
		document.getElementById('ORG_REF').value= res.ORI_DIR5;
		document.getElementById('ORG_NAME').value= res.name+' '+res.lastname ;
		document.getElementById('ORG_TEL').value= res.ORI_TELF;
		document.getElementById('ORG_EMAIL').value= res.email;

        }
   });

							 
}


function validacion(){


   
	CITY = document.getElementById('ORG_CITY').value;

	if (CITY == ''){

	 MSG_ERROR('Se debe indicar la ciudad de origen',0);
     
	  
	 CHK_VALIDATION = true;
	}

	   
	DEPA = document.getElementById('ORG_DEPA').value;

	if (DEPA == ''){

	 MSG_ERROR('Se debe indicar el departamento de origen',0);
	 CHK_VALIDATION = true;
	}

	
	MUNI = document.getElementById('ORG_MUNI').value;

	if (MUNI == ''){

	 MSG_ERROR('Se debe indicar el municipio de origen',0);
	 CHK_VALIDATION = true;
	}

	  
    NAME = document.getElementById('ORG_NAME').value;

	if (NAME == ''){

	 MSG_ERROR('Se debe indicar el nombre del remitente',0);
	 CHK_VALIDATION = true;
	}


    
	TELF = document.getElementById('ORG_TEL').value;

	if (TELF== ''){

	 MSG_ERROR('Se debe indicar el telefono del remitente',0);
	 CHK_VALIDATION = true;
	}

	DATE = document.getElementById('date').value;

	if (DATE == ''){

	  MSG_ERROR('Se debe indicar la fecha de envio',0);
	  CHK_VALIDATION = true;
	}

}




function send_sol(){

$('#ERROR').hide();

/////////////////////////////
//variables internas
var flag = '';
var count= 0;
var arrLen = '';
////////////////////////////

//////////////////////////////
validacion();
 
if(CHK_VALIDATION == true){ CHK_VALIDATION = false;  return;  }
/////////////////////////////


//AGRUPO LAS LINEAS DE ITEMS EN ARRAY
flag = set_items();



if(flag==1){  //SI HAY ITEMS EN LA LISTA

///////////////////////////////////////////
//SE PROCESA EL REGISTRO EN BD

var r = confirm('Desea enviar la solicitud ahora?');
    
		if (r == true) { 

		 link = URL+"index.php";
         NOTA = document.getElementById('NOTA').value;
         CITY = document.getElementById('ORG_CITY').value;
	     DEPA = document.getElementById('ORG_DEPA').value;
		 MUNI = document.getElementById('ORG_MUNI').value;
		 CP   = document.getElementById('ORG_CP').value;
		 NAME = document.getElementById('ORG_NAME').value;
		 REFR = document.getElementById('ORG_REF').value;
		 TELF = document.getElementById('ORG_TEL').value;
		 EMAIL = document.getElementById('ORG_EMAIL').value;
		 NOREG = document.getElementById('NOREG').value;
		 DATE  = document.getElementById('date').value;
         DATE = formatDate(DATE);
         
         DIR_ORI = CITY+' , '+MUNI+' , '+DEPA+' , '+CP+' , '+REFR;

        //REGITRO DE CABECERA
        function set_header(){

        	
		//INI REGISTRO DE CABECERA
		var datos= "url=bridge_query/set_sol_header/"+DIR_ORI+"/"+NAME+'/'+TELF+'/'+EMAIL+'/'+DATE+"/"+NOTA+'/'+NOREG; //LINK DEL METODO EN BRIDGE_QUERY
							       
		return  $.ajax({
					type: "GET",
					url: link,
					data: datos,
					success: function(res){

					console.log(res);

					SOLC_NO = res;
																
				}
			});
	
	   }//FIN REGISTRO DE CABECERA

		
	 $.when(set_header()).done(function(SOLC_NO){ //ESPERA QUE TERMINE LA INSERCION DE CABECERA

     console.log(SOLC_NO);

     // REGISTROS DE ITEMS 
		    $.ajax({
				 type: "GET",
				 url:  link,
				 data:  {url: 'bridge_query/set_sol_items/'+SOLC_NO , Data : JSON.stringify(LineArray)}, 
				 success: function(res){
        		           		   
	             console.log(res);

					if(res==1){//TERMINA EL LLAMADO AL METODO set_req_items SI ESTE DEVUELV UN '1', indica que ya no hay items en el array que procesar.
									
						send_mail(link,SOLC_NO);
				
					}

				   }
				});  
	 //FIN REGISTROS DE ITEMS     
 
     });


  }

///////////////////////////////////////////
}

if(flag==0){ //SI NO HAY ITEMS EN LA LISTA

	MSG_ERROR('No se han indicado registros para envio'); 
    return;
}

if(flag==2){ //MANEJO DE ERRORES POR FAMPO FALTANTES EN LOS ITEMS

MSG_ERROR_RELEASE(); //LIMPIO DIV DE ERRORES

FaltaArray.forEach(ListFaltantes);


	function ListFaltantes(item,index){

	  column = FIND_COLUMN_NAME(index);
      
      MSG_ERROR('No se indico valor en el Item: '+item+" / Campo :" +column, 1); 
      

	}

FaltaArray.length = ''; //LIMPIO ARRAY DE ERRORES

}


}


function send_mail(link,SOLC_NO){

    //ENVIO POR MAIL 
	var datos= "url=ges_mensajeria/msg_mailing/"+SOLC_NO; //LINK A LA PAGINA DE MAILING
    

	$.ajax({
		type: "GET",
		url: link,
		data: datos,
		success: function(res){

									      
			if(res==0){

			 alert('NO SE HA PODIDO ENVIAR LA NOTIFICACION POR CORREO.');
			 
			}

			 msg(link,SOLC_NO);

		}
	}); 
	//FIN ENVIO POR MAIL 

}		 			

//FUNCION PARA SOLICITAR IMPRESION DEL REPORTE
function msg(link,SOLC_NO){


    alert("SE HA GENERADO LA SOLICITUD No: "+SOLC_NO);

	var R = confirm('Desea imprimir comprobante de la solicitud?');

	if(R==true){

         count = 1;
         LineArray.length='';
         window.open(link+'?url=ges_mensajeria/msg_print/'+SOLC_NO,'_self');
                 
    }else{

		count = 1;
	    LineArray.length='';
		location.reload();

	}



}




//FUNCION PARA GUARDAR ITEMS EN ARRAY 
function set_items(){

LineArray.length=''; //limpio el array

var flag = ''; 
var theTbl = document.getElementById('table_sol_tb'); //objeto de la tabla que contiene los datos de items
var line = '';
cantLineas = Number(cantLineas);
var i=1;
//BLUCLE PARA LEER LINEA POR LINEA LA TABLA 

while (i <= cantLineas){
//for(var i=1; i > cantLineas; i++) {

	cell = '';
	//i=i+1;
	for(var j=0;j<theTbl.rows[i].cells.length; j++) //BLUCLE PARA LEER CELDA POR CELDA DE CADA LINEA
        {

		            switch (j){
                       default: 
                             val= theTbl.rows[i].cells[j].innerHTML;
                             cell += '@'+val;//agrego el registo de las demas columnas
                              
                                 //SI LA CELDA NO CONTIENE VALOR 
	                             if(val==''){
                                   
                                  FaltaArray[j] = i ;
	                             }
                             break;
                            }
    	           
	     }   //FIN BLUCLE PARA LEER CELDA POR CELDA DE CADA LINEA
   	     if(cell!=''){
     	    //INSERTA valor de CELL en el arreglo 
		    LineArray[i]=cell; 

   	     }

		
i++;       
}//FIN BLUCLE PARA LEER LINEA POR LINEA DE LA TABLA 


//SETEA RETURN DE LA FUNCION, FLAG 1 Ó 0, SI ES 1 LA TABLA ESTA LLENA SI ES 0 LA TABLA ESTA VACIA.
if(FaltaArray.length == 0){

    if(LineArray.length >= 1){ 
		flag = 1; 
     }else{  
	    flag = 0; 
     }

}else{
    
    LineArray.length = '';
    cell = '';
	flag = 2; //Alguna linea no tiene descripcion

}


return flag;
}
//FIN ITEMS


function FIND_COLUMN_NAME(item){

switch (item){

  case 1: val ='Producto'; break;
  case 2: val ='Destinatario(Empresa)'; break;
  case 3: val ='Direccion de Envio'; break;
  case 4: val ='Nombre Receptor'; break;
  case 5: val ='Telefono' ; break;
   
}

return val;

}

</script>