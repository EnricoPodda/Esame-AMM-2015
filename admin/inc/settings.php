<? 
if(isset($_SESSION['enrico-blog']['admin'])):
	
	if(isset($_POST['save-settings']))
	{
		//if( is_numeric($myVar) )
		
		$length_short_story		= $_POST['length_short_story'];
		$comment				= $_POST['comment'];
		$news_per_page			= $_POST['news_per_page'];
		$order					= $_POST['order'];
		$site_name				= $_POST['site_name'];
		$site_email				= $_POST['site_email'];	
		
		$message 	= array();
		$error		= FALSE;

		$sql_insert =  "UPDATE sn_config SET length_short_story=$length_short_story, can_users_comment_news = $comment, news_per_page = $news_per_page, order_news = '$order', 
						site_name = '$site_name', site_email = '$site_email'";
						
		if(integer($length_short_story) == FALSE)
		{
			$error 		= TRUE;
			$message[0]	= 'La lunghezza dell\'anteprima delle news dev\'essere espressa tramite un numero intero';
		}
		
		if(integer($news_per_page) == FALSE)
		{
			$error 		= TRUE;
			$message[1]	= 'Il numero di news per pagina devono essere espresse con un numero intero.';
		}
		
		if(trim($site_name) == '')
		{
			$error 		= TRUE;
			$message[2]	= 'Il nome del tuo sito non può essere vuoto.';
		}
		
		if(trim($site_email) == '')
		{
			$error 		= TRUE;
			$message[3]	= 'L\'email del tuo sito non può essere vuota.';
		}
		elseif(!validatemail($site_email))
		{
			$error		= TRUE;
			$message[3]	= 'L\'email che hai inserito non è valida';
		}

		if(!$error)
		{
			if(mysql_query($sql_insert))
			{
				$error 		= FALSE;
				header("Location: index.php?page=settings", "refresh");
			}
			else
			{
				$error 		= TRUE;
				$message[4] = 'Le modifiche non sono state salvate per motivi interni al sito. <br>';
			}
			
	}
	}
?>

<? include ('layout/header.inc.php'); ?>
<div class="container">

	<?php include('inc/lateral-menu.php');?>
    
		<div class="colonna-destra">
        
		<form class="form-horizontal" action='index.php?page=settings' method='POST'>
            
            <fieldset>
            	<legend>Impostazioni <?=$config['row']['cms_name'];?></legend>
            	
                <?  if(isset($_POST['save-settings']) && $error == TRUE):
						echo '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>';
						foreach($message as $value) : echo '<p>'.$value .'</p>'; endforeach;
						echo '</div>';
					endif;
				?>
                
                <div class="control-group <? if(isset($message[0])) echo 'error';?>">
                    <label class="control-label" for="length_short_story">Anteprima news</label>
                        <div class="controls">
                            <input type="text" id="length_short_story" 
                            	value="<? if(isset($length_short_story)) echo $length_short_story; else echo $config['row']['length_short_story'];?>" 
                            name="length_short_story"  class="input-mini" autocomplete="off">
                            <p>Il numero di caratteri che comporrano l'anteprima news. I caratteri restanti verranno troncati e visualizzati sono nel link della news completa.</p>
                        </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label" for="comment">Commenti </label>
                        <div class="controls">
                            <select class="span1" name="comment">
                            	<? if(isset($_POST['save-settings'])): ?>
                                	<option value="1" <? if($comment == 1) echo 'selected="selected"';?> >Attivati</option>
                                    <option value="0" <? if($comment == 0) echo 'selected="selected"';?> >Disattivati</option>
                                <? else: ?>
                                    <option value="1" <? if($config['row']['can_users_comment_news'] == 1) echo 'selected="selected"';?> >Attivati</option>
                                    <option value="0" <? if($config['row']['can_users_comment_news'] == 0) echo 'selected="selected"';?> >Disattivati</option>
                                <? endif; ?>
                            </select>
                            <p>Desideri che gli utenti possano commentare le news ?</p>
                        </div>
                </div>
                
                <div class="control-group   <? if(isset($message[1])) echo 'error';?>">
                    <label class="control-label" for="news_per_page">News per pagina</label>
                        <div class="controls">
                            <input type="text" id="news_per_page" 
                            	value="<? if(isset($news_per_page)) echo $news_per_page; else echo $config['row']['news_per_page'];?>" 
                            name="news_per_page"  class="input-mini" autocomplete="off">
                            <p>Quante news vuoi visualizzare in ogni singola pagina ?</p>
                        </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label" for="order">Ordinamento </label>
                        <div class="controls">
                            <select class="span2" name="order">
								<? if(isset($_POST['save-settings'])): ?>
                                    <option value="ASC" <? if($order == 'ASC') echo 'selected="selected"';?> >Ascendente</option>
                                    <option value="DESC" <? if($order == 'DESC') echo 'selected="selected"';?>>Decrescente</option>
                                <? else: ?>
                                	<option value="ASC" <? if($config['row']['order_news'] == 'ASC') echo 'selected="selected"';?> >Ascendente</option>
                                    <option value="DESC" <? if($config['row']['order_news'] == 'DESC') echo 'selected="selected"';?>>Decrescente</option>
                                <? endif; ?>    
                            </select>
                            <p>Desideri che le news siano ordinate in modo crescente o decrescente ?</p>
                        </div>
                </div>
                
                <div class="control-group <? if(isset($message[0])) echo 'error';?>">
                    <label class="control-label" for="site_name">Nome del tuo sito</label>
                        <div class="controls">
                            <input type="text" id="site_name" 
                            	value="<? if(isset($site_name)) echo $site_name; else echo $config['row']['site_name'];?>" 
                            name="site_name"  class="span2" autocomplete="off">
                            <p>Il nome del tuo sito che servirà per identificare le email e le tue news.</p>
                        </div>
                </div>
                
                <div class="control-group <? if(isset($message[0])) echo 'error';?>">
                    <label class="control-label" for="site_email">Email del tuo sito</label>
                        <div class="controls">
                            <input type="text" id="site_email" 
                            	value="<? if(isset($site_email)) echo $site_email; else echo $config['row']['site_email'];?>" 
                            name="site_email"  class="span2" autocomplete="off">
                            <p>L'email del tuo sito che servirà per inviare le newsletter.</p>
                        </div>
                </div>
                
                <div class="control-group">
                        <div class="controls">
                            <input type="submit" name="save-settings" class="btn" value="Salva"/>
                        </div>
                </div>
         	</fieldset>   
        </form>
        
		</div>
        
	</div>
        
</div> 
<? include ('layout/footer.inc.php'); ?>
   
<? else: header('Location: index.php?page=home'); endif; ?>                        