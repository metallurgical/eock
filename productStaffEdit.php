<?php 
if (!isset($_SESSION)) {
  session_start();
}
require_once('Conn/dbconn.php');
require_once('menu.php');
$nmeError = $catError = $prError = $staError = $staError = "";
if(isset($_SESSION['UserIC']))
{
	$id = $_GET[d];
	$ic = $_SESSION['UserIC'];
	$idP = $id;
	
	
	$sql = "SELECT * FROM `staff` where staff_ic = '$ic'";
	$query = mysql_query($sql) or die("MySQL ErrorStaff: " . mysql_error());	
	$data = mysql_fetch_assoc($query);	
	$StaffID = $data['staff_id'];
	
	$sql12 = "SELECT * FROM product where product_id = $idP";
	$query12 = mysql_query($sql12) or die("MySQL Error Product: " . mysql_error());	
	$data12 = mysql_fetch_assoc($query12);	
	$name = $data12['product_name'];
	$cate = $data12['product_category'];
	$price = $data12['product_priceUnit'];
	$stock = $data12['product_stock'];
	$status = $data12['product_status'];
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EOCK</title>
	<!-- CSS -->
	<link href="css/style.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="css/datepickr.css" />
<script type="text/javascript" src="js/datepickr.min.js"></script>
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
<!--Ko letak data ko kat sni , nnti dia display kat background putih tuh ..-->
<br />
    <form action="productStaffEdit2.php" method="post" name="profileUpdate">
      <table width="312" border="0" align="center">  
      <tr><th colspan="3" bgcolor="#999999">Update Product</th></tr> 
        <tr><th colspan="3" >&nbsp;</th></tr>  
        <tr>
          <td width="91">Name</td>
          <td width="12">:</td>
          <td width="195">                        
          <input type="text" name="name" value="<?php echo $name; ?>"/>
           </td>
        </tr>
        
        <tr>
          <td width="91">Category</td>
          <td width="12">:</td>
          <td width="195">                        
          <select name="category">
          	<option value="<?php echo $cate;?>"><?php echo $cate;?></option>
            <option value="Food">Food</option>
            <option value="Stationary">Stationary</option>
            <option value="Drinks">Drinks</option>
          </select>
           </td>
        </tr> 
        
        <tr>
          <td width="91">Price Per unit (RM)</td>
          <td width="12">:</td>
          <td width="195">                        
          <input type="text" name="pricePer" value="<?php echo $price; ?>"/>
           </td>
        </tr>
        
        <tr>
          <td width="91">Stock</td>
          <td width="12">:</td>
          <td width="195">                        
          <input type="text" name="stock" value="<?php echo $stock; ?>"/>
           </td>
        </tr>
        
        <tr>
          <td width="91">Status</td>
          <td width="12">:</td>
          <td width="195">                        
         <select name="status">
          	<option value="<?php echo $status;?>"><?php echo $status;?></option>
            <option value="Hot Product">Hot Product</option>
            <option value="Normal">Normal</option>
          </select>           </td>
        </tr>
        
        <tr><td colspan="3" align="center"><input type="submit" name="hantar" value="Update" /></td></tr>
      </table>
      <input type="hidden" name="idProduct" value="<?php echo $id;?>" />
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