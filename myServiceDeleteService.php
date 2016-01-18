<?php
require_once('Conn/dbconn.php');

$id_delete = $_GET['service_id'];


$a = "DELETE from services where service_id =$id_delete";
$b = mysql_query($a) or die( mysql_error());

$a1 = "DELETE from service_files where service_id =$id_delete";
$b1 = mysql_query($a1) or die( mysql_error());

echo '<script language="javascript">';
echo 'alert("Data have been successfully deleted.");';
echo 'window.location="myServices.php";';
echo '</script>';

?>