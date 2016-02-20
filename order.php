<?php 
session_start();
require_once('Conn/dbconn.php');

if( isset( $_POST['orderProduct']) )
{	
	if ( !isset( $_SESSION['pId'] ) ) {
		$_SESSION['pId'] = $_POST['id'];
		$idd = $_SESSION['pId'];
	}
	else {

		$idd = $_SESSION['pId'];

		foreach ($_POST['id'] as $key => $value) {
			
			if ( !in_array( $value, $idd ) ) {
				array_push($idd, $value );
			}
		}
		//$idd = array_merge($idd,$_POST['id']);
		$_SESSION['pId'] = $idd;
		$idd = $_SESSION['pId'];
	}

	///print_r($idd);
	//$idd = $_POST['id']; 
	
	$i=0;

	/*foreach($idd as  $value)
	{
		$idProduct[$i] = $value;		
		$i++; 
	}*/
	
	for( $o = 0;$o < count( $idd ); $o++ )
	{ 
		$idProduct[$o] = $idd[$o];		
		$sql11            = "SELECT * FROM `product` where product_id = '$idProduct[$o]'";
		$query11          = mysql_query($sql11) or die("MySQL Error : " . mysql_error());
		$data2            = mysql_fetch_assoc($query11);
		$nameProduct[$o]  = $data2['product_name'];
		$price[$o]        = $data2['product_priceUnit'];
		$stockProduct[$o] = $data2['product_stock'];


	}	
}	


	if(isset($_POST['hantar']) && $_SERVER["REQUEST_METHOD"] == "POST")
	{
		$student_id = $_SESSION['user_id'];
		$proID = $_POST['proID'];
		
		$totalPrice=0.0;
		$tolakS=0;
		$count=0;
		$s = 'NO';
		foreach($proID as $indx => $value)
		{
			$price=$_POST['pri'];
			$Quantity=$_POST['quan'];
			
			//tolak stock dlm db
			$data1=mysql_fetch_assoc(mysql_query("select product_name,product_stock from product where product_id ='$proID[$indx]' "));
			$proN = $data1['product_name'];	
			$proS = $data1['product_stock'];			
			$tolakS = $proS - $Quantity[$indx];	
			if($tolakS>=0){
			$tolakStock = mysql_query("update product set product_stock='$tolakS' where product_id ='$proID[$indx]' ") or die("MySQL Error 1: ".mysql_error());
			
			$s = 'YES';
			}else
			if($tolakS<0){?>
			<script>window.location.href='product.php';
            alert("Product Name: <?php echo $proN?>, Stock have: <?php echo $proS;?>. Please re-Order again. TQ ");</script><?php }
			//end tolak stock
			$total[$count] = $price[$indx] * $Quantity[$indx];
			$totalPrice=$totalPrice+$total[$count];
			
			$newID[$count] = $proID[$indx];
			$newQuantity[$count] = $Quantity[$indx];
			$count++;
		}

		$idOrder = 0;

		if($s=='YES')
		{
			$masuk = "insert into `order` (order_date,order_totalPrice,order_status, student_id)
			values(NOW(),'$totalPrice','PENDING','$student_id')";
			$queryM = mysql_query($masuk) or die("MySQL ERROR2: ".mysql_error());
			
			if($queryM)
			{
				$data=mysql_fetch_assoc(mysql_query("select MAX(order_id) as maxId from `order` where student_id = '".$_SESSION['user_id']."'"));
				$idOrder=$data['maxId'];
				
				for($oo=0;$oo<$count;$oo++){
					
					$masukO = "insert into product_order (po_quantity,po_totalPricePerproduct,product_id,order_id)
					values('$newQuantity[$oo]','$total[$oo]',$newID[$oo],$idOrder)";
					$queryO = mysql_query($masukO) or die("MySQL Error3 : ".mysql_error());
				}

				$datassss=mysql_fetch_assoc(mysql_query("select student_noMatric from `students` where student_id = '".$_SESSION['user_id']."'"));

				$sm = $datassss['student_noMatric'];
				require 'phpmailer/PHPMailerAutoload.php';
				//require 'phpmailer/class.phpmailer.php';
				$mail = new PHPMailer;
				//$mail->SMTPDebug = 3;
				$body = "Product have been ordered by Student with Matric No $sm at ".date('d-m-y H:i:s');
				$mail->SMTPAuth = true; 
				$mail->Host = "smtp.gmail.com";
				//$mail->Port = 465; 
				$mail->Port = 587; 
				$mail->Username = "thunderwidedev@gmail.com"; 
				$mail->Password = "thunderwidedev@1234"; 
				$mail->isSMTP();
				$mail->SMTPSecure = 'tls';
				//$mail->SMTPAuth = true;
				$mail->setFrom('sistem@eock.com', 'System');
				$mail->addReplyTo('noreply@yahoo.com', 'Administrator');
				//$mail->addAddress('norlihazmey89@yahoo.com', 'Administrator');
				$mail->addAddress('syidaeda@gmail.com', 'Administrator');
				$mail->Subject = 'New message from student order[product]';
				$mail->MsgHTML($body);
				

				if (!$mail->send()) {
				    unset($_SESSION['pId']);
				    echo '<script language="javascript">';
				    echo 'alert("Error on sending email but product success orderr...");';
				    echo 'window.location="resitCustomer.php?a='.$idOrder.'";';
				    echo '</script>';
				} else {
				    unset($_SESSION['pId']);
				    echo '<script language="javascript">';
				    echo 'alert("Success ordering and email was sent to admin/staff email for future references.");';
				    echo 'window.location="resitCustomer.php?a='.$idOrder.'";';
				    echo '</script>';
				}

			    
				
				?><!-- 
						<script>window.location.href="resitCustomer.php?a='"<?php echo $ciphertext_base64;?>"'";
					alert("Success ordering !");</script>
					 -->
					<?php
			}
				
		}
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
<?php
$sqlStudent   = mysql_query( "SELECT * FROM `students` where student_id ='".$_SESSION['user_id']."'" );
$dataStudent = mysql_fetch_array( $sqlStudent );
?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	  <table align="center" cellspacing="1" cellpadding="1" width="544" bordercolor="#999999">	  
       
        <tr>
          <th colspan="5" bgcolor="#999999">Student Details</th>
        </tr>
        <tr>
        	<td width="144">Name</td>
            <td colspan="4">: &nbsp;<?php echo $dataStudent['student_name']; ?></td>
        </tr>
        <tr>
        	<td>No. Matric</td>
            <td colspan="4">: &nbsp;<?php echo $dataStudent['student_noMatric']; ?></td>
        </tr>
        <tr>
        	<td>No. Phone</td>
            <td colspan="4">: &nbsp;<?php echo $dataStudent['student_phone']; ?></td>
        </tr>
        <tr><td colspan="4">&nbsp;</td></tr>
        <tr>
          <th colspan="5" bgcolor="#999999">Product <button type="button" onclick="window.location.href='product.php'"  style="float:right">Add Product</button></th>
        </tr>
        <tr>
        	<td align="center" bgcolor="#CCCCCC">Product ID</td>
        	<td width="214" align="center" bgcolor="#CCCCCC">Product Name</td>
            <td width="99" align="center" bgcolor="#CCCCCC">Price</td>
            <td width="99" align="center" bgcolor="#CCCCCC">Stock-Left</td>
            <td width="72" align="center" bgcolor="#CCCCCC">Quantity</td>
            
        </tr>
        <?php 
		for($d = 0; $d < count( @$idProduct ); $d++){ 
			?>
        <tr>
        	<td align="center"><input type="hidden" name="proID[]" value="<?php echo $idProduct[$d]; ?>" /><label><?php echo $idProduct[$d]; ?></label></td>
            <td align="center"><input type="hidden" name="nmePRO" value="<?php echo $nameProduct[$d]; ?>" /><label><?php echo $nameProduct[$d]; ?></label></td>
            <td align="center"><input type="hidden" name="pri[]" value="<?php echo $price[$d]; ?>" /><label><?php echo $price[$d]; ?></label></td>
            <td align="center"<label><?php echo $stockProduct[$d]; ?></label></td>
            <td align="center"><input type="text" name="quan[]" size="10"/></td>
        </tr>  
        <?php } ?>  
        <tr>
          <td colspan="5" align="center">&nbsp;</td>
        </tr>    
        <tr>
          <td colspan="5" align="center"><input type="submit" name="hantar" value=" S U B M I T " /></td>
        </tr>
        <tr>
          <td colspan="5" align="center">&nbsp;</td>
        </tr>
      </table>
   </form>

</div><div id="kaki" align="center">Copyright 2015. Electronic Operational Center KIOSK (EOCK)</div>
</body>
</html>