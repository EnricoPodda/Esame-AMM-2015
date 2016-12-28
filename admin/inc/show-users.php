<? 
if(isset($_SESSION['enrico-blog']['admin'])):

if(!$_GET['pagination'])header('Location: index.php?page=show-users&&pagination=1');

$sql_users 			= 'SELECT * FROM sn_users LIMIT '.  (($_GET['pagination']*10)-10) .',10';
$run_sql_users		= mysql_query($sql_users, $config['conn']);
$run_users_rows		= mysql_query('SELECT * FROM sn_users');
$exist_users		= mysql_num_rows($run_users_rows);
$pagination			= ceil($exist_users/10);

if($exist_users != 0 ) :
	if($_GET['pagination'] > $pagination )header('Location: index.php?page=show-users&&pagination=1');
endif;

if(isset($_POST['delete-group-users'])):
	
	$arrayid	= array();
	$arrayid	= isset($_POST['users']) ?  $_POST['users'] : NULL;
	
	if(!$arrayid)
	{	
		$error 		= TRUE;
		$message[3]	= 'Non hai selezionato nessun utente da eliminare';
	}
	else
	{	
		$delete		= 0;
		foreach($arrayid as $value):
			$sql_1 		= "DELETE FROM sn_users WHERE id=$value";
			$sql_2		= "DELETE FROM sn_comment WHERE id_user=$value";
			$run_1 		= mysql_query ($sql_1, $config['conn']);
			$run_2 		= mysql_query ($sql_2, $config['conn']);
			if($run_1 && $run_2)
			{
				$delete ++; 
			}
		endforeach;
		$error 		= FALSE;
		$message[3]	= 'Utenti eliminate: '.$delete;
		header("Location: index.php?page=show-users&&pagination=1", "refresh");
	}

endif;
?>

<? include ('layout/header.inc.php'); ?>
<div class="container">

	<?php include('inc/lateral-menu.php');?>
    
		<div class="colonna-destra">
        	
			<? if($exist_users > 0 ):?>        

        	<form method="post" action="index.php?page=show-users&&pagination=1">
        	<legend>Elenco utenti</legend>
            
            <?  if(isset($_POST['delete-group-users']) && $error == TRUE):
					echo '<div class="alert-error">';
					foreach($message as $value) : echo '<p>'.$value .'</p>'; endforeach;
					echo '</div>';
				endif;
			?> 
              
			<table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Newsletter</th>
                        <th>Grado</th>
                        <th></th>
                    </tr>
                </thead>
                
                <tbody> 
                
                <? while($row_users = mysql_fetch_array($run_sql_users)):
					$row_users['newsletter']= $row_users['newsletter'] == TRUE 	? '<span class="label label-success">Attivo</span>' 
																				: '<span class="label label-important">Disattivo</span>';
					$row_users['level']		= $row_users['level'] == 'admin' ? 'Amministratore'
																			 : 'Utente';
						echo '<tr>';
							if($row_users['id'] == 1 || $row_users['id'] == $_SESSION['enrico-blog']['admin']['id']) echo '<td><input type="checkbox" disabled="disabled"  /></td>';
							else echo '<td><input type="checkbox" name="users[]" value="'.$row_users['id'] .'"  /></td>';
							echo '<td>' .$row_users['username'] .'</td>';
							echo '<td>' .$row_users['email'] .'</td>';
							echo '<td>' .$row_users['newsletter'] .'</td>';
							echo '<td>' .$row_users['level'].'</td>';
							echo '<td>';
							echo'<a class="btn" href="index.php?page=edit-profile&&username='.$row_users['username'] .'">Modifica</a>
									</td>';
						echo '</tr>';
            		endwhile; ?>
                    
                </tbody>
            </table>
            <?
            if($pagination > 1)
			{
				echo'<div class="pagination"><ul>';
					echo'<li><a href="index.php?page=show-users&&pagination=1">«</a> </li>';
					for($i=2; $i<$pagination; $i++)
					{
						echo'<li> <a href="index.php?page=show-users&&pagination='.$i.'">'.$i.'</a> </li>';
					}
					echo'<li> <a href="index.php?page=show-users&&pagination=' .$pagination.'">»</a> </li>';	 
				echo '</ul></div>';
			}
			?>
			<div class="form-actions">
                <input type="submit" class="btn" name="delete-group-users" value="Cancella selezionati!" />
            </div>
            </form> 
            <? endif; ?>                   
		</div>
        
	</div>
        
</div>   
<? include ('layout/footer.inc.php'); ?>
 
<? else: header('Location: index.php?page=home'); endif; ?>                        