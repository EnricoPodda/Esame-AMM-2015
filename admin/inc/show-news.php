<? 
if(isset($_SESSION['enrico-blog']['admin'])):

if(!$_GET['pagination'])header('Location: index.php?page=show-news&&pagination=1');

$sql_news 			= 'SELECT * FROM sn_news  ORDER BY id DESC LIMIT '.  (($_GET['pagination']*10)-10) .',10';
$run_sql_news		= mysql_query($sql_news, $config['conn']);
$run_news_rows		= mysql_query('SELECT * FROM sn_news');
$exist_news			= mysql_num_rows($run_news_rows);
$pagination			= ceil($exist_news/10);

if($exist_news != 0 ) :
	if($_GET['pagination'] > $pagination )header('Location: index.php?page=show-news&&pagination=1');
endif;

if(isset($_POST['delete-group-news'])):
	
	$arrayid	= array();
	$arrayid	= isset($_POST['news']) ?  $_POST['news'] : NULL;
	
	if(!$arrayid)
	{	
		$error 		= TRUE;
		$message[3]	= 'Non hai selezionato nessuna news da eliminare';
	}
	else
	{	
		$delete		= 0;
		foreach($arrayid as $value):
			$sql = "DELETE FROM sn_news WHERE id=$value";
			$run = mysql_query ($sql, $config['conn']);
			$delete ++; 
		endforeach;
		
		header("Location: index.php?page=show-news", "refresh");
	}

endif;
?>

<? include ('layout/header.inc.php'); ?>
<div class="container">

	<?php include('inc/lateral-menu.php');?>
    
		<div class="colonna-destra">
			<? if($exist_news > 0 ):?>        

        	<form method="post" action="index.php?page=show-news&&pagination=1">
        	<legend>Elenco news</legend>

            <?  if(isset($_POST['delete-group-news']) && $error == TRUE):
					echo '<div class="alert alert-error">';
					foreach($message as $value) : echo '<p>'.$value .'</p>'; endforeach;
					echo '</div>';
				endif;
			?> 
              
			<table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Titolo</th>
                        <th>Autore</th>
                        <th>Creata il</th>
                        <th>Commenti</th>
                        <th></th>
                    </tr>
                </thead>
                
                <tbody> 
                
                <? while($row_news = mysql_fetch_array($run_sql_news)):
					$sql_comment 		= "SELECT count(*) FROM sn_comment WHERE id_news =". $row_news['id'];
					$run_sql_comment 	= mysql_query($sql_comment, $config['conn']);
					$comment			= mysql_fetch_array($run_sql_comment);
						echo '<tr>';
							echo '<td><input type="checkbox" name="news[]" value="'.$row_news['id'] .'"  /></td>';
							echo '<td>' .$row_news['id'] .'</td>';
							echo '<td>' .$row_news['title'] .'</td>';
							echo '<td>' .$row_news['author'] .'</td>';
							echo '<td>' .$row_news['date'] .' '.$row_news['time'] .'</td>';
							echo '<td>' .$comment[0].'</td>';
							echo '<td>
										<a class="btn" href="index.php?page=edit-news&&value='.$row_news['id'] .'">Modifica</a></td>

									</td>';
						echo '</tr>';
            		endwhile; ?>
                    
                </tbody>
            </table>
            <?
            if($pagination > 1)
			{
				echo'<div class="pagination"><ul>';
					echo'<li><a href="index.php?page=show-news&&pagination=1">«</a> </li>';
					for($i=2; $i<$pagination; $i++)
					{
						echo'<li> <a href="index.php?page=show-news&&pagination='.$i.'">'.$i.'</a> </li>';
					}
					echo'<li> <a href="index.php?page=show-news&&pagination=' .$pagination.'">»</a> </li>';	 
				echo '</ul></div>';
			}
			?>
			<div class="form-actions">
                <input type="submit" class="btn" name="delete-group-news" value="Cancella selezionati!" />
            </div>
            </form> 
            <? else: ?>
            <div class="alert alert-error">Non sono state ancora inserite delle news </div>
            <? endif; ?>                   
		</div>
        
	</div>
        
</div>    
<? include ('layout/footer.inc.php'); ?>

<? else: header('Location: index.php?page=home'); endif; ?>                        