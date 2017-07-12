<?PHP

class ges_mensajeria extends Controller
{

//******************************************************************************
//
public function msg_sol(){


 $res = $this->model->verify_session();

        if($res=='0'){
        

            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/_templates/panel.php';
            require APP . 'view/operaciones/msg_sol.php';
            require APP . 'view/_templates/footer.php';


        }
          


	
}

public function msg_entrega($id){


 $res = $this->model->verify_session();

        if($res=='0'){
        

            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/_templates/panel.php';

            ECHO '<input id="reqidhide" type="hidden" value="'.$id.'" />';

            require APP . 'view/operaciones/msg_entrega.php';
            require APP . 'view/_templates/footer.php';


        }
          


	
}



public function msg_rep(){


 $res = $this->model->verify_session();

        if($res=='0'){
        

            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/_templates/panel.php';
            require APP . 'view/operaciones/msg_rep.php';
            require APP . 'view/_templates/footer.php';


        }
          


	
}

public function msg_mailing($id){

 $res = $this->model->verify_session();

      if($res=='0'){


      require 'PHP_mailer/PHPMailerAutoload.php';
      $mail = new PHPMailer;


      

            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/_templates/panel.php';
            require APP . 'view/operaciones/msg_mailing.php';
            require APP . 'view/_templates/footer.php';


        }


}

public function msg_print($id){

 $res = $this->model->verify_session();

      if($res=='0'){

            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/_templates/panel.php';
            require APP . 'view/operaciones/msg_print.php';
            require APP . 'view/_templates/footer.php';


        }


}


}
?>