<?php 
require_once('Conn/dbconn.php');
$id = @$_REQUEST['d'];

if(isset($_POST['aaaa']) && $_SERVER["REQUEST_METHOD"] == "POST")
	{
			$ddddd = $_POST['oID'];
mysql_query("update `order` set order_status='APPROVE',order_finishDate=NOW() where order_id = $ddddd") or die("MySQL Error 1: ".mysql_error());
		
		?><script>alert("Order Approve !");window.location.href='home.php';</script><?php
	}
else {?><script>window.location.href='home.php';alert("Error !");</script><?php 

	}


if(!isset($_POST['hantar']) && !isset($_POST['aaaa'])) {
$sql = "SELECT * from `order` o, product p, product_order po WHERE o.order_id = po.order_id AND p.product_id = po.product_id AND o.order_id = $id";
	$query = mysql_query($sql) or die("MySQL Error 2: " . mysql_error());  	
	$row = mysql_num_rows($query);
		
		$i = 0;
  		while($data1 = mysql_fetch_array($query))
		{	
			$proName[$i] = $data1['product_name'];
			$proPriceUnit[$i] = $data1['product_priceUnit'];
			$quantity[$i] = $data1['po_quantity'];
			$totalPriceProduct[$i] = $data1['po_totalPricePerProduct'];	
			$i++;	
		}	
		
	$sql1 = "SELECT * from `order` o, product p, product_order po WHERE o.order_id = po.order_id AND p.product_id = po.product_id AND o.order_id = $id";
	$query1 = mysql_query($sql1) or die("MySQL Error 3: " . mysql_error());
  	$data = mysql_fetch_assoc($query1);	
	
	$orderID    = $data['order_id'];
	$date       = $data['order_date'];
	$totalPrice = $data['order_totalPrice'];
	$dateFinish = $data['order_finishDate'];
	$sql14      = "SELECT * FROM students  WHERE student_id = '".$data['student_id']."'" ;
	$query14    = mysql_query( $sql14 ) or die ("Error 4: ".mysql_error());
	$data14     = mysql_fetch_array( $query14 );
	$matric    = $data14['student_noMatric'];
	$studName  = $data14['student_name'];
	$studPhone = $data14['student_phone'];
	$status     = $data['order_status'];
	
	
	
	
?>
<html>
<head>

<style type="text/css">
#ipsum{font-size:17px;}
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
<script>
/*printDivCSS = new String ('<link href="myprintstyle.css" rel="stylesheet" type="text/css">')
function printDiv(divId) {
    window.frames["print_frame"].document.body.innerHTML=printDivCSS + document.getElementById(divId).innerHTML;
    window.frames["print_frame"].window.focus();
    window.frames["print_frame"].window.print();
}*/
</script>
</head>
<body>
<div id="ipsum">
<p align="center">Order Details</p> <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" name="updateORDER">
<table width="680" height="120" align="center" cellpadding="10" cellspacing="2" >
<tr>
	<td width="352">
        <table width="355" cellpadding="10" cellspacing="2">
        <tr>
        <td width="120" bgcolor="#CCCCCC">Order ID</td>
        <td width="141"><?php echo $orderID;?></td>
        </tr>
        
        <tr>
        <td bgcolor="#CCCCCC">Date & Time Order</td>
        <td><?php echo $date;?> </td>
        </tr>
        
        <?php if(empty($dateFinish)){?>
        <tr>
        <td bgcolor="#CCCCCC"> Date End Order</td>
        <td >Still in process</td>
        </tr>
        <?php }else {?>
        <tr>
        <td bgcolor="#CCCCCC"> Date End Order</td>
        <td><?php echo $dateFinish;?></td>
        </tr>
        <?php }?>
        <tr>
        <td bgcolor="#CCCCCC">Status Order</td>
        <td><?php echo $status;?></td>
        </tr>
        </table>
	</td>

	<td width="280">
        <table cellpadding="10" cellspacing="2">
        <tr>
        <td bgcolor="#CCCCCC">Student Name</td>
        <td><?php echo $studName;?></td>
        </tr>
        
        <tr>
        <td bgcolor="#CCCCCC">No. Matrix</td>
        <td><?php echo $matric; ?></td>
        </tr>
        
        <tr>
        <td bgcolor="#CCCCCC">Phone</td>
        <td><?php echo $studPhone; ?></td>
        </tr>
        </table>
	</td>
</tr>
</table>
<br>
	<table width="625" align="center" cellpadding="10" cellspacing="2">
    <tr>
    <th bgcolor="#CCCCCC">No.</th>
    <th bgcolor="#CCCCCC">Product Name</th>
    <th bgcolor="#CCCCCC">Product Price/Unit</th>
    <th bgcolor="#CCCCCC">Quantity</th>
    <th bgcolor="#CCCCCC">Total Price / Product</th>
    </tr>
    
   
<?php 
		for($i = 0; $i < $row; $i++){ 
		?> 
		<tr>
		<td><?php echo $i+1; ?></td>		
		<td><?php echo $proName[$i]; ?></td>
        <td><?php echo $proPriceUnit[$i]; ?></td>
		<td><?php echo $quantity[$i]; ?></td>
		<td><?php echo $totalPriceProduct[$i]; ?></td>
		</tr>
		<?php }?>
        <tr>
        <td colspan="4" bgcolor="#CCCCCC">Total need to pay</td>
        <td style="border-top:solid #000;"><?php echo $totalPrice;?></td>
        </tr>
       
        
        <tr>
        <td colspan="5" align="right">
        	<input type="hidden" name="oID" value="<?php echo $orderID;?>" />
        	<input type="submit" name="aaaa" value="APPROVE" />
        	<input type="button" name="aaaa1" value="Print Details" onclick="printDiv('ipsum')"/>
        </td>
        </tr>
       
	</table> </form>
    <?php }?>
</div>

</body>
</html>