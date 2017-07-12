
<?php 

if(isset($_POST['sing']) and isset($_POST['id']) and isset($_POST['item']) ){


$FILE_NAME = 'img/Signatures/'.$_POST['id'].'-'.$_POST['item'].'.png';

$data_uri = $_POST['sing'];

$encoded_image = explode(",", $data_uri)[1];
$decoded_image = base64_decode($encoded_image);

$save = file_put_contents($FILE_NAME, $decoded_image);



if($save){

//IMAGEN DE PRODUCTO
$target_dir = "img/Del_item_img/";

$target_file = $target_dir . basename($_FILES["image"]["name"]);



if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
	 			
		rename("img/Del_item_img/".$_FILES["image"]["name"], "img/Del_item_img/".$_POST['id'].'-'.$_POST['item'].".jpg");
	      
	    echo 'ok';  

        } 

} 


}

?>