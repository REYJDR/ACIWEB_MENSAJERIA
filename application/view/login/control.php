
<div  class="col-lg-3"></div>
<div  class="page login col-lg-5">
<!--INI DIV ERRO-->
<?php



if(isset($_POST['flag']))
{

	//inicio variables de session
	$user = $_POST['user'];
	$pass = md5($_POST['pass']);


    $login = $this->model->login_in($user,$pass); 
}

?>
<!--INI DIV ERROR-->

			<div class="col-lg-12">
			
			
				<!-- Add class "fade-in-effect" for login form effect -->
				<form action="" method="POST" role="form" id="login" >

					<input type="hidden" name='flag' value="1" />
                                        
					<div class="col-lg-12 login-header">
					<div class="separador col-lg-12"></div>
						<a href="#" class="logo">
							<center><img src="img/logo.jpg" alt="" width="250" /></center>
							
						</a>
						
						
					</div>
                                        
                       
	               <div class="separador col-lg-12"></div>

					    <div class="col-lg-12">

							<div class="form-group col-lg-12">
							<h3 class="login_title" >Log in</h3>
							</div>

							<div class="form-group col-lg-12">
								<label class="control-label" for="username">Usuario</label>
								<input type="text" class="form-control" id="user" name="user"  autocomplete="off" />
							</div>	

							<div class="form-group col-lg-12">
								<label class="control-label" for="passwd">Password</label>
								<input type="password" class="form-control" name="pass" id="pass" autocomplete="off" />
							</div>

							<div class="separador col-lg-12"></div>
							<div class="separador col-lg-12"></div>

							<div class="form-group col-lg-4">
								<button type="submit" class="btn btn-primary  btn-block text-left">
								<i style="color: white;" class="fa fa-lock"></i> Entrar
								</button><br>
							</div>
	
	                        <div class="col-lg-4"></div>

							<div class="form-group col-lg-4">
								<a  href="<?php echo URL; ?>index.php?url=login/sign_up" >
								<input type="button" id="modal_button" name="modal_button"  class="btn btn-success btn-sm btn-icon icon-left col-lg-12" value="Registrate" /></a>
							</div>
						 
					    </div>
					    <div class="col-lg-12">
					    	<div class="form-group col-lg-8">
								<a  href="<?php echo URL; ?>index.php?url=login/forgot_pass" >Recuperar Contraseña</a>
							</div>
														
					    </div>
					
				</form>
			
		</div>
		
	</div>
