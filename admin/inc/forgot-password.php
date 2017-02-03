<? if(!isset($_SESSION['enrico-blog']['user'])):

	if(isset($_POST['restore'])):
	
	$email			= mysql_real_escape_string($_POST['email']);
	
	if(trim($email) == '')
	{
		$error		= TRUE;
		$message[0]	= 'Non hai inserito nessuna email, ricontrolla.' ;
	}
	else
	{
		$sql = "SELECT email FROM users WHERE email = '$email'";
		$error			= array();
		
		if($ris = mysql_query($sql))
		{
			if(mysql_num_rows($ris) == 1)
			{
	
				$newpass	= generate_new_password();
				
				
				$header 	= 	"To:". $config['row']['site_name'] ."<".$config['row']['site_email'].">\n";
				$header 	.= 	"From: $email <$email>\n";
				$header 	.=  "MIME-Version: 1.0\n";
				$header 	.=  "Content-Type: text/html; charset=\"utf-8\" \n";
				$header 	.=  "Content-Transfer-Encoding: 7bit\n\n";
				$oggetto 	= 	"Ripristino password per " .$config['row']['cms_name'];
				$text 		= 	'<html><body>';
				$text		.= '<p>La tua nuova password è '. $newpass .'</p> ';
				$text		.= 	'</body></html>';
				
				if(mail("$email",$oggetto,$text,$header))
				{
					$error		= FALSE;
					$message[1]	= 'Abbiamo inviato alla tua email la nuova password, controlla la tua casella di posta.';
				}
				else
				{
					$error		= TRUE;
					$message[1]	= 'Email non inviata per problemi interni al server mail. Riprova più tardi.' ;
				}
			}
			else
			{
				$error		= TRUE;
				$message[2]	= 'Non esiste nessuna email registrata corrispondente a: ' .$email;
			}
		}
		else
		{
			$error		= TRUE;
			$message[2]	= 'Non &egrave; stato possibile effettuare il recupero password per problemi interni al server. Riprova pi&ugrave; tardi.';	
		}
	}
endif;

?>

<? include ('layout/header.inc.php'); ?>

<div class="container">
    
		<div class="colonna-destra">

			<form class="form-horizontal" action='index.php?page=forgot-password' method='POST'>           
				<fieldset>
				<legend>Recupero password</legend>
				
                <?  if(isset($_POST['restore']) && $error == TRUE):
						echo '<div class="alert-error">';
						foreach($message as $value) : echo '<p>'.$value .'</p>'; endforeach;
						echo '</div>';
					endif;
				?>                
                
				<div class="control-group">
					<label class="control-label" for="email">La tua email</label>
						<div class="controls">
							<input type="text" class="input-xlarge" name="email" autocomplete="off"  maxlength="255" />
						</div>
				</div>
								
				<div class="form-actions">
					<button type="submit" class="btn" name="restore">Invia</button>
				</div>
				 
								
			  </fieldset>
			</form>

        
		</div>
        
	</div>
        
</div>	
    
<? else: header('Location: index.php?page=home'); endif; ?>            