<?php
session_start();
//unset all of the session variables.
/*$_session = array();

//destroy the session and session data.
if(ini_get("session.use_cookies"))
{
	$params = session_get_cookie_params();
	setcookie(session_name(),'',time() - 36000,$params["path"], $params["domain"],$params["secure"],$params["httponly"]);
	
}*/

session_destroy();
header("Location: index.php");

?>