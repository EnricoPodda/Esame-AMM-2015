<? if(!isset($_SESSION['enrico-blog']['admin'])):
if(isset($_POST['login-go'])):
	$user			= mysql_real_escape_string($_POST['username']);
	$password		= mysql_real_escape_string($_POST['password']);
	$passwordcript	= cript_password($password);
	$sql = "SELECT * FROM sn_users WHERE username = '$user' and password = '$passwordcript' and level ='admin'";
	
	if($ris = mysql_query($sql))
	{
		if(mysql_num_rows($ris) == 1)
		{
			$array = mysql_fetch_array($ris);
			$_SESSION['enrico-blog']['admin']['password_no_cript']	= $password;
			$_SESSION['enrico-blog']['admin']['password_cript']		= $array['password'];
			$_SESSION['enrico-blog']['admin']['username'] 			= $array['username'];
			$_SESSION['enrico-blog']['admin']['email'] 				= $array['email'];
			$_SESSION['enrico-blog']['admin']['newsletter'] 			= $array['newsletter'];
			$_SESSION['enrico-blog']['admin']['level'] 				= $array['level'];
			$_SESSION['enrico-blog']['admin']['id'] 					= $array['id'];
			$_SESSION['enrico-blog']['admin']['avatar']				= $array['avatar'];
			
			$error		= FALSE;
			header("Location: index.php?page=home", "refresh");
		}
		else
		{
			$error		= TRUE;
			$message[0]	= 'Non hai inserito dati corretti, riprova.';
		}
	}
	else
	{
		$error		= TRUE;
		$message[1]	= 'Non &egrave; stato possibile effettuare l\'accesso per problemi interni al server. Riprova pi&ugrave; tardi.';	
	}
endif;

?>

<? include ('layout/header.inc.php'); ?>

<div class="container">

	<?php //include('inc/lateral-menu.php');?>
    
		<div class="colonna-destra">

			<form class="form-horizontal" action='index.php?page=login' method='POST'>           
				<fieldset>
				<legend>Effettua il login</legend>
				
                <?  if(isset($_POST['login-go']) && $error == TRUE):
						echo '<div class="alert-error">';
						foreach($message as $value) : echo '<p>'.$value .'</p>'; endforeach;
						echo '</div>';
					
					endif;
				?>                
                
				<div class="control-group">
					<label class="control-label" for="username">Username</label>
						<div class="controls">
							<input type="text" class="input-xlarge" name="username" autocomplete="off"  maxlength="9" value="<? if(isset($user)) echo $user;?>" />
						</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="password">Password</label>
						<div class="controls">
							<input type="password" class="input-xlarge" name="password" maxlength="9" />
						</div>
				</div>
				
				<div class="control-group">
					<div class="controls">
						<p><a href="index.php?page=forgot-password" title="Password dimenticata ?">Password dimenticata ? </a></p>
					</div>
				</div>
				
				<div class="form-actions">
					<button type="submit" class="btn" name="login-go">Login</button>
				</div>
				 
								
			  </fieldset>
			</form>

        
		</div>
        
	</div>
        
</div>

<? include ('layout/footer.inc.php'); ?>
    
<? else: header('Location: index.php?page=home'); endif; ?>            