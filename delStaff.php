<?php
require_once('Conn/dbconn.php');

$id_delete = $_GET['d'];

$a = "DELETE from staff where staff_id =$id_delete";
$b = mysql_query($a) or die( mysql_error());

echo '<script language="javascript">';
echo 'alert("Data have been successfully deleted.");';
echo 'window.location="viewAllStaff.php";';
echo '</script>';

?>