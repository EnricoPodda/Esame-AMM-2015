<? if(isset($_SESSION['enrico-blog']['admin'])):
if(isset($_POST['signup-go']))
{
	$user					= mysql_real_escape_string($_POST['user']);
	$password				= mysql_real_escape_string($_POST['password']);
	$password_2				= mysql_real_escape_string($_POST['password-2']);
	$email					= mysql_real_escape_string($_POST['email']);
	$newsletter				= isset($_POST['newsletter']) ? $_POST['newsletter'] : 0;
	$passwordcript			= cript_password($password);
	
	$url 		= $_SERVER['HTTP_HOST'].str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
	$string 	= explode("/", $url);
	$avatar 	= 'http://'.$string[0].'/'.$string[1].'/upload/default-avatar.png';
		
	$query = "INSERT INTO sn_users (username, password, email, newsletter, level, avatar) VALUES ('$user', '$passwordcript', '$email', $newsletter, 'admin', '$avatar');";
	
	$error		= FALSE;
	$message	= array();
	
	if(strlen($user) < 2)
	{
		$error		= TRUE;
		$message[0]	= 'Il username deve essere di almeno 2 caratteri!';
	}
	
	elseif(strlen($user)>9)
	{
		$error		= TRUE;
		$message[0] = 'Il nome utente deve essere di massimo 9 caratteri!';
	}
	
	if(strlen($password)< 5)
	{
		$error		= TRUE;
		$message[1] = 'La password deve essere di almeno 5 caratteri!';
	}
	
	elseif(strlen($password)>9)
	{
		$error		= TRUE;
		$message[1] = 'La password deve essere di massimo 9 caratteri!';
	}
	elseif($user == $password)
	{
		$error		= TRUE;
		$message[1] = 'La password non può essere uguale all\'username.';
	}
	
	
	if($password != $password_2)
	{
		$error		= TRUE;
		$message[2] = 'Le due passowrd non coincidono.';
	}
	
	if(!validatemail($email))
	{
		$error		= TRUE;
		$message[3] = 'Inserisci una email valida.';
	}	
		
	elseif(strlen($email)>50)
	{
		$error		= TRUE;
		$message[3] = 'L\'email deve essere lunga massimo 50 caratteri.';
	}
	
	$ceq 	= "SELECT email FROM sn_users WHERE email = '$email';";
	$rceq	= mysql_query($ceq);
	if($rceq)
	{
		$count_1 = mysql_num_rows($rceq);
		if($count_1 >= 1)
		{
			$error		= TRUE;
			$message[4] = 'L\'email è già in uso da un altro utente, se hai dimenticato la password utilizza il nostro recupera password.';
		}
	}
	
	$clq 	= "SELECT username FROM sn_users WHERE username = '$user';";
	$rclq	= mysql_query($clq);
	if($rclq)
	{
		$count_2 = mysql_num_rows($rclq);
		if($count_2 >= 1)
		{
			$error		= TRUE;
			$message[5] = 'L\'username è già in uso da un altro utente, scegline un altro.';
		}
	}
	
				
	if(!$error)
	{
		if(mysql_query($query))
		{
			$error		= FALSE;
			header("Location: index.php?page=home", "refresh");
		}
		else
		{
			$error		= TRUE;
			$message[6]	= 'L\'account non è stato creato per problemi interni al server. Riprova più tardi.';
		}
		
	}
	
}

?>

<? include ('layout/header.inc.php'); ?>
<div class="container">

	<?php include('inc/lateral-menu.php');?>
    
		<div class="colonna-destra">
        
		<?php
        ?>
            <form class="form-horizontal" action='index.php?page=signup' method='POST'>
            
              <fieldset>
                <legend>Registra un account amministratore</legend>
                
                <?  if(isset($_POST['signup-go']) && $error == TRUE):
						echo '<div class="alert-error">';
						foreach($message as $value) : echo '<p>'.$value .'</p>'; endforeach;
						echo '</div>';

					endif;
				?> 
                                
                <div class="control-group <? if(isset($message[0]) or isset($message[5])) echo 'error';?>">
                    <label class="control-label" for="input01">Username</label>
                        <div class="controls">
                            <input type="text" class="input-xlarge" name="user"  maxlength="9"  value="<? if(isset($user)) echo $user;?>" />
                            <p class="help-block">Il nome che utilizzerai per effettuare il login, massimo 9 caratteri</p>
                        </div>
                </div>
                
                <div class="control-group <? if(isset($message[1]) or isset($message[2])) echo 'error';?>">
                    <label class="control-label" for="input01">Password</label>
                        <div class="controls">
                            <input type="password" class="input-xlarge"  name="password" maxlength="9" />
                            <p class="help-block">Massimo 9 caratteri</p>
                        </div>
                </div>
                
                <div class="control-group <? if(isset($message[2])) echo 'error';?>">
                    <label class="control-label" for="input01">Conferma password</label>
                        <div class="controls">
                            <input type="password" class="input-xlarge"  name="password-2" maxlength="9" />
                            <p class="help-block">Riscrivi per sicurezza la password</p>
                        </div>
                </div>
                
                <div class="control-group <? if(isset($message[3]) or isset($message[4])) echo 'error';?>">
                    <label class="control-label" for="input01">Email</label>
                        <div class="controls">
                            <input type="text" class="input-xlarge" name="email" maxlength="50" value="<? if(isset($email)) echo $email;?>" />
                        </div>
                </div>
                
                <div class="control-group">
                    <div class="controls">
                        <label class="checkbox">
                        	<input type="checkbox" name="newsletter"  value="1" <? if(isset($newsletter) && ($newsletter == 1)) echo 'checked="checked"';?> /> Newsletter attivo ? 
                        </label>
                	</div>
                </div>
                	
                <div class="form-actions">
                    <button type="submit" class="btn" name="signup-go">Registra</button>
                </div>
                                
              </fieldset>
            </form>
		</div>
        
	</div>
        
</div>  
<? include ('layout/footer.inc.php'); ?>
  
<? else: header('Location: index.php?page=home'); endif; ?>                        