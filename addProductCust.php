<?php 
if(isset($_POST['hantar']))
{
	$name = $_POST['nameStudent'];
	$matrix = $_POST['matrix'];
	$phone = $_POST['phone'];
	$quan = $_POST['quantity'];
	$idProduct = $_POST['idPro'];
	
	$_SESSION['matrix'] = $matrix;
		$file = fopen("$matrix.txt","w");
		fwrite($file,"$name\r\n$matrix\r\n$phone\r\n$idProduct\r\n$quan");
		fclose($file);	
		
		header("Location: product.php");
	
}

if(isset($_POST['finish']) && isset($_SESSION['matrix']))
{
	$name = $_POST['nameStudent'];
	$matrix = $_POST['matrix'];
	$phone = $_POST['phone'];
	$quan = $_POST['quantity'];
	$idProduct = $_POST['idPro'];
	
	$fileRead = fopen("$matrix.txt","r");
	$data = file("$matrix.txt");
	for($i=0;$i<5;$i++){
	if($i==0){$name = $data[$i];
	echo $name;}else
	if($i==1){$matr = $data[$i];
	echo $matr;}else
	if($i==2){$pho = $data[$i];
	echo $pho;}else
	if($i==3){$idPro = $data[$i];
	echo $idPro;}else
	if($i==4){$quann = $data[$i];
	echo $quann;}
	}
	$sql1 = "SELECT * FROM `product where product_id IN ('$idPro','$idProduct')`";
	$query1 = mysql_query($sql1) or die("MySQL Error: " . mysql_error());	
	$data = mysql_fetch_assoc($query1);
	
		$sql = "insert into `order` (order_date,order_totalPrice";
		
		header("Location: product.php");
	
}
?>