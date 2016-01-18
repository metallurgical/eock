<?php 
require_once('Conn/dbconn.php');
$id = $_GET['d'];

$sql = "SELECT * FROM `product`  WHERE product_id = $id";
	$query = mysql_query($sql) or die("MySQL Error: " . mysql_error());
  	$data = mysql_fetch_assoc($query);
	
	$name = $data['product_name'];
	$category = $data['product_category'];
	$price = $data['product_priceUnit'];
	$stock = $data['product_stock'];
	$status = $data['product_status'];
	
	
?>
<div id="ipsum" >
<p align="center">Product Details</p>

<br>
	<table width="511" height="150"align="center" cellpadding="2" cellspacing="2" border="1">
    <tr bgcolor="#666666" style="color:white;">
    <th>Name</th>
    <th>Category</th>
    <th>Price/Unit</th>
    <th>Stock</th>
    <th>Status</th>
    </tr>
  
		<tr>		
		<td><?php echo $name; ?></td>
        <td><?php echo $category; ?></td>
		<td><?php echo $price; ?></td>
		<td><?php echo $stock; ?></td>
        <td><?php echo $status; ?></td>
		</tr>
     <tr>
     <td colspan="5" align="center"><a href="delProduct.php?d=<?php echo $id;?>"><input type="button" name="delete" value="Delete"></a> | <a href="productStaffEdit.php?d=<?php echo $id;?>"><input type="button" name="update" value="Update"></a></td>
     </tr>  
	</table>
</div>

<style type="text/css">

#ipsum p {
		padding: 10px 0 0 0;
		color: #666666;
		
		line-height: 25px;
		
		clear: both;
		font-size:20px;
		background-color:#CCC;
		text-align:center;
		
}

#a {

		padding: 10px 0 0 0;
		background-color:#CCC;
		
	
}
</style>