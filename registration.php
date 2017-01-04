<?
error_reporting (0); 
ini_set('display_error', '0');

require_once('config.php');
require_once('admin/inc/function.inc.php');
$thispage	= basename($_SERVER['PHP_SELF']);

if (@file_exists('config.php') == FALSE)
	exit('<p>Configuration file missing</p>');

if(!isset($_SESSION['enrico-blog']['user'])):
	if(isset($_POST['signup-go']))
	{
		$user					= mysql_real_escape_string($_POST['username']);
		$password				= mysql_real_escape_string($_POST['password']);
		$password_2				= mysql_real_escape_string($_POST['password-2']);
		$email					= mysql_real_escape_string($_POST['email']);
		$passwordcript			= cript_password($password);
					
		$query = "INSERT INTO users (username, password, email, level) VALUES ('$user', '$passwordcript', '$email', 'usr');";
		
		$error		= FALSE;
		$message	= array();
		
		if(strlen($user) < 2)
		{
			$error		= TRUE;
			$message[0]	= 'Lo username deve essere di almeno 2 caratteri!';
		}
		
		elseif(strlen($user)>=9)
		{
			$error		= TRUE;
			$message[0] = 'Lo deve essere di massimo 9 caratteri!';
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
		
					
		if(!$error)
		{
			if(mysql_query($query))
			{
				$error		= FALSE;
				header("Location: index.php");
			}
			else
			{
				$error		= TRUE;
				$message[6]	= 'L\'account non è stato creato per problemi interni al server. Riprova più tardi.';
			}
			
		}
		
	}

	?>

	<? include('inc/header.php'); ?>
	<div class="container"> 
		    <div class="colonna-destra">
		    	<h1> Effettua la registrazione </h1>

		    		<?
		    			if($error){
		    				echo '<div class="alert-error">';
		    				foreach($message as $value) 
		    					echo ' <p>'.$value .'</p>'; 
		    				echo '</div>';
		    			}
		    		?>

		    		<form method="post" action="<?=$thispage;?>">
		    			<fieldset>
    						<legend>Compila il form per registrarti:</legend>

    					<p>Username: </p>
		    			<input type="text" name="username" />
		    			<p>Email: </p>
		    			<input type="text" name="email" />
		    			<p>Password: </p>
		    			<input type="password" name="password" />
		    			<p>Conferma password: </p>
		    			<input type="password" name="password-2" />
		    			<p></p>
		    			<input type="submit" name="signup-go" />
		    			</fieldset>
		    		</form>
		    </div>
		</div>  <!-- ./ container --> 
<?	
else:	
	header('Location: index.php');

endif;

?>
