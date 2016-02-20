<?php
require_once('Conn/dbconn.php');

$id_delete = $_GET['service_file_id'];
$btnId = $_GET['btnId'];

$a = "DELETE from service_files where service_file_id =$id_delete";
$b = mysql_query($a) or die( mysql_error());

echo '<script language="javascript">';
echo 'alert("Data have been successfully deleted.");';
echo 'window.location="orderService.php?btnId='.$btnId.'";';
echo '</script>';

?>