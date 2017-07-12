<!DOCTYPE html>
<html lang="en">
<head>

<!-- Latest compiled and minified CSS -->
<script src="<?php echo URL; ?>js/jquery-2.2.1.min.js" ></script>


<!-- Optional theme--> 
<link rel="stylesheet" href="<?php echo URL; ?>css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo URL; ?>css/buttons.dataTables.min.css" >
<link rel="stylesheet" href="<?php echo URL; ?>css/selectDatatables.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo URL; ?>css/bootstrap-theme.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo URL; ?>css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo URL; ?>css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo URL; ?>dist/css/bootstrap-submenu.min.css">
<link rel="stylesheet" href="<?php echo URL; ?>css/rowReorder.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo URL; ?>css/responsive.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo URL; ?>css/style.css" rel="stylesheet">

<!-- SELECT2 --> 
<link rel="stylesheet" href="<?php echo URL; ?>js/select2/select2.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo URL; ?>js/select2/select2-bootstrap.css" rel="stylesheet">


<!-- GRAPHS --> 
<!-- <link rel="stylesheet" href="<?php echo URL; ?>morris/morris.css" rel="stylesheet"> -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">



<!-- signing -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>

<!--  CUSTOM JS  --> 
<script src="<?php echo URL; ?>js/sax_script.js" ></script>


<!--  BOOTSTRAP JS  --> 
<script src="<?php echo URL; ?>js/bootstrap.min.js" ></script>
<script src="<?php echo URL; ?>dist/js/bootstrap-submenu.min.js" defer></script>


<!--  DATATABLES  JS --> 

<script  src="<?php echo URL; ?>js/jquery.dataTables.min.js" ></script>
<script  src="<?php echo URL; ?>js/selectDatatables.js" ></script>
<script  src="<?php echo URL; ?>js/dataTables.buttons.min.js" ></script>
<script  src="<?php echo URL; ?>js/buttons.flash.min.js" ></script>
<script  src="<?php echo URL; ?>js/jszip.min.js" ></script>
<script  src="<?php echo URL; ?>js/pdfmake.min.js" ></script>
<script  src="<?php echo URL; ?>js/vfs_fonts.js" ></script>
<script  src="<?php echo URL; ?>js/buttons.html5.min.js" ></script>
<script  src="<?php echo URL; ?>js/buttons.print.min.js" ></script>
<script  src="<?php echo URL; ?>js/buttons.colVis.min.js" ></script> 
<script  src="<?php echo URL; ?>js/dataTables.colVis.js" ></script> 
<script  src="<?php echo URL; ?>js/jquery.dataTables.columnFilter.js" ></script>
<script  src="<?php echo URL; ?>js/jquery.dataTables.yadcf.js" ></script>
<script  src="<?php echo URL; ?>js/dataTables.rowReorder.min.js" ></script>
<script  src="<?php echo URL; ?>js/dataTables.responsive.min.js" ></script>


<!-- SELECT2  JS --> 
<script src="<?php echo URL; ?>js/select2/select2.min.js"></script>

<!--  GRAPHS  JS --> 
<!-- <script src="<?php echo URL; ?>morris/morris.js"></script> -->



<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head> 
<body>
<div class="loader"></div>
<div id="allDocument">
<?php header('Content-Type: text/html; charset=utf-8'); ?>


<input type="hidden" id="active_user_id" value="<?php echo $this->model->active_user_id; ?>" />
<input type="hidden" id='URL' value="<?php ECHO URL; ?>" />


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

      <h1>
        Firma de entrega
      </h1>
      <div class="wrapper">
        <img class="img_signature" src="#" bg-color="white" width=400 height=200 />
        <canvas id="signature-pad" class="signature-pad" width=400 height=200></canvas>
      </div>
        <button id="clear">Limpiar</button>
      
      </div>
      <!--fin Modal  body-->
      <div class="modal-footer">
        <button  id="save" type="button" onclick="javascript:delivery_item();" data-dismiss="modal" class="btn btn-primary" >Aceptar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>


</div>