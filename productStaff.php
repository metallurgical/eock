<?php 
if (!isset($_SESSION)) {
  session_start();
}
require_once('Conn/dbconn.php');
require_once('menu.php');
if(isset($_SESSION['UserIC']))
{
	
	$sql = "SELECT * FROM `product`";
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
	$Pstatus[$i] = $data['product_status'];
	$i++;
	
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="robots" content="index, follow" />
<title>EOCK</title>
	<!-- CSS -->
	<link href="css/style.css" rel="stylesheet" type="text/css" />
    
    <link rel="stylesheet" type="text/css" href="css/lightwindow.css" />
    
	<!-- JavaScript -->
	<script type="text/javascript" src="js/prototype.js"></script>
	<script type="text/javascript" src="js/effects.js"></script>
	<script type="text/javascript" src="js/lightwindow.js"></script>
	
</head>

<body>
<div id="header">
<img src="images/eock2.jpg" />
<font size="+5" style="position:absolute; top:40px; left:135px;">ELECTRONIC OPERATIONAL CENTER KIOSK</font>
        <div id="header2">
            
        </div>
        </div>
	<div id="backgroundMenu">
        <?php include( 'menuExternal.php' ); ?>
	</div>
</div>  

<div id="content">
 <div id="sidebar">
 <a href="addProduct.php"><input type="button" value="Add"/></a>
 </div>
<h4 align="center">List of Product</h4>	
<br />
<table width="720" align="center" bordercolor="#FF9900">
<tr><td width="566">
<table width="698" align="center"  cellpadding="2" cellspacing="2">
<tr bgcolor="#FF9900">
<th width="40">No.</th>
<th width="174">Name</th>
<th width="102">Category</th>
<th width="75">RM per unit</th>
<th width="82">In-Stock</th>
<th width="109">Product Status</th>
<th width="70">Action</th>
</tr>

<?php 
		for($i = 0; $i < $row; $i++){ 
		?> 
		<tr style="overflow:scroll;">
		<td align="center"><?php echo $i+1; ?></td>		
		<td  align="center"><?php echo $name[$i]; ?></td>
        <td  align="center"><?php echo $category[$i]; ?></td>
		<td  align="center"><?php echo $priceUnit[$i]; ?></td>
		<td  align="center"><?php echo $stock[$i]; ?></td>       
		<td  align="center"><?php echo $Pstatus[$i]; ?></td>
         <td  align="center"> <a href="viewProduct.php?d='<?php echo $id[$i]; ?>'" params="lightwindow_width=800,lightwindow_height=300" class="lightwindow page-options"><input type="button" name="viewProduct" value="View"/></a></td>
		</tr>
		<?php }?>
</table>
</td></tr></table>

</div>
<div id="kaki" align="center">Copyright 2014. Electronic Operational Center KIOSK (EOCK)</div>
</body>
</html>
<?php
}
else
{

header("Location:index.php");
}
?>