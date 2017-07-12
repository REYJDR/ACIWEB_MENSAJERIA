<script type="text/javascript">
// ********************************************************
// * Aciones cuando la pagina ya esta cargada
// ********************************************************
$(window).load(function(){

$('#ERROR').hide();

MSG_ID = document.getElementById('reqidhide').value;

console.log(MSG_ID);

  if(MSG_ID!='0'){

  document.getElementById('buscar').value = MSG_ID  ;

  get_msg_info(MSG_ID);

  }

});

//VARIABLES GLOBALES
URL = document.getElementById('URL').value;
link= URL+"index.php";


function set_count_lines(){

var Req_NO = document.getElementById('buscar').value;

var datos= "url=bridge_query/get_sol_item_lines/"+Req_NO;//LINK DEL METODO EN BRIDGE_QUERY
        

    $.ajax({
                type: "GET",
                url: link,
                data: datos,
                success: function(res){
 
                res = res.trim();
                console.log(res);
                
                 document.getElementById('count_lines').value = res;

                }
              }); 


return true;

}



</script>

<div class="page col-lg-12">

<canvas id="canvas" style="display:none;"></canvas>
<input id="count_lines" type="hidden" value="" />

<!--INI DIV ERRO-->
<div id="ERROR" class="alert alert-danger"></div>
<!--INI DIV ERROR-->

<input type="hidden" name="id_sol" id="id_sol"/>
<input type="hidden" name="id_item" id="id_item" />


<div  class="col-lg-12">
<!-- contenido -->
<h2>Registro de entregas</h2>
<div class="title col-lg-12"></div>
<div class="col-lg-12">

		 <div class="col-lg-4" >
         <fieldset>
	         <p><strong>No. de Guia</strong></p>
	          <input class="col-lg-10" id="buscar" name="buscar"/>&nbsp; 
	          <a title="Buscar ID" href="javascript:void(0)" onclick="javascript:
            var id = document.getElementById('buscar').value;
            if (id != '') {
            self.location = document.getElementById('URL').value+'index.php?url=ges_mensajeria/msg_entrega/'+id ;}
            else{

              alert('Debe indicar el numero de guia');
            }
"><i class="fa fa-search"></i></a>

         </fieldset>
         </div>

         <div class="title col-lg-12"></div>
         <div id="info" class="col-lg-12"></div>


</div>
</div>
</div>