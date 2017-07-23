
<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.min.js"></script>
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.min.css">


<script type="text/javascript">
$(window).load(function(){ 

  set_brief_report();
  
  var text = $('#code').text()+$('#code2').text()+$('#code3').text();
 
  eval(text);
  prettyPrint();

  });


</script>


<div class="separador col-lg-12"></div>

<div class="col-lg-3"> 

<fieldset >
<legend><img class='icon' src="img/Search.png" />Seguimiento</legend>

<input class="col-lg-10 numb" id="buscar" name="buscar"/>&nbsp; 
     <a title="Buscar ID" href="javascript:void(0);" onclick="javascript: 
            var id = document.getElementById('buscar').value;
            if (id != '') {
            self.location = document.getElementById('URL').value+'index.php?url=ges_mensajeria/msg_entrega/'+id ;}
            else{

              alert('Debe indicar el numero de guia');
            }

            "><i class="fa fa-search"></i></a>
 
</fieldset>


<div class="title col-lg-12"></div>


<fieldset>
 <legend>Filtrar consulta de solicitudes</legend>
<table width="100%"  class="table"  >
  
  <tr><th style="text-align: left" >Registros entre</th>
      <td>
       <input class='numb' type="date" id="date1" name="name1"  value="" /> -
       <input class='numb' type="date" id="date2" name="name2"  value=""/>
      </td>
  </tr>

  <tr><th style="text-align: left">Sortear</th>
       <td><select   id="sort" required>
           
           <option  value="ASC">Ascendente (A-Z)</option>
           <option  value="DESC" selected>Descendente (Z-A)</option>
         
           </select>
       </td>
  </tr>
 
  <tr>
    <th style="text-align: left">Limitar</th>
    <td>
       <input class='numb ' type="number" min="1" max="10000" id="limit" value="100" required/>
       <p class="help-block">Maximo de 10000 registros</p> 
    </td>
  </tr>
</table>

<!-- 

 

     <div class='col-lg-4'>
     <label class='col-md-12' >Registros entre</label>
     <input class='numb' type="date" id="date1" name="name1"  value="" /> -
     <input class='numb' type="date" id="date2" name="name2"  value=""/>
     </div>

    
    <div class='col-lg-4'>
    <label class='col-md-12' >Sortear</label>
     <select   id="sort" required>
           
           <option  value="ASC">Ascendente (A-Z)</option>
           <option  value="DESC" selected>Descendente (Z-A)</option>
         
    </select>
    </div>


    
    <div class='col-lg-4'>
     <label class='col-lg-12' >Limitar</label>
     <input class='numb ' type="number" min="1" max="10000" id="limit" value="100" required/>
     <p class="help-block">Maximo de 10000 registros</p>
    </div>
 -->
  <div class="col-xs-6">
  <br>
   <input type="submit" onclick="Filtrar();" class="btn btn-primary  btn-sm  btn-icon icon-right" value="Consultar" />
  </div> 

  
</fieldset>

</div>


<div class="col-lg-9"> 
<fieldset>
  <legend><img class='icon' src="img/System Activity Monitor.png" />Panel </legend>
    
    <?php  if($this->model->active_user_role == 'admin' or 
              $this->model->active_user_role == 'user_admin' ){ ?> 

     <div class="graphcont  col-lg-6">
      <fieldset>
      <legend>Registro de Solicitudes</legend>
        
        <div id="graph"></div>

      </fieldset>
       
      </div>

      <div class="graphcont  col-lg-6">
      <fieldset>
      <legend>Usuarios activos</legend>
        
        <div id="graph2"></div>

      </fieldset>
             
      </div>

      <div class="graphcont  col-lg-6">
      <fieldset>
      <legend>Sol. Asignadas</legend>
        
        <div id="graph3"></div>

      </fieldset>
             
      </div>

    <?php } ?>
 
<div class="separador col-lg-12"></div>


<div class="col-lg-12">
  <fieldset>
  <legend>Registro de Solicitudes</legend> 
     
     <div id='BriefRep' ></div>

  </fieldset>
</div>


</fieldset>

</div>
<?php
if($this->model->active_user_role == 'admin' or 
   $this->model->active_user_role == 'user_admin' ){

$SOL  =  $this->model->get_sol_to_graph();

$USERS = $this->model->get_user_to_graph();

$ASIGN = $this->model->get_asign_to_graph();

$FINALI= $this->model->get_finali_to_graph();

echo "<pre  id='code' class='prettyprint linenums'>
       // Use Morris.Bar
        Morris.Bar({
          element: 'graph',
          axes: true,
          data: [ ".$SOL."],
          xkey: 'x',
          ykeys: ['y'],
          labels: ['Solicitudes'],
          barColors: function (row, series, type) {
            if(row.label == 'Cancelado') return '#D8D8D8';
            else if(row.label == 'Finalizado') return '#BCF5A9';
            else if(row.label == 'Transito')  return '#F2F5A9';
            else if(row.label == 'Proceso')   return '#F7BE81';
            else if(row.label == 'Pendiente') return '#F5A9A9';
            }
      }).on('click', function(i, row){ 

       table.fnFilter(row.x, 5);

           

      });
    </pre>

    <pre  id='code2' class='prettyprint linenums'>
       // Use Morris.Bar
        Morris.Bar({
          element: 'graph2',
          axes: true,
          data: [ ".$USERS."],
          xkey: 'x',
          ykeys: ['y'],
          labels: ['Usuarios'],
          barColors: function (row, series, type) {
            if(row.label == 'Clientes') return '#045FB4';
            else if(row.label == 'Usuarios del sistema') return '#04B4AE';
            }
      });
    </pre>

   <pre  id='code3' class='prettyprint linenums'>
       // Use Morris.Bar
        Morris.Bar({
          element: 'graph3',
          axes: true,
          data: [ ".$ASIGN."],
          xkey: 'x',
          ykeys: ['y'],
          labels: ['Sol. en transito asignadas']
      }).on('click', function(i, row){ 

       table.fnFilter(row.x, 3);
           

      });
    </pre>

       <pre  id='code4' class='prettyprint linenums'>
       // Use Morris.Bar
        Morris.Bar({
          element: 'graph4',
          axes: true,
          data: [ ".$FINALI."],
          xkey: 'x',
          ykeys: ['y'],
          labels: ['Sol. asignadas y finalizadas']
      }).on('click', function(i, row){ 

       table.fnFilter(row.x, 3);
           

      });
    </pre>



    ";
  }
?>

</body>
<script type="text/javascript">


  function set_brief_report(){

  URL = document.getElementById('URL').value;

  var datos= "url=bridge_query/get_report/MgsSol/DESC/100//";

  console.log(datos);

  var link= URL+"index.php";

    $.ajax({
        type: "GET",
        url: link,
        data: datos,
        success: function(res){

         $('#BriefRep').html(res);

         
          }
     });
  }

function Filtrar(){


  var limit = $('#limit').val();
  var sort =  $('#sort').val();
  var type =  'MgsSol';
  var date1 = $('#date1').val();
  var date2 = $('#date2').val();



  URL = document.getElementById('URL').value;

  var datos= "url=bridge_query/get_report/"+type+"/"+sort+"/"+limit+"/"+date1+"/"+date2;   
  var link = URL+"index.php";


$('#BriefRep').html('<P>CARGANDO ...</P>');

  $.ajax({
      type: "GET",
      url: link,
      data: datos,
      success: function(res){
      
       $('#BriefRep').html(res);

        }
   });



}

</script>