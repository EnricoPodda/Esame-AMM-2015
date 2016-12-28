<?

/**
 * Integer
 *
 * @param	string
 * @return	bool
 */
 
function integer($str)
{
	return (bool) preg_match('/^[\-+]?[0-9]+$/', $str);
}

/**
 * validatemail
 *
 * @param	string
 * @return	bool
 */
function validatemail($email)
{
	$email = trim($email);
	if(!$email) return false;	
	$num_at = count(explode( '@', $email )) - 1;
	if($num_at != 1)return false;
	if(strpos($email,';') || strpos($email,',') || strpos($email,' '))return false;
	if(!preg_match( '/^[\w\.\-]+@\w+[\w\.\-]*?\.\w{1,4}$/', $email))  return false;
	return true;
}

/**
 * change_dangerous_characters
 *
 * @param	string
 * @return	string
 */
function change_dangerous_characters($string)
{
	$dangerous_characters 	= array("{nl}","à","è","é","ò","ù","°","ç","€"); 
	$to_change  			= array("","&agrave;","&egrave;","&egrave;","&ograve;","&ugrave;","&deg;","&ccedil;","&euro;"); 
	
	return mysql_real_escape_string(str_replace($dangerous_characters, $to_change, $string));
}

/**
 * change_dangerous_characters_html
 *
 * @param	string
 * @return	string
 */
function change_dangerous_characters_html($string)
{
	$dangerous_characters 	= array("<", ">", '"',"{nl}","à","è","é","ò","ù","°","ç","€"); 
	$to_change  			= array("&lt;", "&gt;", '&quot;',"","&agrave;","&egrave;","&egrave;","&ograve;","&ugrave;","&deg;","&ccedil;","&euro;"); 
	
	return mysql_real_escape_string(str_replace($dangerous_characters, $to_change, $string));
}

/**
 * generate_url_title
 *
 * @param	string
 * @return	string
 */
function generate_url_title($string)
{
	return str_replace(" ", "-", $string);
}

/**
 * generate_new_password
 *
 * @param	null
 * @return	string
 */
function generate_new_password()
{

$p ='';
for($i = 1; $i <=10; $i++)
{
	$p	.= rand(1, 9);	
}
return $p;
	
}

/**
 * cript_password
 *
 * @param	string
 * @return	string
 */
 
function cript_password($psw)
{
	return sha1(md5(sha1(md5(mysql_real_escape_string($psw)))));
}

/**
 * rmdirr
 *
 * @param	string
 */
function rmdirr($dir) 
{
   if($objs = @glob($dir."/*"))
   {
		foreach($objs as $obj) 
		{
		@is_dir($obj)? rmdirr($obj) : @unlink($obj);
		}
	}
@rmdir($dir);
}
?>