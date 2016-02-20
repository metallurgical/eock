<?php /* php& mysqldb connection file */
$user = "root"; //mysqlusername
$pass = ""; //mysqlpassword
$host = "localhost"; //server name or ipaddress
$dbname= "eock"; //your db name

$dbconn= mysql_connect($host, $user, $pass);

if(isset($dbconn))
{	mysql_select_db($dbname, $dbconn) or die("<center>Error: " . mysql_error() . "</center>");	

}

?>