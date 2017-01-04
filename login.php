<?

error_reporting (0); 
ini_set('display_error', '0');

require_once('config.php');
$thispage	= basename($_SERVER['PHP_SELF']);

if (@file_exists('config.php') == FALSE)
	exit('<p>Configuration file missing</p>');

if(!isset($_SESSION['enrico-blog']['user'])):
	if(isset($_POST['login-go'])):
		$user			= mysql_real_escape_string($_POST['username']);
		$password		= mysql_real_escape_string($_POST['password']);
		$passwordcript	= sha1(md5(sha1(md5($password))));
		$sql = "SELECT * FROM users WHERE username = '$user' and password = '$passwordcript'";
		
		$error		= FALSE;

		if($ris = mysql_query($sql))
		{
			if(mysql_num_rows($ris) == 1)
			{
				$array 													= mysql_fetch_array($ris);
				$_SESSION['enrico-blog']['user']['password_no_cript']	= $password;
				$_SESSION['enrico-blog']['user']['password_cript']		= $array['password'];
				$_SESSION['enrico-blog']['user']['username'] 			= $array['username'];
				$_SESSION['enrico-blog']['user']['email'] 				= $array['email'];
				$_SESSION['enrico-blog']['user']['level'] 				= $array['level'];
				$_SESSION['enrico-blog']['user']['id'] 					= $array['id'];
				
				header('Location: index.php');
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
	<? include('inc/header.php'); ?>
	<div class="container"> 
		    <div class="colonna-destra">
		    	<h1> Effettua il login </h1>

		    		<?
		    			if($error){
		    				foreach($message as $value) 
		    					echo '<div class="alert-error"> <p>'.$value .'</p> </div>'; 
		    			}
		    		?>

		    		<form method="post" action="<?=$thispage;?>">
			    		<fieldset>
	    						<legend>Effettua il login:</legend>
	    						<p> Username </p>
		    					<input type="text" name="username" />
		    					<p>Password </p>
		    					<input type="password" name="password" />
		    					<p></p>
		    					<input type="submit" name="login-go" />
		    				</fieldset>
		    		</form>
		    </div>
		</div>  <!-- ./ container --> 

<?
else:
	echo '<meta http-equiv="refresh" content="0;url='.$config['row']['site_url'].'" />';	
endif;

?>
