<? if(isset($_SESSION['enrico-blog']['admin'])):?>
<? include ('layout/header.inc.php'); ?>

<div class="container">
             
    <?php include('inc/lateral-menu.php');?> 
    
    <div class="colonna-destra">
    	<h1> Benvenuto nel blog di Enrico!</h1>
    	<p> Questo è il mio sito! Principalmente si tratta di un blog, perciò ti sarà possibile scrivere ed modificare	 notizie e categorie.<br>In quanto amministratore hai pieni poteri, tutte le opzioni alla sinistra saranno disponibili solo a te o ad un'altro amministratore.</p>
    	<p> Che aspetti? incomincia a postare sul blog di Enrico!</p>
    </div>
</div>  <!-- ./ container -->  

<? include ('layout/footer.inc.php'); ?>

<? else: 

	header('Location: index.php?page=login');
	
endif; ?>            