<?

error_reporting (0); 
ini_set('display_error', '0');

require_once('config.php');
$thispage	= basename($_SERVER['PHP_SELF']);

if (@file_exists('config.php') == FALSE): echo '<p>Configuration file missing</p>';
else:

session_destroy();
echo '<meta http-equiv="refresh" content="0;url='.$config['row']['site_url'].'" />';
/** CHIUDO IL CHECK PER IL FILE DI CONFIGURAZIONE **/
endif;
?>
