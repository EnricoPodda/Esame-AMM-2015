<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title> Enrico Blog </title>
    <link rel="stylesheet" type="text/css" href="./admin/css/global.css" />
	<script type="text/javascript" src="./admin/js/jquery-1.8.min.js"></script>
	<script type="text/javascript" src="./admin/js/bootstrap.min.js"></script>
    
</head>

<body>
<div class="top-bar">
     
    <div class="menu-left">
    	<a href="index.php"> Home page</a>
    </div>

    <? if(isset($_SESSION['enrico-blog'])): ?>
    <div class="menu-right">
    	<b> Bentornato, <?= $_SESSION['enrico-blog']['user']['username'];?> </b>

    	<? if($_SESSION['enrico-blog']['user']['level'] == "admin"): ?>
	    	<a href="./admin/">Amministrazione</a></li>
	    <? endif; ?>

	    <a href="logout.php">Logout</a></li>
	</div>
	<? else: ?>
		<div class="menu-right">
			<a href="login.php">Login</a>
			<a href="registration.php">Registrati</a>
		</div>
	<? endif; ?>
</div> <!-- ./ top-bar -->