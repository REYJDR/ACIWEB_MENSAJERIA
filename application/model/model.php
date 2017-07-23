<?php

error_reporting(1); 


class Model
{
    /**
     * @param object $db A PDO database connection
     */

     public  $active_user_id = null;
     public  $active_user_name  = null;
     public  $active_user_lastname  = null;
     public  $active_user_email  = null;
     public  $active_user_role  = null;
     public  $active_user_almacen  = null;
     public  $id_compania = null;




    function __construct($db,$dbname)
    {
        try {
           
           $this->db = $db;
           $this->dbname = $dbname;

        } catch (mysqli_connect_errno $e) {
            exit('No se pude realizar la conexion a la base de datos');
        }


    }
////////////////////////////////////////////////////////////////////////////////////////
/**
* test connetion BD
*/ 
    public function TestConexion(){

            $Mysql =  $this->db; 


            if (mysqli_connect_errno()) {
             
                $status ="Error: (" . mysqli_connect_errno() . ") " . mysqli_connect_error();

            }else{  

                $status= "Conectado a Mysql";

            }

           
            return $status;

            }

    
////////////////////////////////////////////////////////////////////////////////////////
/**
* test connetion BD
*/ 

      public function ConexionSage(){

        $connected= $this->Query_value('CompanySession','isConnected','order by LAST_CHANGE DESC limit 1');

        

            if ($connected==0) {
             
                $status ="<script>alert('El sistema se encuentra desconectado de SageConnect, Por favor verifique la conexion del conector');</script><img width='15px' src='img/Stop.png' /> No conectado a Sage";

            }else{  

                $status ="<img width='15px' src='img/Check.png' /> Conectado a ".$this->Query_value('CompanySession','CompanyNameSage50','order by LAST_CHANGE DESC  limit 1');



            }

           
            return $status;

            }



////////////////////////////////////////////////////////////////////////////////////////
    /**
     * CONNECTION DB
     */
    public function connect($query){

      mysqli_set_charset($this->db, 'utf8' );
      
     
      $conn =  mysqli_query($this->db,$query);

      // Perform a query, check for error
        if (!$conn)
          {

           $conn = "0";

           return $conn;

          }else{

            return $conn;
          }

    
    }
////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Query STATEMEN, DEVUELVE JSON
     */
        public function Query($query){
        //$this->verify_session();
            
        $ERROR = '';
       
        $i=0;

         $res = $this->connect($query);

        if($res=='0'){
         
          $ERROR['ERROR'] = date("Y-m-d h:i:sa").','.mysqli_error($this->db).','.$query;

          file_put_contents("LOG_ERROR/TEMP_LOG.json",json_encode($ERROR),FILE_APPEND);

          file_put_contents("LOG_ERROR/ERROR_LOG.log",'/MSG/'.date("Y-m-d h:i:sa").'/'.$this->active_user_name.''.$this->active_user_lastname.'/'.mysqli_error($this->db).'/'.$query."\n",FILE_APPEND);

          die(mysqli_error($this->db));
          
        }else{
             file_put_contents("LOG_ERROR/TEMP_LOG.json",''); //LIMPIO EL ARCHIVO

             $columns = mysqli_fetch_fields($res);
         

        
             while ($datos=  mysqli_fetch_assoc($res)) {
                 
                  foreach ($columns as $value) {
                    $currentField=$value->name;

                    $FIELD[$currentField]=$datos[$currentField];

                    $JSON[$i]=json_encode($FIELD);

                   
                 }
                 $i++;
               } 
               
      

        return  $JSON;


        }

        
        $this->close();
        }
////////////////////////////////////////////////////////////////////////////////////////
    /**
     * UPDATE STATEMEN
     */
    public function update($table,$columns,$clause){


    $whereSQL = '';
    if(!empty($clause))
    {
       
        if(substr(strtoupper(trim($clause)), 0, 5) != 'WHERE')
        {
           
            $whereSQL = " WHERE ".$clause;
        } else
        {
            $whereSQL = " ".trim($$clause);
        }
    }
    
    $query = "UPDATE ".$table." SET ";
   
    $sets = array();
    foreach($columns as $column => $value)
    {
         $sets[] = "`".$column."` = '".$value."'";
    }
    $query .= implode(', ', $sets);
    
    $query .= $whereSQL;

    
    $res = $this->Query($query);


    $this->close();
    return $res;

    }
////////////////////////////////////////////////////////////////////////////////////////
    /**
     * QUERY QUE DEVUELVE UN SOLO VALOR CONSULTADO
     */

function Query_value($table,$columns,$clause){

$query = 'SELECT '.$columns.' FROM '.$table.' '.$clause.';';



$res= $this->connect($query);
$columns= mysqli_fetch_fields($res);



     while ($datos=mysqli_fetch_assoc($res)) {
         
          foreach ($columns as $value) {
           
            $currentField=$value->name;

            $column_value=$datos[$currentField];

 
         }

       } 

//echo $column_value;
return  $column_value;
$this->close();
}
////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////
    /**
     * INSERT
     */

public function insert($table,$values){


$fields = array_keys($values);

$query= "INSERT INTO ".$table." (`".implode('`,`', $fields)."`) VALUES ('".implode("','", $values)."');";

$insert = $this->Query($query);

}

////////////////////////////////////////////////////////////////////////////////////////
    /**
     * delete
     */

public function delete($table,$clause){


$query= "DELETE FROM ".$table.' '.$clause.';';

$res = $this->Query($query);


}

////////////////////////////////////////////////////////////////////////////////////////
    /**
     * CIERRA LA CONEXION DE BD
     */
    public function close(){

    return mysqli_close($this->db);

    }
////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////////
//METODOS PARA GESTION DE LOGIN
////////////////////////////////////////////////////////////////////////////////////////
public function login_in($user,$pass,$temp_url){



$res = $this->Query("SELECT * FROM SAX_USER WHERE email='".$user."' AND pass='".$pass."' AND onoff='1';");

foreach ($res as $value) {

    $value = json_decode($value);

    $email= $value->{'email'};
    $id= $value->{'id'};
    $name= $value->{'name'};
    $lastname= $value->{'lastname'};
    $role=$value->{'role'};
    $pass=$value->{'pass'};

    $rol_compras=$value->{'role_purc'};
    $rol_campo  =$value->{'role_fiel'};
}


if($email==''){

 echo "<script> alert('Usuario o Password no son correctos.');</script>";
 

}else{


$columns= array('last_login' => $timestamp = date('Y-m-d G:i:s'));

$this->update('SAX_USER',$columns,'id='.$id);

session_start();


$_SESSION['ID_USER'] = $id;
$_SESSION['NAME'] = $name;
$_SESSION['LASTNAME'] = $lastname;
$_SESSION['EMAIL'] = $email;
$_SESSION['ROLE'] = $role;
$_SESSION['PASS'] = $pass;
$_SESSION['ALMACEN'] = $almacen;
$_SESSION['ROLE1'] = $rol_compras;
$_SESSION['ROLE2'] = $rol_campo;

if($temp_url!=''){

$url = str_replace('@',  '/', $temp_url);

echo '<script>self.location="'.URL.'index.php?url='.$url.'";</script>';


}else{

 echo '<script>self.location="'.URL.'index.php?url=home/index";</script>';
   
}


} 
}


public function verify_session(){

        $conexion = $this->TestConexion();

        list($error,$msg) = explode(':', $conexion);

        //echo $conexion.' '.$error;

        $msg = str_replace('/', '-', $msg);

        if($error=='Error'){
          

          $res = '1';

            echo '<script>self.location="index.php?url=db_config/index/'.$msg.'";</script>';



        }else{

            session_start();

            if(!$_SESSION){

            // echo "<script>alert('Usuario no auntenticado');</script>";
      
            $res = '1';
            echo '<script>self.location="index.php?url=login/index";</script>';

             
            }else{
       
            $res = '0';

            $this->set_login_parameters();
           }

        }

       
     return $res;
    }

public function set_login_parameters(){

        $this->active_user_id = $_SESSION['ID_USER'];
        $this->active_user_name = $_SESSION['NAME'];
        $this->active_user_lastname = $_SESSION['LASTNAME'];
        $this->active_user_email = $_SESSION['EMAIL'];
        $this->active_user_role = $_SESSION['ROLE'] ;
        $this->active_user_almacen = $_SESSION['ALMACEN'];
        $this->id_compania = $this->Query_value('CompanySession','ID_compania','ORDER BY LAST_CHANGE DESC LIMIT 1');
        //$active_user_pass = $_SESSION['PASS'] ;
        
    }


////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////////
//*****************************************************************
//SECCION DE GRAFICOS
////////////////////////////////////////////////////////////////////////////////////////
public function get_user_to_graph(){
$table = '';

$Genouser =$this->Query_value('SAX_USER','COUNT(*)','where ONOFF ="1" and role="user"');


$table .=  "{x: 'Clientes' , z: '0'  , y: '".$Genouser."' },";


$Geadmin =$this->Query_value('SAX_USER','COUNT(*)','where ONOFF ="1" and role="user_admin"');

$table .=  "{x: 'Usuarios del sistema' , z: '0'  , y: '".$Geadmin."' },";
return $table;
}

public function get_asign_to_graph(){

    $table = '';

    $SolAsingned = $this->Query('SELECT 
                                 NO_SOL,
                                 COUNT(NO_SOL) AS CUENTA,
                                 REP_ASIG 
                                 FROM MSG_SOL_HEADER 
                                 WHERE REP_ASIG IS NOT NULL
                                 GROUP BY REP_ASIG');

    foreach($SolAsingned as $value){

        $value = json_decode($value);

        $STATUS_GEN = $this->get_status_gen($value->{'NO_SOL'});

        if($STATUS_GEN=='2'){

         $table .=  "{x: '".$this->Get_User_Name($value->{'REP_ASIG'})."' , z: '0'  , y: '".$value->{'CUENTA'}."' },";

        }

    }


return $table;
}


public function get_finali_to_graph(){
    
    $table = '';

    $SolAsingned = $this->Query('SELECT 
                                 NO_SOL,
                                 COUNT(NO_SOL) AS CUENTA,
                                 REP_ASIG 
                                 FROM MSG_SOL_HEADER 
                                 WHERE REP_ASIG IS NOT NULL
                                 GROUP BY REP_ASIG');

    foreach($SolAsingned as $value){

        $value = json_decode($value);

        $STATUS_GEN = $this->get_status_gen($value->{'NO_SOL'});

        if($STATUS_GEN=='4'){

         $table .=  "{x: '".$this->Get_User_Name($value->{'REP_ASIG'})."' , z: '0'  , y: '".$value->{'CUENTA'}."' },";

        }

    }


return $table;
}

public function get_sol_to_graph(){

if ($this->active_user_role == 'user_admin' or $this->active_user_role == 'admin'){

$query = 'SELECT 
NO_SOL 
FROM MSG_SOL_HEADER';

}else{

$query = 'SELECT 
NO_SOL 
FROM MSG_SOL_HEADER
where MSG_SOL_HEADER.USER ="'.$this->active_user_id.'"';

}


$GetOrder=$this->Query($query);

$table = '';
$SOL_PEND =0;
$SOL_CANCE= 0;
$SOL_FIN= 0;
$SOL_TRANS= 0;
$SOL_PROC = 0;

foreach ($GetOrder as $value) {
   $value   = json_decode($value);

   $STATUS_GEN = $this->get_status_gen($value->{'NO_SOL'});

   switch ($STATUS_GEN) {

    case 5:
       $SOL_CANCE += 1;
      break;
    case 4:
       $SOL_FIN += 1;
      break;
    case 3:
       $SOL_TRANS += 1;
      break;
    case 2:
      $SOL_PROC += 1;//GRIS
      break; 
    case 1:
       $SOL_PEND += 1;//GRIS
      break; 

  }

   
}

if($SOL_CANCE > 0){ $table .=  "{x: 'Cancelado' , z: '0'  , y: '".$SOL_CANCE."' },";}
if($SOL_FIN   > 0){ $table .=  "{x: 'Finalizado', z: '0'  , y: '".$SOL_FIN."'   },";}
if($SOL_TRANS > 0){ $table .=  "{x: 'Transito'  , z: '0'  , y: '".$SOL_TRANS."' },";}
if($SOL_PROC  > 0){ $table .=  "{x: 'Proceso'   , z: '0'  , y: '".$SOL_PROC."'  },";}
if($SOL_PEND  > 0){ $table .=  "{x: 'Pendiente' , z: '0'  , y: '".$SOL_PEND."'  },";}


return $table;
}



public function get_status_gen($id){

//SOLICITUD PENDIENTE
$status = 1;


//STATUS CONFIRMADO (EN PROCESO)
$CONFIRMADO = $this->Query_value('MSG_SOL_STARTED' ,'NO_SOL','WHERE NO_SOL="'.$id.'";');

if($CONFIRMADO  != ''){
 $status = 2;
}

//FINALIZADO
$NO_ITEMS = $this->Query_value('MSG_SOL_DETAIL' ,'COUNT(*)','WHERE NO_SOL="'.$id.'";');
$NO_ITEMS_ENTREGADOS = $this->Query_value('MSG_SOL_DETAIL' ,'COUNT(*)','WHERE NO_SOL="'.$id.'" AND STATUS in ("3","4");');

if($NO_ITEMS == $NO_ITEMS_ENTREGADOS ){
 $status = 4; 
}


//STATUS CANCELADO
$CANCELADO = $this->Query_value('MSG_SOL_HEADER' ,'ST_CLOSED','WHERE NO_SOL="'.$id.'";');

if($CANCELADO == 1){
 $status = 5;
}


// $status = $this->model->Query_value('MSG_SOL_DETAIL','STATUS','WHERE NO_SOL="'.$id.'" AND ITEMID="'.$item.'";');

return $status;
}

///////////////////////////////////////////////////////////////////////////////////
//Verifica que los item totales de una solicitud esten todos en status NO RETIRADO



////////////////////////////////////////////////////////////////////////////////////////
//METODOS PARA GESTION DE OPERACIONES
////////////////////////////////////////////////////////////////////////////////////////
public function Get_lote_list($itemid){

$query='SELECT
Prod_Lotes.no_lote, 
Prod_Lotes.fecha_ven, 
(select sum(qty) from status_location where status_location.lote = Prod_Lotes.no_lote 
and Prod_Lotes.ID_compania ="'.$this->id_compania.'" 
and status_location.ID_compania ="'.$this->id_compania.'") as lote_qty
from Prod_Lotes
where Prod_Lotes.ProductID ="'.$itemid.'" ;';

$list = $this->Query($query);

return $list;


}


public function fact_compras_list(){


$query='SELECT
Purchase_Header_Exp.PurchaseID, 
Purchase_Header_Exp.PurchaseNumber, 
Purchase_Header_Exp.VendorName, 
Purchase_Header_Exp.Date as fecha
from Purchase_Header_Exp
INNER join  Purchase_Detail_Exp on Purchase_Detail_Exp.PurchaseID = Purchase_Header_Exp.PurchaseID
WHERE Purchase_Detail_Exp.Item_id <> " " GROUP BY Purchase_Header_Exp.PurchaseID ';

$list = $this->Query($query);

return $list;
}

public function Get_fact_header($sort,$limit,$clause){

$query='SELECT *
from Purchase_Header_Imp
'.$clause.' Order by Purchase_Header_Imp.TransactionID '.$sort.' limit '.$limit.';';;


$list = $this->Query($query);

return $list;
}


public function lote_loc_by_itemID($itemid){

$query ='SELECT * 
FROM status_location
INNER JOIN Prod_Lotes ON Prod_Lotes.no_lote = status_location.lote
WHERE Prod_Lotes.ProductID="'.$itemid.'"  GROUP BY status_location.ID';

$res = $this->Query($query);

return $res;
}

public function get_Purchaseitem($itemid){

$query ='SELECT
Products_Exp.ProductID,
Products_Exp.Description,
Products_Exp.QtyOnHand,
Products_Exp.UnitMeasure,
Products_Exp.Price1,
Products_Exp.id_compania
from Products_Exp
inner join Prod_Lotes on Prod_Lotes.ProductID=Products_Exp.ProductID
where  Products_Exp.ProductID="'.$itemid.'" ;';



$res = $this->Query($query);

return $res;
}

public function get_ProductsList(){


$query='SELECT 
Products_Exp.ProductID,
Products_Exp.Description,
Products_Exp.UnitMeasure,
Products_Exp.QtyOnHand,
Products_Exp.Price1,
Products_Exp.LastUnitCost
FROM Products_Exp 
inner join Prod_Lotes on Prod_Lotes.ProductID=Products_Exp.ProductID
WHERE Products_Exp.IsActive="1" AND  Products_Exp.QtyOnHand > 0 and Products_Exp.id_compania="'.$this->id_compania.'" and Prod_Lotes.ID_compania="'.$this->id_compania.'" group by Products_Exp.ProductID';


$res = $this->Query($query);

return $res;

}

public function get_ClientList(){

$query='SELECT * FROM Customers_Exp where  id_compania="'.$this->id_compania.'"';

$res = $this->Query($query);

return $res;

}

public function get_VendorList(){

$query='SELECT * FROM Vendors_Exp where  ID_compania="'.$this->id_compania.'"';

$res = $this->Query($query);

return $res;

}

public function Get_CO_No(){

$order = $this->Query_value('Purchase_Header_Imp','TransactionID','where ID_compania="'.$this->id_compania.'" ORDER BY TransactionID DESC LIMIT 1');


//$NO_ORDER = str_pad($NO_ORDER, 7 ,"0",STR_PAD_LEFT);

$NO_ORDER = number_format((int)$order+1);
$NO_ORDER = str_pad($NO_ORDER, 9 ,"0",STR_PAD_LEFT);


if($NO_ORDER< '1'){

    $NO_ORDER=0;
    $NO_ORDER = str_pad($NO_ORDER, 9 ,"0",STR_PAD_LEFT);

}

return $NO_ORDER; 
}


public function Get_SO_No(){

$order = $this->Query_value('SalesOrder_Header_Imp','SalesOrderNumber','where ID_compania="'.$this->id_compania.'" ORDER BY ID DESC LIMIT 1');

list($ACI , $NO_ORDER) = explode('-', $order);


$NO_ORDER = number_format((int)$NO_ORDER+1);
//$NO_ORDER = str_pad($NO_ORDER, 7 ,"0",STR_PAD_LEFT);

$NO_ORDER = 'ACI-'.$NO_ORDER;

if($NO_ORDER< '1'){

    $NO_ORDER=0;
    $NO_ORDER = 'ACI-'.$NO_ORDER;
   // $NO_ORDER = str_pad($NO_ORDER, 7 ,"0",STR_PAD_LEFT);

}



return $NO_ORDER; 
}


public function Get_Order_No(){

$order = $this->Query_value('Sales_Header_Imp','InvoiceNumber','where ID_compania="'.$this->id_compania.'" order by InvoiceNumber DESC LIMIT 1');

$NO_ORDER = number_format((int)$order+1);
$NO_ORDER = str_pad($NO_ORDER, 9 ,"0",STR_PAD_LEFT);


if($NO_ORDER< '1'){

    $NO_ORDER=0;
    $NO_ORDER = str_pad($NO_ORDER, 9 ,"0",STR_PAD_LEFT);

}


return $NO_ORDER; 
}



public function Get_Ref_No(){


$order = $this->Query_value('InventoryAdjust_Imp','Reference','where ID_compania="'.$this->id_compania.'" order by Reference DESC LIMIT 1');

$NO_ORDER = number_format((int)$order+1);
$NO_REF = str_pad($NO_ORDER, 9 ,"0",STR_PAD_LEFT);


if($NO_REF < '1'){

    $NO_REF=0;
    $NO_REF = str_pad($NO_REF, 9 ,"0",STR_PAD_LEFT);

}


return $NO_REF; 
}


public function Get_con_No(){


$order = $this->Query_value('CON_HEADER','refReg','where ID_compania="'.$this->id_compania.'" order by refReg DESC LIMIT 1');

$NO_ORDER = number_format((int)$order+1);
$NO_REF = str_pad($NO_ORDER, 9 ,"0",STR_PAD_LEFT);


if($NO_REF < '1'){

    $NO_REF=0;
    $NO_REF = str_pad($NO_REF, 9 ,"0",STR_PAD_LEFT);

}


return $NO_REF; 
}

public function Get_Req_No(){

$order = $this->Query_value('REQ_HEADER','NO_REQ','where ID_compania="'.$this->id_compania.'" ORDER BY ID DESC LIMIT 1');

list($ACI , $NO_ORDER) = explode('-', $order);


$NO_ORDER = number_format((int)$NO_ORDER+1);
//$NO_ORDER = str_pad($NO_ORDER, 7 ,"0",STR_PAD_LEFT);

$NO_ORDER = 'REQ-'.$NO_ORDER;

if($NO_ORDER< '1'){

    $NO_ORDER=0;
    $NO_ORDER = 'REQ-'.$NO_ORDER;
   

}


return $NO_ORDER; 
}



public function get_JobList(){

$jobs = $this->Query('Select * from Jobs_Exp where ID_compania="'.$this->id_compania.'" and IsActive="1"'); 

if(!$jobs){
 return '0';

}else{
  return $jobs;  
}

}

public function get_phaseList(){

$jobs = $this->Query('Select * from Job_Phases_Exp where ID_compania="'.$this->id_compania.'" and IsActive="1"'); 

if(!$jobs){
 return '0';

}else{
  return $jobs;  
}

}

public function get_costList(){

$jobs = $this->Query('Select * from Job_Cost_Codes_Exp where ID_compania="'.$this->id_compania.'" and IsActive="1"'); 

if(!$jobs){
 return '0';

}else{
  return $jobs;  
}


}


public function Get_User_Info($id){

$user = $this->Query('Select * from SAX_USER where id='.$id); 

return $user;

}

public function Get_User_Name($id){

$USER = $this->Get_User_Info($id);
         
         foreach ($USER as $user ){

            $user = json_decode($user);

            $USERNAME = $user->{'name'}.' '.$user->{'lastname'};

         }

return $USERNAME;


}

public function Get_User_list(){

$user = $this->Query('Select * from SAX_USER where role="user";'); 


return $user;

}


public function Get_company_Info(){

$Company= $this->Query('Select * from company_info;'); 

return $Company;

}

public function Get_order_to_invoice($id){

$id_compania = $this->id_compania;

$ORDER= $this->Query('SELECT * FROM `SalesOrder_Header_Imp`
inner JOIN `SalesOrder_Detail_Imp` ON SalesOrder_Header_Imp.SalesOrderNumber = SalesOrder_Detail_Imp.SalesOrderNumber
inner JOIN `Customers_Exp` ON SalesOrder_Header_Imp.CustomerID = Customers_Exp.CustomerID
inner JOIN `SAX_USER` ON `SAX_USER`.`id` = SalesOrder_Header_Imp.user where SalesOrder_Header_Imp.SalesOrderNumber="'.$id.'" and 
SalesOrder_Detail_Imp.ID_compania="'.$id_compania.'" and SalesOrder_Header_Imp.ID_compania="'.$id_compania.'"
group by SalesOrder_Detail_Imp.ID order by SalesOrder_Detail_Imp.ID;'); 

return $ORDER;

}

public function Get_sales_to_invoice($id){

$ORDER= $this->Query('SELECT * FROM `Sales_Header_Imp`
inner JOIN `Sales_Detail_Imp` ON Sales_Header_Imp.InvoiceNumber = Sales_Detail_Imp.InvoiceNumber
inner JOIN `Customers_Exp` ON Sales_Header_Imp.CustomerID = Customers_Exp.CustomerID
inner JOIN `SAX_USER` ON `SAX_USER`.`id` = Sales_Header_Imp.user where Sales_Header_Imp.InvoiceNumber="'.$id.'" 
and  SalesOrder_Detail_Imp.ID_compania="'.$id_compania.'" and SalesOrder_Header_Imp.ID_compania="'.$id_compania.'"
group by Sales_Detail_Imp.ID order by Sales_Detail_Imp.ID;'); 

return $ORDER;

}

public function Get_sal_merc_to_invoice($id){

$ORDER= $this->Query("SELECT * FROM InventoryAdjust_Imp where Reference='".$id."' and ID_compania='".$this->id_compania."';"); 

return $ORDER;

}

public function Get_sales_conf_Info(){

$saleinfo = $this->Query('SELECT * FROM sale_tax;');

return $saleinfo;

}

//ModifGPH
////////////////////////////////////////////////////
//QUERYS PARA REPORTES

public function get_InvXven($sort,$limit,$clause){

     $order = $this->Query('

         SELECT 
         a.name Almacen, 
         u.etiqueta Ubicacion, 
         l.no_lote Lote, 
         p.ProductID Producto, 
         p.Description Descripcion, 
         l.fecha_ven Vencimiento, 
         s.qty Cantidad
        from Products_Exp p
         inner join Prod_Lotes l  on p.ProductID = l.ProductID 
         inner join status_location s on p.ProductID = s.id_product and s.lote = l.no_lote
         inner join ubicaciones u  on s.route = u.id
         inner join almacenes a on u.id_almacen = a.id 

        '.$clause.' order by l.fecha_ven '.$sort.' limit '.$limit.';');



    return $order;

}


public function get_InvXStk($sort,$limit,$clause){

   $sql = 'SELECT 
         a.name Almacen, 
         u.etiqueta Ubicacion, 
         s.lote Lote, 
         p.ProductID Producto, 
         p.LastUnitCost,
         p.Description Descripcion, 
         s.qty Cantidad
        from Products_Exp p
         inner join status_location s on p.ProductID = s.id_product 
         inner join ubicaciones u  on s.route = u.id
         inner join almacenes a on u.id_almacen = a.id '.$clause.' order by a.name '.$sort.' limit '.$limit.';';

     $order = $this->Query($sql);


    return $order;

}


public function get_req_to_report($sort,$limit,$clause){

$sql='SELECT * FROM `REQ_HEADER` 
inner join REQ_DETAIL ON REQ_HEADER.NO_REQ = REQ_DETAIL.NO_REQ
'.$clause.' group by REQ_HEADER.NO_REQ order by ID '.$sort.' limit '.$limit.';';

$get_req = $this->Query($sql);


return $get_req;
}



public function get_inv_qty_disp($sort,$limit,$clause){

$sql=' SELECT 
p.ProductID, 
p.Description, 
p.QtyOnHand, 
SUM( s.qty )  as LoteQty
FROM Products_Exp p
INNER JOIN status_location s ON s.id_product = p.ProductID AND s.ID_compania = p.id_compania
'.$clause.' GROUP BY p.ProductID order by p.ProductID '.$sort.' limit '.$limit.';';

$get_inv_qty = $this->Query($sql);


return $get_inv_qty;

}

////////////////////////////////////////////////////



////////////////////////////////////////////////////
//Req to print
public function get_req_to_print($id){


$sql='SELECT * FROM `REQ_HEADER` 
inner join REQ_DETAIL ON REQ_HEADER.NO_REQ = REQ_DETAIL.NO_REQ
WHERE 
REQ_HEADER.ID_compania="'.$this->id_compania.'" AND  
REQ_DETAIL.ID_compania="'.$this->id_compania.'" and 
REQ_HEADER.NO_REQ="'.$id.'" and 
REQ_DETAIL.NO_REQ="'.$id.'"';

$req_info = $this->Query($sql);

return $req_info ;
}


////////////////////////////////////////////////////
//Orden de compras por id
public function get_items_by_OC($invoice){

$query ='SELECT * 
FROM PurOrdr_Header_Exp
INNER JOIN PurOrdr_Detail_Exp ON PurOrdr_Header_Exp.TransactionID = PurOrdr_Detail_Exp.TransactionID
WHERE PurOrdr_Header_Exp.ID_compania="'.$this->id_compania.'"
AND PurOrdr_Header_Exp.PurchaseOrderNumber ="'.$invoice.'"';

$res = $this->Query($query);


return $res;
}

//Orden de compras total
public function get_OC($sort,$limit,$clause){

$query ='SELECT * 
FROM PurOrdr_Header_Exp
INNER JOIN PurOrdr_Detail_Exp ON PurOrdr_Header_Exp.TransactionID = PurOrdr_Detail_Exp.TransactionID
'.$clause.' group by PurOrdr_Header_Exp.TransactionID Order by PurOrdr_Header_Exp.Date '.$sort.' limit '.$limit.';';


$res = $this->Query($query);


return $res;
}

////////////////////////////////////////////////////



////////////////////////////////////////////////////
//Consignacion

public function con_reg($refReg,$cont,$ID_compania){

$idReg = $this->Query_value('CON_HEADER','idReg','WHERE refReg = "'.$refReg.'" and ID_compania="'.$ID_compania.'";');

$regTra = $this->Query('SELECT id from reg_traslado where ID_compania="'.$ID_compania.'" ORDER BY LAST_CHANGE desc limit '.$cont.';');

   foreach ($regTra as $value) {
  
   $value = json_decode($value);

   $ID_REG_TRAS = $value->{'id'};

    $this->Query('INSERT INTO CON_REG_TRAS (idReg,idRegTras,ID_compania) values ("'.$idReg.'","'.$ID_REG_TRAS.'","'.$ID_compania.'");');

    }

}



public function get_con_to_report($sort,$limit,$clause){

$sql='SELECT      
                  CON_HEADER.date,
                  CON_HEADER.refReg as REF,
                  CON_HEADER.idJob  as JOB,
                  CON_HEADER.idPha as  PHASE,
                  CON_HEADER.idCost as COST,
                  CON_HEADER.nota as NOTA,
                  reg_traslado.id_almacen_ini,
                  reg_traslado.route_ini,
                  reg_traslado.id_almacen_des,
                  reg_traslado.route_des,
                  reg_traslado.id_user as USER,
                  reg_traslado.lote as LOTE,
                  reg_traslado.ProductID,
                  reg_traslado.qty as CANT
                  FROM CON_HEADER 
                  INNER JOIN CON_REG_TRAS ON CON_REG_TRAS.idReg = CON_HEADER.idReg 
                  INNER JOIN reg_traslado ON CON_REG_TRAS.idRegTras = reg_traslado.id 
                  '.$clause.' order by CON_HEADER.idReg '.$sort.' limit '.$limit.';';

$get_con = $this->Query($sql);


return $get_con;
}
////////////////////////////////////////////////////


public function get_sol_to_mailing($id){

$table = '';
  $msg_detail = $this->Query('SELECT * FROM  MSG_SOL_HEADER WHERE MSG_SOL_HEADER.NO_SOL="'.$id.'";');


  $table .= '<script>

  var table = $("#table_info").dataTable({

         rowReorder: {
              selector: "td:nth-child(2)"
          },

        bSort: false,
        select:true,
        scrollY: "800px",
        scrollCollapse: true,
        responsive: true,
        searching: false,
        paging:    false,
        info:      false });


  </script>';

  $table .= '<br/><br/>
  <fieldset>
  <div class="col-lg-6" >
  <table  class="display nowrap table table-striped table-bordered" cellspacing="0"  ><tbody>';

  foreach ($msg_detail as $datos) {

  $msg_detail  = json_decode($datos);

  $table .= "<tr><th style='text-align:left;'><strong>No. Guía</strong></th><td class='InfsalesTd order'>".$msg_detail->{'NO_SOL'}."</td><tr>
            <tr><th style='text-align:left;'><strong>Fecha</strong></th><td class='InfsalesTd'>".$msg_detail->{'DATE'}."</td><tr>
            <tr><th style='text-align:left;'><strong>Cliente</strong></th><td class='InfsalesTd'>".$msg_detail->{'ORI_NAME'}."</td><tr>
            <tr><th style='text-align:left;'><strong>Telf.</strong></th><td class='InfsalesTd'>".$msg_detail->{'ORI_TELF'}."</td><tr>
            <tr><th style='text-align:left;'><strong>E-mail</strong></th><td class='InfsalesTd'>".$msg_detail->{'ORI_MAIL'}.'</td><tr>
            <tr><th style="text-align:left;" ><strong>Dirección de retiro</strong></th><td class="InfsalesTd">'.$msg_detail->{'ORI_DIR'}."</td><tr>
            <tr><th style='text-align:left;'><strong>Nota</strong></th><td class='InfsalesTd'>".$msg_detail->{'ORI_NOTA'}."</td><tr>
            <tr><th style='text-align:left;'><strong>No. Piezas</strong></th><td class='InfsalesTd'>".$msg_detail->{'NOPIEZA'}."</td><tr>";


  }


$table .= "</tbody></table></div></fieldset>";


$table .= '
        <fieldset>
        <table id="table_info" class="table table-striped table-bordered" cellspacing="0" border="1"  width="100%">
        <thead>
          <tr>
        <th width="10%" >No.</th>
        <th width="10%" class="text-center">Producto</th>
        <th width="20%" class="text-center">Destinatario (Empresa)</th>
        <th width="20%" class="text-center">Direccion de envio</th>
        <th width="20%" class="text-center">Datos de remitente</th>
        <th width="20%" class="text-center">Nota</th>
        </tr>
        </thead><tbody>';

        $sql = 'SELECT * FROM  MSG_SOL_DETAIL WHERE NO_SOL="'.$id.'";';

        $msg_items = $this->Query($sql);

        foreach ($msg_items as $datos) {

        $msg_items  = json_decode($datos);

        $table .= '<tr  >
              <td>'.$msg_items->{'ITEMID'}.'</td>
              <td>'.$msg_items->{'PRODUCT'}.'</td>
              <td>'.$msg_items->{'DEST_EMPRESA'}.'</td>
              <td>'.$msg_items->{'DEST_DIR'}.'</td>
              <td>'.$msg_items->{'DEST_NAME'}.', '.$msg_items->{'DEST_DIR'}.', '.$msg_items->{'DEST_TELF'}.'</td>
              <td>'.$msg_items->{'NOTA'}.'</td>
              </tr>';  

        }
         

$table .= '</tbody></table>';


return  $table;

}

///////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////
//fUNCION PARA ENVIAR MAILS
public function send_mail($addresses,$subject,$message_to_send){

require 'PHP_mailer/PHPMailerAutoload.php';
$mail = new PHPMailer;

$mail->IsMAIL(); // enable SMTP
$mail->IsHTML(true);



$sql = "SELECT * FROM CONF_SMTP WHERE ID='1'";

$smtp= $this->Query($sql);

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



$mail->Subject = $subject;


$mail->Body = $message_to_send;

$mail->AddAddress($addresses);



if(!$mail->send()) {
 

   $alert .= 'El correo no puede ser enviado.';
   $alert .= 'Error: ' . $mail->ErrorInfo;

   

} else {
  
  $alert = 'El correo de verificacion ha sido enviado';
}

echo $alert;

}


public function encriptar($cadena){
    $key='d@oute1';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
    $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $cadena, MCRYPT_MODE_CBC, md5(md5($key)))); 
    $encrypted = str_replace(array('+', '/'), array('-', '_'),$encrypted );

    return $encrypted; //Devuelve el string encriptado
 
}


public function desencriptar($cadena){
     $cadena = str_replace(array('-', '_'), array('+', '/'), $cadena);

     $key='d@oute1';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
     $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($cadena), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
    return $decrypted;  //Devuelve el string desencriptado
}



//ESTA ES LA ULTIMA LLAVE DE LA CLASE - NO BORRAR -
}
?>
