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
	
	$sql_news		= "SELECT * FROM news LEFT JOIN category ON news.id_category = category.id ORDER BY news.id DESC";
	$run_sql_news	= mysql_query($sql_news, $config['conn']);
	
	// controllo se ci sono news
	$exist_news			= mysql_num_rows($run_tot_news);
	
	
	include('inc/header.php');
	?>

	<div class="container"> 
		<div class="colonna-destra">

  			<? if(isset($_SESSION['enrico-blog']['user'])): ?>

				<? while($array_news = mysql_fetch_array($run_sql_news)): ?>
			
		    	<h1> <?= $array_news['title'];?> </h1>
		    	<h5> Scritta in data <?=$array_news['date'];?> alle ore <?=$array_news['time'];?> da: <?=$array_news['author'];?> - Categoria: <?=$array_news['name'] ? $array_news['name'] : "Nessuna"; ?> </h5>

		    	<?=$array_news['text'];?>
		    	<hr>
		    	<? endwhile; ?>
		    <? else: ?>
		    	<h1> Benvenuto nel Blog di Enrico! </h1>
		    	<p> Questo sito si occupa di mostrare tutte le news che Enrico (ed ogni altro amministratore da lui aggiunto) scriverà sui suoi interessi. </p>
		    	<p> Qualsiasi utente normale potrà leggere queste news, ma solo questo. </p>
		    	<p> Effettua quindi l'accesso per poter leggere le news! </p>
		    	<p> Account disponibili: </p>
		  		<p> Amministratore:				<b>Enrico</b> </p>
		  		<p> Utente:						<b>Gino</b> </p>
		  		<p> Password (per entrambi):	<b>123456789</b> </p>
		  		<b> Funzioni dell'utente </b>
		  		<ul>
		  		<li> Vedere le news </li>
		  		</ul>
		  		<b> Funzioni dell'amministratore </b>
		  		<ul>
		  		<li> Vedere le news </li>
		  		<li> Aggiungere news</li>
		  		<li> Modificare news</li>
		  		<li> Gestire categorie</li>
		  		<li> Gestire utenti</li>
		  		<li> Registrare un amministratore</li>
		  		</ul>
		  		<p> Chiaramente, chiunque non possedesse già un account può registrarsi con uno nuovo come utente. </p>
		  		<b>Requisiti sodisfatti</b>
		  		<ul>
		  		<li> Utilizzo di HTML e CSS </li>
		  		<li> Utilizzo di PHP e MySQL </li>
		  		<li> Ruoli distinti: Amministratore e Utente </li>
		  		<li> Transazione in admin/inc/show-news.php, righe 29-43</li>
		  		</ul>

			<? endif; ?>
	    </div>
	</div>  <!-- ./ container --> 						

	
			
<? include('inc/header.php'); ?>