<?php
require_once('Conn/dbconn.php');

$service_id = $_GET['service_id'];
//$btnId = $_GET['btnId'];

$a = "UPDATE services set service_status = '1' where service_id =$service_id";
$b = mysql_query($a) or die( mysql_error());

echo '<script language="javascript">';
echo 'alert("Data have been successfully updated.");';
echo 'window.location="orderService.php";';
echo '</script>';

?>