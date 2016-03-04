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

			$nameF     = $_FILES['myFile']['name'];
			$sizeF     = $_FILES['myFile']['size'];
			$typeF     = $_FILES['myFile']['type'];
			$tmp_nameF = $_FILES['myFile']['tmp_name'];

			$h        = @fopen($tmp_nameF, 'r');
			$content  = @fread($h, filesize($tmp_nameF));
			$content1 = @addslashes($content);
			@fclose($h);

			$target_dir = "uploads/";
			$target_file = $target_dir . $nameF;
			move_uploaded_file($tmp_nameF, $target_file);

			mysql_query("SET foreign_key_checks = 0 ");
				$sql  = "INSERT INTO product ( product_name,product_category,product_priceUnit,product_stock,product_status, product_pic,staff_id) 
				VALUES( '".$name."', 
						'".$category. "',
						'".$price."',
						'".$stock."',						
						'".$status ."',
						'".$nameF."',
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
<?php include( 'header.php' ); ?>
        <div id="header2">
            
        </div>
        </div>
	<div id="backgroundMenu">
        <?php include( 'menuExternal.php' ); ?>
	</div>
</div>  

<div id="content">

 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="addProduct" method="post" enctype="multipart/form-data">
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
		                <td>Choose Product Pic</td>
		                <td>:</td>
		                <td><input type="file" name="myFile"></td>
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