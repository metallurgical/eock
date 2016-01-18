<?php 
if (!isset($_SESSION)) {
  session_start();
}
require_once('Conn/dbconn.php');
//require_once('menu.php');

$nameError = $cateError = $priceError = $stockError = $statusError = "";

if(isset($_SESSION['UserIC']))
{
		
		
	if(isset($_POST['hantar']) && $_SERVER["REQUEST_METHOD"] == "POST")
	{
		$name     = $_POST['nme'];
		$category = $_POST['cate'];
		$price    = $_POST['pricePer'];
		$stock    = $_POST['stock'];
		$status   = $_POST['status'];
		
		
		if(empty($name))
		{$nameError   = "Required !";}else
		if(empty($category))
		{$cateError   = "Required !";}else
		if(empty($price))
		{$priceError  = "Required !";}else
		if(empty($stock))
		{$stockError  = "Required !";}else
		if(empty($status))
		{$statusError = "Required !";}
		
		else{
		
		$sql0 = "SELECT product_name,product_category FROM product  WHERE product_name = '$name' and product_category = '$category'" ;	
		$query0 = mysql_query($sql0) or die ("Error: ".mysql_error());
		$row0 = mysql_num_rows($query0);
		
		if($row0 > 0)
		{
		?>
		<html>
		<script language="javascript"> alert("Product name or category have been use database.. !");</script>
		</html>
		<?php
		header("location:addProduct.php");	
		}
		else
		if($row0 == 0)
		{
			mysql_query("SET foreign_key_checks = 0 ");
				$sql  = "INSERT INTO product ( product_name,product_category,product_priceUnit,product_stock,product_status,staff_id) 
				VALUES( '".$name."', 
						'".$category. "',
						'".$price."',
						'".$stock."',						
						'".$status ."',
						'".$_SESSION['user_id']. "')";
						mysql_query($sql) or die ("Error: ".mysql_error());	
			mysql_query("SET foreign_key_checks = 1 ");	
		
		header("location:productStaff.php");	
		}
		}
		
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EOCK</title>
	<!-- CSS -->
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
        <?php include( 'menuExternal.php' ); ?>
	</div>
</div>  

<div id="content">

 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="addProduct" method="post">
	  <table align="center" cellspacing="1" cellpadding="1" width="544" bordercolor="#999999" style="position:relative;top: 50px;">	  
       
        <tr>
          <th colspan="3" bgcolor="#999999">Create New Product</th>
        </tr>
        <tr>
          <td colspan="3"><span style="color:red;">* required field</span></td>
        </tr>
        <tr>
        <td>
                    <table align="center" cellpadding="3" cellspacing="3">
                    <tr>
                      <td>Name</td>
                      <td>:</td>
                      <td><input type="text" name="nme" /><span style="color:red;">* <?php echo $nameError;?></span></td>
                    </tr>
                    <tr>
                      <td>Category</td>
                      <td>:</td>
                      <td><select name="cate">
                      <option value="">Select category</option>
                      <option value="Food">Food</option>
                      <option value="Stationary">Stationary</option>
                       <option value="Drinks">Drinks</option>
                      </select><span style="color:red;">* <?php echo $cateError;?></span></td>
                    </tr>
                    <tr>
                      <td>Price per unit (RM)</td>
                      <td>:</td>
                      <td><input type="text" name="pricePer" /><span style="color:red;">* <?php echo $priceError;?></span></td>
                    </tr>
                    <tr>
                      <td>Stock Added</td>
                      <td>:</td>
                      <td><input type="text" name="stock" /><span style="color:red;">* <?php echo $stockError;?></span></td>
                    </tr>
                    <tr>
                      <td>Status Product</td>
                      <td>:</td>
                      <td><select name="status">
                      <option value="">Select status</option>
                      <option value="Hot Product">Hot Product</option>
                      <option value="Normal">Normal</option>
                      </select><span style="color:red;">* <?php echo $statusError;?></span></td>
                    </tr>
                    <tr>
                      <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="3" align="center"><input type="submit" name="hantar" value=" C R E A T E " /></td>
                    </tr>
                    <tr>
                      <td colspan="3">&nbsp;</td>
                    </tr>
            
            </table>
            </td></tr>
	  </table>
      
	</form>
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