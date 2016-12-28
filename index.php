<?
error_reporting (0); 
ini_set('display_error', '0');

require_once('config.php');
$thispage	= basename($_SERVER['PHP_SELF']);

if (@file_exists('config.php') == FALSE): echo '<p>Configuration file missing</p>';
else:

/**
	MOSTRO UNA NEWS IN PARTICOLARE, TRAMITE PARAMETRO GET
**/

if(isset($_GET['news']))
{
	$id_news			= $_GET['news'];
	$title_news			= $_GET['title'];
	
	$sql_news			= "SELECT * FROM sn_news WHERE id = $id_news AND url_title = '$title_news'";
	$run_sql_news		= mysql_query($sql_news, $config['conn']);
	
	$count_exist_news	= mysql_num_rows($run_sql_news);
	
	if($count_exist_news != 1 ) : echo '<meta http-equiv="refresh" content="0;url='.$thispage.'" />';
	
	else:
				
		if(isset($_POST['comment-go'])):
			$date_now 	= date("y-m-d");
			$time_now 	= date('H:i:s', time());
			$user		= $_SESSION['enrico-blog']['user']['id'];
			$comment	= mysql_real_escape_string($_POST['comment']);
			$news		= $_GET['news'];
			
			$sql_insert_comment	= "INSERT INTO sn_comment (date, time, text, id_news, id_user) VALUES ('$date_now', '$time_now', '$comment', $news, $user);";
			
			if(mysql_query($sql_insert_comment, $config['conn']))
			{
				$error		= FALSE;
				$message[0]	= 'Commento inserito con successo';
				echo '<meta http-equiv="refresh" content="0;url='.$thispage .'?news='.$_GET['news'].'&&title='.$_GET['title'].'" />';	
			}
			else
			{
				$error		= FALSE;
				$message[0]	= 'Commento non inserito per problemi interni al sito. Riprova più tardi. ' ;	
			}
			
			foreach($message as $value) : echo '<p>'.$value .'</p>'; endforeach;
		endif;
		
		
		while($array_news = mysql_fetch_array($run_sql_news)):
		
			$comment_sql		= "SELECT * FROM sn_comment, sn_users WHERE id_news =".$array_news['id'] ." AND id_user = sn_users.id";
			$run_comment_sql	= mysql_query($comment_sql, $config['conn']);
			$count_comment		= mysql_num_rows($run_comment_sql);
			
			if($array_news['id_category'] != 0)
			{
				$category_sql		= "SELECT name, avatar_url FROM sn_category WHERE id=".$array_news['id_category'];
				$run_category_sql	= mysql_query($category_sql, $config['conn']);
				$category_info		= mysql_fetch_array($run_category_sql);
			}
			else
			{
				$category_info['name']			= 'Nessuna';
				$category_info['avatar_url']	= '-';
			}
			
			$avatar_sql			= "SELECT avatar FROM sn_users WHERE username = '" .$array_news['author'] ."'";
			$run_avatar_sql		= mysql_query($avatar_sql, $config['conn']);
			$avatar_array		= mysql_fetch_array($run_avatar_sql);
			
			$full_link_news		= '<a href="'.$thispage.'?news='.$array_news['id'] .'" title="'.$array_news['title'].'">';
			
				
			$characters_news 		= array("{title}",
										"{date}",
										"{time}",
										"{author}",
										"{full-news}",
										"[full-link]",
										"[/full-link]",
										"{comments-num}",
										"{category}",
										"{category-icon}",
										'[',
										"]",
										"{avatar}"
										); 
										
			$change_news  			= array($array_news['title'],
										$array_news['date'],
										$array_news['time'],
										$array_news['author'],
										$array_news['text'],
										$full_link_news,
										'</a>',
										$count_comment[0],
										$category_info['name'],
										$category_info['avatar_url'],
										'<',
										'>',
										$avatar_array[0]
										); 
		
			$news				= str_replace($characters_news, $change_news, $config['template']['full_news']);
			
			echo stripslashes($news);
					
		endwhile;
	
		if($count_comment != 0) 
		{
			while($array_comment = mysql_fetch_array($run_comment_sql)):
			
				$characters_comment 		= array("{user}",
													"{full-comment}",
													"{mail}",
													"{date}",
													"{time}",
													); 
										
				$change_comment 			= array($array_comment['username'],
													stripslashes($array_comment['text']),
													$array_comment['email'],
													$array_comment['date'],
													$array_comment['time'],
													); 
		
			$comment				= str_replace($characters_comment, $change_comment, $config['template']['show_comment']);
			
			echo $comment;
			
			endwhile;	
			
		}
		
		
		if($config['row']['can_users_comment_news'] == TRUE && isset($_SESSION['enrico-blog']['user'])):
		
			$characters_insert_comment 		= array('[',
													"]",
													); 
										
			$change_insert_comment  			= array('<',
														'>'
														); 
			$insertcomment				= str_replace($characters_insert_comment, $change_insert_comment, $config['template']['insert_comment']);
			/** MOSTRO IL FORM PER INSERIRE I COMMENTI **/
			echo '<form method="post" action="' .$thispage .'?news='.$_GET['news'].'&&title='.$_GET['title'].'" >';
			echo stripslashes($insertcomment);
			echo '</form>';
		endif;
		
	endif;
	
}

/**
	MOSTRO LE NEWS NELLA PAGINA A CASCATA
**/

else
{
	$sql_tot_news		= "SELECT * FROM sn_news";
	$run_tot_news		= mysql_query($sql_tot_news);
	$thisget			= isset($_GET['page']) ? $_GET['page'] : 1;
	
	if(!isset($_GET['page']) || $_GET['page'] == 1)
	{
		$sql_news		= "SELECT * FROM sn_news ORDER BY id ".$config['row']['order_news'] ." LIMIT ".$config['row']['news_per_page'];
		$run_sql_news	= mysql_query($sql_news, $config['conn']);
	}
	else
	{
		// LIMIT numero_inizio, numero_fine
		$num_inizio		= (($_GET['page'] * $config['row']['news_per_page']) - $config['row']['news_per_page']);
		$num_fine		= $config['row']['news_per_page'];
		
		$sql_news		= "SELECT * FROM sn_news  ORDER BY id ".$config['row']['order_news']." LIMIT $num_inizio, $num_fine";
		$run_sql_news	= mysql_query($sql_news, $config['conn']);	
	}
	
	$exist_news			= mysql_num_rows($run_tot_news);
	if($exist_news > 0) $tot_page			= ceil($exist_news/$config['row']['news_per_page']);

	if($exist_news != 0 ) 
	{
		if($thisget > $tot_page ) echo '<meta http-equiv="refresh" content="1;url='.$thispage.'" />';

		else 
		{
	
		
			while($array_news = mysql_fetch_array($run_sql_news)):
				//echo $sql_news;
				$count_comment_sql	= "SELECT COUNT(*) FROM sn_comment WHERE id_news =".$array_news['id'];
				$run_comment_sql	= mysql_query($count_comment_sql, $config['conn']);
				$count_comment		= mysql_fetch_array($run_comment_sql);
				
				if($array_news['id_category'] != 0)
				{
					$category_sql		= "SELECT name, avatar_url FROM sn_category WHERE id=".$array_news['id_category'];
					$run_category_sql	= mysql_query($category_sql, $config['conn']);
					$category_info		= mysql_fetch_array($run_category_sql);
				}
				else
				{
					$category_info['name']			= '-';
					$category_info['avatar_url']	= '-';
				}
				
				$avatar_sql			= "SELECT avatar FROM sn_users WHERE username = '" .$array_news['author'] ."'";
				$run_avatar_sql		= mysql_query($avatar_sql, $config['conn']);
				$avatar_array		= mysql_fetch_array($run_avatar_sql);
				
				$full_link_news		= '<a href="'.$thispage.'?news='.$array_news['id'] .'&&title='.$array_news['url_title'].'" title="'.$array_news['title'].'">';
				
				

				if( strlen($array_news['text']) > $config['row']['length_short_story']) 
				{
					$array_news['text']	= substr($array_news['text'], 0, $config['row']['length_short_story']);
					$array_news['text'] .= '...';
				}
				else
				{				
					$array_news['text']	= substr($array_news['text'], 0, $config['row']['length_short_story']);
				}

				$characters_news 		= array("{title}",
											"{date}",
											"{time}",
											"{author}",
											"{full-news}",
											"[full-link]",
											"[/full-link]",
											"{comments-num}",
											"{category}",
											"{category-icon}",
											"{avatar}"
											); 
											
				$change_news 			= array($array_news['title'],
											$array_news['date'],
											$array_news['time'],
											$array_news['author'],
											$array_news['text'],
											$full_link_news,
											'</a>',
											$count_comment[0],
											$category_info['name'],
											$category_info['avatar_url'],
											$avatar_array[0]
											); 
			
				$news				= str_replace($characters_news, $change_news, $config['template']['short_news']);
				
				echo stripslashes($news);

			endwhile;
			
			if($tot_page > 1)
			{
				echo'<a href="'.$thispage.'?page=1">'.$config['template']['first_news'].'</a> - ';
				for($i=2; $i<$tot_page; $i++)
				{
					echo'<a href="'.$thispage.'?page='.$i.'">'.$i.'</a> - ';
				}
				echo'<a href="'.$thispage.'?page=' .$tot_page.'">'.$config['template']['last_news'].'</a>';	 
			}
		}		
	}
}

/** CHIUDO IL CHECK PER IL FILE DI CONFIGURAZIONE **/
endif;
?>
