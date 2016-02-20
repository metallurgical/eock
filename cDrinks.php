<?php 
session_start();

require_once('Conn/dbconn.php');
$sql = "SELECT * FROM `product` where product_category='Drinks'";
	$query = mysql_query($sql) or die("MySQL Error: " . mysql_error());	
	$row = mysql_num_rows($query);
		
		$i = 0;
  		while($data = mysql_fetch_array($query))
		{
		
	$id[$i] = $data['product_id'];
	$name[$i] = $data['product_name'];
	$category[$i] = $data['product_category'];
	$priceUnit[$i] = $data['product_priceUnit'];
	$stock[$i] = $data['product_stock'];
	$i++;
	
		}
		
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EOCK</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />


</head>

<body>
<div id="header">
<?php include( 'header.php' ); ?>
        <div id="header2">
            
        </div>
        </div>
	<div id="backgroundMenu">
        <?php include( 'menuExternal.php' ); ?>
	</div>
</div>  

<div id="content">
<br />
<form action="order.php" method="post" name="orderBoh">
<table width="720" align="center" bordercolor="#FF9900">
<tr><td width="566">
<table width="698" align="center"  cellpadding="2" cellspacing="2">
<tr bgcolor="#FF9900">
<th width="32">&nbsp;</th>
<th width="33">No.</th>
<th width="229">Name</th>
<th width="109">Category</th>
<th width="136">RM per unit</th>
<th width="119">In-Stock</th>
</tr>

<?php 
		for($i = 0; $i < $row; $i++){ 
		?> 
		<tr style="overflow:scroll;">
        <td align="center"><input type="checkbox" name="id[]" value="<?php echo $id[$i]; ?>" /></td>
		<td align="center"><?php echo $i+1; ?></td>		
		<td  align="center"><?php echo $name[$i]; ?></td>
        <td  align="center"><?php echo $category[$i]; ?></td>
		<td  align="center"><?php echo $priceUnit[$i]; ?></td>
		<td  align="center"><?php echo $stock[$i]; ?></td>   
		</tr>
		<?php }?>
</table>
</td></tr>
<tr><td  align="center"><input type="submit" name="orderProduct" value="Order"/></td></tr></table>
	</form>



</div>
<div id="kaki" align="center">Copyright 2015. Electronic Operational Center KIOSK (EOCK)</div>
</body>
</html>