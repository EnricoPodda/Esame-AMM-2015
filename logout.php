<?

error_reporting (0); 
ini_set('display_error', '0');

require_once('config.php');
$thispage	= basename($_SERVER['PHP_SELF']);

if (@file_exists('config.php') == FALSE)
	exit('<p>Configuration file missing</p>');

session_destroy();
header('Location: index.php'); 

?>
