<?php 
session_start();

require_once('Conn/dbconn.php');
$sql = "SELECT * FROM `product` where product_status = 'Hot Product'";
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
<img src="images/eock2.jpg" />
<font size="+5" style="position:absolute; top:40px; left:135px;">ELECTRONIC OPERATIONAL CENTER KIOSK</font>
        <div id="header2">
            
        </div>
        </div>
	<div id="backgroundMenu">
        <div id="menu"> 
        	<ul>
                        <li><a href="index.php" class="current" >Home</a></li>
                         <li><a href="product.php">Product</a>
                            <ul>
                                <li><a href="cFood.php">Food</a></li>
                                <li><a href="cStat.php">Stationary</a></li>
                                <li><a href="cDrinks.php">Drinks</a></li>
                            </ul>
                        </li>
                        <li><a href="Servis.php">Servis</a>
                        	<ul>
                                <li><a href="Printer.php">Printer</a></li>
                                <li><a href="Photostat.php">Photostat</a></li>
                             
                            </ul>
                        </li>
                       
                       <li><a href="contact.php">Contact</a></li>
            </ul>            
         </div>
         <div id="login"> 
        	
            <ul>
                        <li><a href="registerAdmin.php">Register Admin</a></li>
                        <li><a href="loginAdmin.php">Login Admin</a></li>
            </ul>            
         </div> 
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

<?php if($row == 0){
	?>
	<tr style="overflow:scroll;">
        <td align="center" colspan="6">No HOT Product</td>  
		</tr>
	
	<?php
	}else{
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
		<?php }}?>
</table>
</td></tr>
<?php if($row != 0){
	?>
	<tr><td  align="center"><input type="submit" name="orderProduct" value="Order"/></td></tr>	
	<?php
	}?></table>
	</form>



</div>
<div id="kaki" align="center">Copyright 2015. Electronic Operational Center KIOSK (EOCK)</div>
</body>
</html>