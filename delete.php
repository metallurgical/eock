<?php
include("conn.php");
//to retrieve delete id
$id_delete = $_GET['id_delete'];
echo $id_delete;
//to delete
if($id_delete !="") {
	$a = "delete from staff where s_id='$id_delete'";
	$b = mysql_query($a) or die(mysql_error().$a);
}
header("location:view.php?msg=del");
?>