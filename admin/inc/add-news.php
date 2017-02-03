<? 
if(isset($_SESSION['enrico-blog']['user'])):
$sql_category 		= "SELECT id, name FROM category";
$run_sql_category	= mysql_query($sql_category, $config['conn']);

if(isset($_POST['insert-news'])):
	
	$title		= change_dangerous_characters($_POST['title']);
	$url_title	= generate_url_title($title);
	
	$category	= change_dangerous_characters($_POST['category']);
	$text		= change_dangerous_characters($_POST['text']);; 
	$date_now 	= date("y-m-d");
	$time_now 	= date('H:i:s', time());
	$author		= $_SESSION['enrico-blog']['user']['username'];
	
	$message 	= array();
	$error		= FALSE;
	
	$sql_insert =  "INSERT INTO news (title, date, time, text, id_category, author, url_title) 
					VALUES ('$title', '$date_now', '$time_now', '$text', $category, '$author', '$url_title')";
	
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
		if(mysql_query($sql_insert))
		{
			header('Location: index.php?page=show-news&&pagination=1', 'refresh');			
		}
	}

endif; // if(isset($_POST['insert-news'])):

?>

<? include ('layout/header.inc.php'); ?>

<div class="container">
             
    <?php include('inc/lateral-menu.php');?>
    
		<div class="colonna-destra">
        
            <form class="form-horizontal" action='index.php?page=add-news' method='POST'>
            
              <fieldset>
                <legend>Aggiungi una news</legend>
                
                <?  if(isset($_POST['insert-news']) && $error == TRUE):
						echo '<div class="alert-error">';
						foreach($message as $value) : echo '<p>'.$value .'</p>'; endforeach;
						echo '</div>';
					endif;
				?>
                
                <div class="control-group  <? if(isset($message[0])) echo 'error';?>">
                	<label class="control-label" for="category">Inserisci il titolo</label>
                        <div class="controls">
                            <input class="span12" type="text" name="title" autocomplete="off" maxlenght="125" value="<? if(isset($title)) echo $title;?>">
                        </div>
                </div>
                
                <div class="control-group">
                	<label class="control-label" for="category">Scegli una categoria</label>
                        <div class="controls">
                            <select class="span12" name="category">
                            	
                            	<option value="0">Nessuna</option>  
                            
                            <? if(!isset($_POST['category'])): ?>                             
								<? 	while($row_category = mysql_fetch_array($run_sql_category)): ?>
                                    <option value="<?=$row_category['id'];?>"><?=$row_category['name'];?></option>
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
                            <textarea id="text" name="text" rows="20" cols="90"><? if(isset($text)) echo $text;?></textarea>
                        </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn" name="insert-news">Inserisci!</button>
                </div>
                                
              </fieldset>
            </form>
		</div> <!-- ./ colonna-destra -->

</div> <!-- ./ container -->
   

<? include ('layout/footer.inc.php'); ?>

<? else: header('Location: index.php?page=home'); endif; ?>                        