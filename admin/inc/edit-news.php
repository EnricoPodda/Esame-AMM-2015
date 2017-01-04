<? 
if(isset($_SESSION['enrico-blog']['admin'])):

if(!$_GET['value']) header('Location: index.php?page=show-news');

$value				= $_GET['value'];

$sql_category 		= "SELECT id, name FROM category";
$run_sql_category	= mysql_query($sql_category, $config['conn']);

$sql_news			= "SELECT id, title, text, id_category FROM news WHERE id = $value";
$run_sql_news		= mysql_query($sql_news, $config['conn']);
$row_news			= mysql_fetch_array($run_sql_news);

if(isset($_POST['update-news'])):

	$title		= change_dangerous_characters($_POST['title']);
	$category	= change_dangerous_characters($_POST['category']);
	$text		= change_dangerous_characters($_POST['text']);

	
	$message 	= array();
	$error		= FALSE;
	
	$sql_update =  "UPDATE news
					SET title='$title', id_category=$category, text = '$text'
					WHERE id=$value";
					
	if(strlen($title) < 2)
	{
		$error 		= TRUE;
		$message[0]	='Il titolo deve essere di almeno 2 caratteri!';
	}
	
	elseif(strlen($title)>125)
	{
		$error 		= TRUE;
		$message[0] = 'Il nome utente deve essere di massimo 125 caratteri!';
	}
	
	if(strlen($text) == 0)
	{
		$error 		= TRUE;
		$message[1] = 'Non puoi inserire una news senza un testo.';
	}
					
	
	if(!$error)
	{
		if(mysql_query($sql_update))
		{
			$error 		= FALSE;
			$message[2] = 'News modificata con successo';
			header("Location: index.php?page=show-news", "refresh");
		}
		else
		{
			$error 		= TRUE;
			$message[2] = 'La news non è stata inserita per problemi interni al software.';
		}
		
	}
endif;
?>

<? include ('layout/header.inc.php'); ?>
<div class="container">

	<?php include('inc/lateral-menu.php');?>
    
		<div class="colonna-destra">
        
            <form class="form-horizontal" action='index.php?page=edit-news&&value=<?=$value;?>' method='POST'>
            
              <fieldset>
                <legend>Modifica una news</legend>
                
                <?  if(isset($_POST['update-news']) && $error == TRUE):
						echo '<div class="ìalert-error">';
						foreach($message as $value) : echo '<p>'.$value .'</p>'; endforeach;
						echo '</div>';
					endif;
				?>
                
                <div class="control-group  <? if(isset($message[0])) echo 'error';?>">
                	<label class="control-label" for="category">Inserisci il titolo</label>
                        <div class="controls">
                            <input class="span12" type="text" name="title" autocomplete="off" maxlenght="125" 
                            value="<? if(isset($_POST['title'])) echo $title; else echo stripslashes($row_news['title']);?>">
                        </div>
                </div>
                
                <div class="control-group">
                	<label class="control-label" for="category">Scegli una categoria</label>
                        <div class="controls">
                            <select class="span12" name="category">
                            	
                            	<option value="0">Nessuna</option>  
                            <? if(!isset($_POST['category'])): ?>                             
								<? 	while($row_category = mysql_fetch_array($run_sql_category)): 
                                    if($row_category['id'] == $row_news['id_category']):
                                ?>
                                    <option value="<?=$row_category['id'];?>" selected="selected"><?=$row_category['name'];?></option>
                                    <? else: ?>
                                    <option value="<?=$row_category['id'];?>"><?=$row_category['name'];?></option>
                                    <? endif;?>
                                <? endwhile; ?>
                                
                            <? else : ?>
                            	<? 	while($row_category = mysql_fetch_array($run_sql_category)): 
                                    if($row_category['id'] == $_POST['category']):
                                ?>
                                    <option value="<?=$row_category['id'];?>" selected="selected"><?=$row_category['name'];?></option>
                                    <? else: ?>
                                    <option value="<?=$row_category['id'];?>"><?=$row_category['name'];?></option>
                                    <? endif;?>
                                <? endwhile; ?>
                            <? endif; ?>    
                            </select>
                        </div>
                </div>
                
                
                <div class="control-group">
                        <div class="controls">
                            <textarea id="text" name="text" rows="20"  cols="90"><? if(isset($_POST['text'])) echo $text; else echo stripslashes($row_news['text']);?></textarea>
                        </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn" name="update-news">Modifica!</button>
                </div>
                                
              </fieldset>
            </form>
		</div>
        
	</div>
        
</div>    
<? include ('layout/footer.inc.php'); ?>

<? else: header('Location: index.php?page=home'); endif; ?>                        