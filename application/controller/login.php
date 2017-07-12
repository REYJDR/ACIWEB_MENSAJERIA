<?php

class login extends Controller
{


public function index($temp_url){


        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/login/control.php';
        require APP . 'view/_templates/footer.php';
    }


public function login_out(){


		session_start();

		if($_SESSION['EMAIL']){

			session_destroy();
			echo '<script>
			      alert("Usted ha cerrado su sesion con exito, hasta pronto!") 
			      self.location="'.URL.'index.php?url=home/index";</script>';

		}else{

		echo "<script>self.location='".URL."index.php?url=home/index';</script>";

		}

} 


public function sign_up(){


        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/login/sign_up.php';
        require APP . 'view/_templates/footer.php';
    }


public function sign_up_success(){


        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/login/sign_up_succ.php';
        require APP . 'view/_templates/footer.php';

    }


public function forgot_pass(){


        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/login/forgot_pass.php';
        require APP . 'view/_templates/footer.php';

    }


public function forgot_pass_succ(){


        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/login/forgot_pass_succ.php';
        require APP . 'view/_templates/footer.php';

    }


public function pass_recovery($mail,$control_key){

    $mail = $this->model->desencriptar($mail);

    $control_key = $this->model->desencriptar($control_key);

    $key_verify = $this->model->Query_value('SAX_USER','Recover_key','WHERE email = "'.$mail.'"');

   
    
if ($control_key == $key_verify) {
        
    

        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/login/pass_recovery.php';
        require APP . 'view/_templates/footer.php';

    }else{ ?>

    <script>

      alert('Error: El email de recuperacion ya ha sido usado, por favor realice una nueva solicitud');

      self.location= "<?php echo URL; ?>index.php?url=login/index";

    </script>

    <?php }
    
    }


}
?>