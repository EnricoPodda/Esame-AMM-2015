<? 
if(isset($_SESSION['enrico-blog']['admin'])):
$id					= $_GET['value'];
$sql_category 		= "SELECT id, name, avatar_url FROM sn_category WHERE id=$id";
$run_sql_category	= mysql_query($sql_category, $config['conn']);

if(isset($_POST['edit-category'])):

	$title		= change_dangerous_characters_html($_POST['title']);
	$url_title	= generate_url_title($title);
	$icon		= change_dangerous_characters_html($_POST['icon']);;
		
	$error = array();
	
	$sql_update =  "UPDATE sn_category
					SET name='$title', url_name='$url_title', avatar_url='$icon'
					WHERE id=$id";
					
	if(strlen($title) < 2)
	{
		$error 		= TRUE;
		$message[0]	='Non puoi inserire un nome categoria così breve, inserisci almeno due caratteri !';
	}
	
	if(count($error) == 0)
	{
		if(mysql_query($sql_update))
		{
			$error 		= FALSE;
			$message[2] = 'Categoria modificata con successo.';
			header("Location: index.php?page=add-category&&pagination=1", "refresh");
		}
		else
		{
			$error 		= TRUE;
			$message[2] = 'La categoria non è stata modificata per problemi interni al software.';
		}
		
	}
endif;
	
?>

<? include ('layout/header.inc.php'); ?>
<div class="container">

	<?php include('inc/lateral-menu.php');?>
    
		<div class="colonna-destra">
        
            <form class="form-horizontal" action='index.php?page=edit-category&&value=<?=$_GET['value'];?>' method='POST'>
            
              <fieldset>
                <legend>Modifica cagegoria</legend>
                
                <?  if(isset($_POST['edit-category']) && $error == TRUE):
						echo '<div class="alert-error">';
						foreach($message as $value) : echo '<p>'.$value .'</p>'; endforeach;
						echo '</div>';
					endif;
				?>
                
                <? while($row_category = mysql_fetch_array($run_sql_category)): ?>

            	
                <div class="control-group  <? if(isset($message[0])) echo 'error';?>">
                	<label class="control-label" for="category">Modifica il nome</label>
                        <div class="controls">
                            <input class="span12" type="text" name="title" autocomplete="off" maxlength="125" value="<?=$row_category['name'];?>">
                        </div>
                </div>
                
                <div class="control-group">
                	<label class="control-label" for="category">Url icona </label>
                        <div class="controls">
                            <input class="span12" type="text" name="icon" autocomplete="off" value="<?=$row_category['avatar_url'];?>">
                        </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn" name="edit-category">Modifica!</button>
                </div>
                
                <? endwhile; ?>
                                
              </fieldset>
            </form>
                        
		</div>
        
	</div>
        
</div>  
<? include ('layout/footer.inc.php'); ?>  
<? else: header('Location: index.php?page=home'); endif; ?>                        