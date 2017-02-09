<?
session_start();

/*
$config['host'] = 'localhost';
$config['user'] = 'root';
$config['pass'] = '';
$config['db']   = 'enrico-blog';
*/

$config['host'] = 'localhost';
$config['user'] = 'poddaEnrico';
$config['pass'] = 'pappagallo7338';
$config['db']   = 'amm15_poddaEnrico';


$config['conn'] = mysql_connect ($config['host'], $config['user'], $config['pass']) or die ('Unable to connect to server, check the configuration file.');
                  mysql_select_db ($config['db'], $config['conn']) or die('Unable to connect to database, check the configuration file');
?>