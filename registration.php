<?
error_reporting (0); 
ini_set('display_error', '0');

require_once('config.php');
require_once('admin/inc/function.inc.php');
$thispage	= basename($_SERVER['PHP_SELF']);

if (@file_exists('config.php') == FALSE): echo '<p>Configuration file missing</p>';
else:

if(!isset($_SESSION['enrico-blog']['user'])):
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
			
		$query = "INSERT INTO sn_users (username, password, email, newsletter, level, avatar) VALUES ('$user', '$passwordcript', '$email', $newsletter, 'usr', '$avatar');";
		
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
				$message[6]	= 'L\'account &egrave; stato registrato con successo, verrai reindirizzato alla home.';
				header("Refresh: 3; url=index.php");
			}
			else
			{
				$error		= TRUE;
				$message[6]	= 'L\'account non è stato creato per problemi interni al server. Riprova più tardi.';
			}
			
		}
	
		foreach($message as $value) : echo '<p>'.$value .'</p>'; endforeach;
	
	}
	
	/** MOSTRO IL FORM LOGIN **/
	echo '<form method="post" action="' .$thispage .'" >';
	echo stripslashes($config['template']['registration']);
	echo '</form>';

else:	
	echo '<meta http-equiv="refresh" content="0;url='.$config['row']['site_url'].'" />';	
endif;

/** CHIUDO IL CHECK PER IL FILE DI CONFIGURAZIONE **/
endif;
?>
