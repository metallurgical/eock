<?php
require_once('Conn/dbconn.php');

$id=$_GET['d'];
   
$aaa="Select product_name,product_category FROM product WHERE product_id=$id";
$ppp = mysql_query($aaa) or die("MySQL Error: " . mysql_error()); 
$data = mysql_fetch_assoc($ppp);
$name = $data['product_name'] ;  
$cate = $data['product_category'] ; 
 
$sql1="DELETE FROM product WHERE product_id=$id";
$query1 = mysql_query($sql1) or die("MySQL Error: " . mysql_error());
?>
<html>
<script language="javascript">
alert("Product Name : <?php echo $name;?>, Category: <?php echo $cate;?> have been deleted.");
window.location="productStaff.php";
</script>
</html>
<?php
 echo "MySQL Error: " . mysql_error();  
?>

