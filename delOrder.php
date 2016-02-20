<?php
require_once('Conn/dbconn.php');

$id=$_GET['d'];
   
/*$aaa="Select student_noMatric,student_name FROM `order` WHERE order_id=$id";
$ppp = mysql_query($aaa) or die("MySQL Error: " . mysql_error()); 
$data = mysql_fetch_assoc($ppp);
$matrix = $data['student_noMatric'] ;  
$name = $data['student_name'] ; */
 
$sql1="DELETE FROM product_order WHERE order_id=$id";
$query1 = mysql_query($sql1) or die("MySQL Error: " . mysql_error());  
    
$sql2="DELETE FROM `order` WHERE order_id=$id";
$query2 = mysql_query($sql2) or die("MySQL Error: " . mysql_error());
?>
<html>
<script language="javascript">
alert("Order No. <?php echo $id; ?> have been deleted.");
window.location="home.php";
</script>
</html>
<?php
 echo "MySQL Error: " . mysql_error();  
?>

