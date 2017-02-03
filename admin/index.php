<?

error_reporting (0); 
ini_set('display_error', '0');
 
include('../config.php'); 
include('inc/function.inc.php');     
      
if($_SESSION['enrico-blog']['user']['level'] != "admin")
	header('Location: ../index.php');

if(!isset($_GET['page'])): 
	header('Location: index.php?page=home');
else:

switch($_GET['page']):


case 'home': 						include 'inc/home.php'; 									break;
case 'signup':	 					include 'inc/signup.php'; 									break;
case 'login': 						include 'inc/login.php';					 				break;
case 'forgot-password': 			include 'inc/forgot-password.php';							break;

case 'add-news': 					include 'inc/add-news.php'; 								break;
case 'show-news': 					include 'inc/show-news.php'; 								break;
case 'edit-news': 					include 'inc/edit-news.php'; 								break;

case 'add-category': 				include 'inc/add-category.php'; 							break;
case 'edit-category': 				include 'inc/edit-category.php'; 							break;

case 'show-users': 					include 'inc/show-users.php'; 								break;
case 'edit-profile': 				include 'inc/edit-profile.php'; 							break;


case 'logout':						session_destroy(); header('Location: index.php?page=home');		break;

default: 							header('Location: index.php?page=home');

endswitch;

endif;            

?>            
