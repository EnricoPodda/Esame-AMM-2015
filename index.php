<?
error_reporting (0); 
ini_set('display_error', '0');

require_once('config.php');
$thispage	= basename($_SERVER['PHP_SELF']);

if (@file_exists('config.php') == FALSE)
	exit('<p>Configuration file missing</p>');


	$sql_tot_news		= "SELECT * FROM news";
	$run_tot_news		= mysql_query($sql_tot_news);
	$thisget			= isset($_GET['page']) ? $_GET['page'] : 1;
	
	$sql_news		= "SELECT * FROM news ORDER BY id DESC";
	$run_sql_news	= mysql_query($sql_news, $config['conn']);
	
	// controllo se ci sono news
	$exist_news			= mysql_num_rows($run_tot_news);
	
	
	include('inc/header.php');
	?>

	<div class="container"> 
		<div class="colonna-destra">

			<? while($array_news = mysql_fetch_array($run_sql_news)): ?>
	

	
	    	<h1> <?= $array_news['title'];?> </h1>
	    	<h5> Scritta in data <?=$array_news['date'];?> alle ore <?=$array_news['time'];?> da: <?=$array_news['author'];?></h5>

	    	<?=$array_news['text'];?>
	    	<hr>
	    	<? endwhile; ?>

	    </div>
	</div>  <!-- ./ container --> 						

	
			
<? include('inc/header.php'); ?>