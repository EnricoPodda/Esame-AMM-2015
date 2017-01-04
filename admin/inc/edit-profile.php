<? if(isset($_SESSION['enrico-blog']['admin'])):

if(!$_GET['username']) header('Location: index.php?page=show-users');

$usernameGET	= $_GET['username'];
$sql_user		= "SELECT * FROM users WHERE username = '$usernameGET'";
$run_sql_user	= mysql_query($sql_user, $config['conn']);
$exist_user		= mysql_num_rows($run_sql_user);
$row_user		= mysql_fetch_array($run_sql_user);

if($exist_user != 1) header('Location: index.php?page=show-users');

if(isset($_POST['edit-info']))
{
	$user					= mysql_real_escape_string($_POST['user']);
	$email					= mysql_real_escape_string($_POST['email']);
	$level					= isset($_POST['level']) ? mysql_real_escape_string($_POST['level']) : $_SESSION['enrico-blog']['admin']['level'];
	$newsletter				= isset($_POST['newsletter']) ? $_POST['newsletter'] : 0;
			
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
	
	if($email != $row_user['email'])
	{
		$ceq 	= "SELECT email FROM users WHERE email = '$email';";
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
	}
	
	if($user != $row_user['username'])
	{
		$clq 	= "SELECT username FROM users WHERE username = '$user';";
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
	}					  
	
	$query 	= "UPDATE users
				SET username='$user', email='$email', level='$level'
				WHERE username='$usernameGET'";
				
	$query2	= "UPDATE news SET author = '$user' WHERE author = '$usernameGET'";
				
	if(!$error)
	{
		if(mysql_query($query) && mysql_query($query2))
		{
			$error		= FALSE;
			$message[6]	= 'L\'account &egrave; stato modificato con successo, attendi il reindirizzamento automatico.';
			
			if($_SESSION['enrico-blog']['admin']['username'] == $usernameGET)
			{
				$_SESSION['enrico-blog']['admin']['username'] 			= $user;
				$_SESSION['enrico-blog']['admin']['email'] 				= $email;
				$_SESSION['enrico-blog']['admin']['newsletter'] 			= $level;
				$_SESSION['enrico-blog']['admin']['avatar']				= $path;
			}
			
			header("Location: index.php?page=edit-profile&&username=$user", "refresh");
		}
		else
		{
			$error		= TRUE;
			$message[6]	= 'L\'account non è stato modificato per problemi interni al server. Riprova più tardi.';
		}
		
	}
	
}


if(isset($_POST['edit-pass'])):
	
	$password_nocript	= mysql_real_escape_string($_POST['password']);
	$password			= cript_password($_POST['password']);
	$password_2			= cript_password($_POST['password-confirm']);
	
	$error		= FALSE;
	$message	= array();

	if(strlen($password_nocript)< 5)
	{
		$error		= TRUE;
		$message[7] = 'La password deve essere di almeno 5 caratteri!';
	}
	
	elseif(strlen($password_nocript)>9)
	{
		$error		= TRUE;
		$message[7] = 'La password deve essere di massimo 9 caratteri!';
	}
	elseif($usernameGET == $password_nocript)
	{
		$error		= TRUE;
		$message[7] = 'La password non può essere uguale all\'username.';
	}
	
	
	if($password != $password_2)
	{
		$error		= TRUE;
		$message[8] = 'Le due passowrd non coincidono.';
	}
	
	$query	= "UPDATE users SET password = '$password' WHERE username = '$usernameGET'";
				
	if(!$error)
	{
		if(mysql_query($query) )
		{
			$error		= FALSE;
			$message[6]	= 'L\'account &egrave; stato modificato con successo, attendi il reindirizzamento automatico.';
			
			if($_SESSION['enrico-blog']['admin']['username'] == $usernameGET)
			{
				$_SESSION['enrico-blog']['admin']['password_no_cript']	= $password_nocript;
				$_SESSION['enrico-blog']['admin']['password_cript']		= $password;
			}
			
			header("index.php?page=edit-profile&&username=$usernameGET", "refresh");
		}
		else
		{
			$error		= TRUE;
			$message[6]	= 'L\'account non è stato modificato per problemi interni al server. Riprova più tardi. ' .$query;
		}
		
	}
	
endif;
?>


<? include ('layout/header.inc.php'); ?>
<div class="container">
	<?php include('inc/lateral-menu.php');?>
    
		<div class="colonna-destra">
            <form class="form-horizontal" action='index.php?page=edit-profile&&username=<?=$_GET['username'];?>' method='POST'>
              <fieldset>

                    
                    <?  if(isset($_POST['edit-info']) && $error == TRUE):
						echo '<div class="alert-error">';
						foreach($message as $value) : echo '<p>'.$value .'</p>'; endforeach;
						echo '</div>';
					endif;
					?>
                    
                    <?  if(isset($_POST['edit-pass']) && $error == TRUE):
						echo '<div class="alert-error">';
						foreach($message as $value) : echo '<p>'.$value .'</p>'; endforeach;
						echo '</div>';

					endif;
					?>
                    
                        <h4> Modifica le informazioni di base </h4>  
                        <div class="control-group <? if(isset($message[0]) or isset($message[5])) echo 'error';?>">
                            <label class="control-label" for="username">Username</label>
                                <div class="controls">
                                    <input type="text" class="input-xlarge" name="user"  maxlength="9"  
                                    value="<? if(isset($_POST['edit-info'])) echo $user; else echo $row_user['username'];?>" />
                                </div>
                        </div>
                                        
                        <div class="control-group <? if(isset($message[3]) or isset($message[4])) echo 'error';?>">
                            <label class="control-label" for="email">Email</label>
                                <div class="controls">
                                    <input type="text" class="input-xlarge" name="email" maxlength="50" 
                                    value="<? if(isset($_POST['edit-info'])) echo $email; else echo $row_user['email'];?>" />
                                </div>
                        </div>
                        
                        <? if($row_user['id'] != 1): ?>
                            <div class="control-group">
                            <label class="control-label" for="input01">Grado</label>
                                <div class="controls">
                                    <label class="level">
                                        <select name="level">
                                            <option <? if( (isset($_POST['edit-info'])) && ($_POST['level'] == 'usr')) echo 'selected="selected"'; 
                                                        elseif($row_user['level'] == 'usr') echo 'selected="selected"'?> value="usr">Utente</option>
                                                        
                                            <option <? if( (isset($_POST['edit-info'])) && ($_POST['level'] == 'admin')) echo 'selected="selected"';
                                                        elseif($row_user['level'] == 'admin') echo 'selected="selected"'?> value="admin">Amministratore</option>
                                        </select>                        
                                    </label>
                                </div>
                            </div>
                        <? endif; ?>  
                        
                        <br>

                        <div class="form-actions">
                            <button type="submit" class="btn" name="edit-info">Modifica informazioni generali</button>
                        </div>
                                                   
                        
                        <hr>
                        
                        <h4> Modifica la password </h4>  
                        <div class="control-group <? if(isset($message[0]) or isset($message[5])) echo 'error';?>">
                            <label class="control-label" for="password">Nuova password</label>
                                <div class="controls">
                                    <input type="password" class="input-xlarge" name="password" maxlength="9" />
                                </div>
                        </div>
                                        
                        <div class="control-group <? if(isset($message[3]) or isset($message[4])) echo 'error';?>">
                            <label class="control-label" for="password-confirm">Conferma password</label>
                                <div class="controls">
                                    <input type="password" class="input-xlarge" name="password-confirm" maxlength="9" />
                                </div>
                        </div>
                        
                        <br>

                        <div class="form-actions">
                            <button type="submit" class="btn" name="edit-pass">Modifica password</button>
                        </div>
                         
                    
                </div>
            
                
                 

                
                                
              </fieldset>
            </form>
		</div>
        
	</div>
        
</div>   
<? include ('layout/footer.inc.php'); ?>

<? else: header('Location: index.php?page=home'); endif; ?>                        