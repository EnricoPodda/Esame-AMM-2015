<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title> Enrico Blog </title>
    <link rel="stylesheet" type="text/css" href="css/global.css" />
	<script type="text/javascript" src="js/jquery-1.8.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
    
</head>

<body>
<div class="top-bar">
     
    <div class="menu-left">
    	<a href="index.php?page=home"> Home page</a>
    </div>

    <? if(isset($_SESSION['enrico-blog']['admin'])): ?>
    <div class="menu-right">
	    <a href="index.php?page=edit-profile&&username<?= $_SESSION['enrico-blog']['admin']['username'];?>">Modifica profilo</a>
	    <a href="index.php?page=logout">Logout</a></li>

	</div>
	<? else: ?>
		<div class="menu-right">
			<a href="index.php?page=login">Login</a>
		</div>
	<? endif; ?>
</div> <!-- ./ top-bar -->
