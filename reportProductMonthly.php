<?php 

if (!isset($_SESSION)) {
  session_start();
}

date_default_timezone_set('Asia/Kuala_Lumpur');
require_once('Conn/dbconn.php');

if( isset( $_POST['search'] ) ) {
	
	extract( $_POST );
	$today = $date_search;
	$sql = "SELECT SUM(order_totalPrice) as totalPrice, MONTH( order_date ) AS bulan FROM `order` WHERE YEAR(order_date) = $today GROUP BY bulan";
	
	
}
else {
	$today = date( 'Y' );
	$sql = "SELECT SUM(order_totalPrice) as totalPrice, MONTH( order_date ) AS bulan FROM `order` WHERE YEAR(order_date) = $today GROUP BY bulan";
	//$sql = "SELECT * FROM `order` inner join students on order.student_id = students.student_id WHERE order_date BETWEEN '$today 00:00:00' AND '$today 23:59:59'";
}

$query = mysql_query( $sql ) or die("MySQL Error: " . mysql_error());	
$row = mysql_num_rows($query);


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
<?php include( 'header.php' ); ?>
        <div id="header2">
            
        </div>
        </div>
	<div id="backgroundMenu">
        <?php include( 'menuExternal.php' ); ?>
	</div>
</div>  

<div id="content">
 
<h4 align="center">Monthly report product orders</h4>	
<br />
<div align="center">
	<form action="" method="POST">
		Search by Year
		<select name="date_search">
			<option value="">--Please Select--</option>
			<?php
			$year = 2010;
			while( $year <= 2017 ) {?>
				<option value="<?php echo $year;?>"><?php echo $year;?></option>
			<?php 
				$year++;
			} ?>
		</select>
		<input type="submit" name="search" value="Search" />
	</form>
</div>
<br />
<!-- <div align="center">Number of students whose are ordering by <?php if(isset($_POST['date_search']) ) { echo $_POST['date_search']; } else { echo date('Y-m-d');} ?> is <?php echo $row; ?> persons.</div> -->
<table width="720" align="center" bordercolor="#FF9900">
	<tr>
		<td width="566">
			<table width="698" align="center"  cellpadding="2" cellspacing="2">
				<tr bgcolor="#FF9900">
					<th width="40">No.</th>
					<th width="174">Month</th>
					<th width="102">Total</th>
					<!-- <th width="70">Action</th> -->
				</tr>
				<?php 
				$i = 1;
				$bil = 1;
				$dataBulanTotal = array();

				while($data = mysql_fetch_assoc($query)) {
					$dataBulanTotal[$data['bulan']] = $data['totalPrice'];
				}
				

				$months = array( 1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.');
				while( $i <= 12 ){
				?> 
				<tr style="overflow:scroll;">
					<td align="center"><?php echo $bil++; ?></td>		
					<td  align="center"><?php echo $months[$i]; ?></td>
			        <td  align="center">
			        	<?php 
			        	if ( @$dataBulanTotal[$i] ) {
			        		echo 'RM '.$dataBulanTotal[$i];
			        	}else{
			        		echo 'None';
			        	} ?>
			        </td>
					
				</tr>
				<?php
					$i++;
				}
				?>
			</table>
		</td>
	</tr>
</table>

</div>
<div id="kaki" align="center">Copyright 2014. Electronic Operational Center KIOSK (EOCK)</div>
</body>
</html>
