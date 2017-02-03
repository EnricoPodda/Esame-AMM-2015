<? 
if(isset($_SESSION['enrico-blog']['user'])):

if(!$_GET['pagination'])header('Location: index.php?page=add-category&&pagination=1');

$sql_category 		= 'SELECT id, name FROM category WHERE id != 0 LIMIT '. (($_GET['pagination']*10)-10) .',10';
$run_sql_category	= mysql_query($sql_category, $config['conn']);
$run_category_rows	= mysql_query('SELECT * FROM category WHERE id != 0');
$exist_category		= mysql_num_rows($run_category_rows);
$pagination			= ceil($exist_category/10);

if($exist_category != 0 ) :
	if($_GET['pagination'] > $pagination )header('Location: index.php?page=add-category&&pagination=1', "refresh");
endif;

if(isset($_POST['insert-category'])):
	
	$title		= change_dangerous_characters_html($_POST['title']);
	$url_title	= generate_url_title($title);
	$icon		= change_dangerous_characters_html($_POST['icon']);
		
	$message 	= array();
	$error		= FALSE;
	
	$sql_insert =  "INSERT INTO category (name, url_name) 
					VALUES ('$title', '$url_title')";
					
	if(strlen($title) < 2)
	{
		$error 		= TRUE;
		$message[0]	='Non puoi inserire un nome categoria così breve, inserisci almeno due caratteri !';
	}
	
	if(!$error)
	{
		if(mysql_query($sql_insert))
		{
			$error 		= FALSE;
			$message[2] = 'Categoria inserita con successo.';
			header("Location: index.php?page=add-category&&pagination=1", "refresh");
		}
		else
		{
			$error 		= TRUE;
			$message[2] = 'La categoria non è stata inserita per problemi interni al software.';
		}
		
	}
endif;
	
if(isset($_POST['delete-group-category'])):
	$arrayid	= array();
	$arrayid	= isset($_POST['category']) ?  $_POST['category'] : NULL;
	
	if(!$arrayid)
	{	
		$error 		= TRUE;
		$message[3]	= 'Non hai selezionato nessuna categoria da eliminare';
	}
	else
	{	
		$delete		= 0;
		foreach($arrayid as $value):
			$sql 		= "DELETE FROM category WHERE id=$value";
			$run 		= mysql_query ($sql, $config['conn']);
			$sq_update	= "UPDATE news SET id_category=0 WHERE id_category=$value";
			$run_update	= mysql_query ($sq_update, $config['conn']);

			$delete ++; 
		endforeach;
		$error 		= FALSE;
		header("Location: index.php?page=add-category&&pagination=1", "refresh");
	}
endif;
?>

<? include ('layout/header.inc.php'); ?>
<div class="container">

	<?php include('inc/lateral-menu.php');?>
    
		<div class="colonna-destra">
        
            <form class="form-horizontal" action='index.php?page=add-category&&pagination=1' method='POST'>
            
              <fieldset>
                <legend>Aggiungi una cagegoria</legend>
                
                <?  if(isset($_POST['insert-category']) && $error == TRUE):
						echo '<div class="alert-error">';
						foreach($message as $value) : echo '<p>'.$value .'</p>'; endforeach;
						echo '</div>';
					endif;
				?>
                
                <div class="control-group  <? if(isset($message[0])) echo 'error';?>">
                	<label class="control-label" for="category">Inserisci il nome</label>
                        <div class="controls">
                            <input class="span12" type="text" name="title" autocomplete="off" maxlength="125" value="<? if(isset($title)) echo stripslashes($title);?>">
                        </div>
                </div>
                
                <br> 
                
                <div class="form-actions">
                    <button type="submit" class="btn" name="insert-category">Inserisci!</button>
                </div>
                                
              </fieldset>
            </form>
            
            <? if($exist_category > 0 ):?>
            <hr />
            <form action='index.php?page=add-category&&pagination=1' method='POST'>
            <?  if(isset($_POST['delete-group-category']) && $error == TRUE):
					echo '<div class="alert-error">';
					foreach($message as $value) : echo '<p>'.$value .'</p>'; endforeach;
					echo '</div>';
				endif;
			?>
                        
            <? if(!isset($_POST['delete-group-category']) && !isset($_POST['single-delete'])): ?>
            <? endif; ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Nome</th>
                    </tr>
                </thead>
                
                <tbody> 
                
                <? while($row_category = mysql_fetch_array($run_sql_category)): 
						echo '<tr>';
							echo '<td><input type="checkbox" name="category[]" value="'.$row_category['id'] .'"  /></td>';
							echo '<td>' .$row_category['id'] .'</td>';
							echo '<td>' .$row_category['name'] .'</td>';
						echo '</tr>';
            		endwhile; ?>
                    
                </tbody>
            </table>
            <?
            if($pagination > 1)
			{
				echo'<div class="pagination"><ul>';
					echo'<li><a href="index.php?page=add-category&&pagination=1">«</a> </li>';
					for($i=2; $i<$pagination; $i++)
					{
						echo'<li> <a href="index.php?page=add-category&&pagination='.$i.'">'.$i.'</a> </li>';
					}
					echo'<li> <a href="index.php?page=add-category&&pagination=' .$pagination.'">»</a> </li>';	 
				echo '</ul></div>';
			}
			?>
            <div class="form-actions">
                <input type="submit" class="btn" name="delete-group-category" value="Cancella selezionati!" />
            </div>
                
            </form>
            <? endif; ?>
		</div>
        
	</div>
        
</div> 
<? include ('layout/footer.inc.php'); ?>
   
<? else: header('Location: index.php?page=home'); endif; ?>                        