<?

error_reporting (0); 
ini_set('display_error', '0');

require_once('config.php');
$thispage	= basename($_SERVER['PHP_SELF']);

if (@file_exists('config.php') == FALSE): echo '<p>Configuration file missing</p>';
else:

if(!isset($_SESSION['enrico-blog']['user'])):
	if(isset($_POST['login-go'])):
		$user			= mysql_real_escape_string($_POST['username']);
		$password		= mysql_real_escape_string($_POST['password']);
		$passwordcript	= sha1(md5(sha1(md5($password))));
		$sql = "SELECT * FROM sn_users WHERE username = '$user' and password = '$passwordcript' and level ='admin'";
		
		if($ris = mysql_query($sql))
		{
			if(mysql_num_rows($ris) == 1)
			{
				$array 													= mysql_fetch_array($ris);
				$_SESSION['enrico-blog']['user']['password_no_cript']	= $password;
				$_SESSION['enrico-blog']['user']['password_cript']		= $array['password'];
				$_SESSION['enrico-blog']['user']['username'] 			= $array['username'];
				$_SESSION['enrico-blog']['user']['email'] 				= $array['email'];
				$_SESSION['enrico-blog']['user']['newsletter'] 			= $array['newsletter'];
				$_SESSION['enrico-blog']['user']['level'] 				= $array['level'];
				$_SESSION['enrico-blog']['user']['id'] 					= $array['id'];
				$_SESSION['enrico-blog']['user']['avatar']				= $array['avatar'];
				
				$error		= FALSE;
				$message[0]	= 'Login effettuato con successo, attendi mentre vieni reindirizzato alla home.';
				echo '<meta http-equiv="refresh" content="0;url='.$config['row']['site_url'].'" />';
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
		
		foreach($message as $value) : echo '<p>'.$value .'</p>'; endforeach;
		
	endif;
	
	/** MOSTRO IL FORM LOGIN **/
	echo '<form method="post" action="' .$thispage .'" >';
	echo stripslashes($config['template']['login']);
	echo '</form>';

else:
	echo '<meta http-equiv="refresh" content="0;url='.$config['row']['site_url'].'" />';	
endif;

/** CHIUDO IL CHECK PER IL FILE DI CONFIGURAZIONE **/
endif;
?>
