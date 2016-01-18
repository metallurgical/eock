<?php 

if (!isset($_SESSION)) {
  session_start();
}

date_default_timezone_set('Asia/Kuala_Lumpur');
require_once('Conn/dbconn.php');

if( isset( $_POST['search'] ) ) {
	
	extract( $_POST );
	$sql = "SELECT * FROM `order` inner join students on order.student_id = students.student_id WHERE order_date BETWEEN '$date_search 00:00:00' AND '$date_search 23:59:59'";
	
	
}
else {
	$today = date( 'Y-m-d' );
	$sql = "SELECT * FROM `order` inner join students on order.student_id = students.student_id WHERE order_date BETWEEN '$today 00:00:00' AND '$today 23:59:59'";
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
 
<h4 align="center">Daily report product orders</h4>	
<br />
<div align="center">
	<form action="" method="POST">
		Search by Date <input name="date_search" type="date"/>
		<input type="submit" name="search" value="Search" />
	</form>
</div>
<br />
<div align="center">Number of students whose are ordering by <?php if(isset($_POST['date_search']) ) { echo $_POST['date_search']; } else { echo date('Y-m-d');} ?> is <?php echo $row; ?> persons.</div>
<table width="720" align="center" bordercolor="#FF9900">
	<tr>
		<td width="566">
			<table width="698" align="center"  cellpadding="2" cellspacing="2">
				<tr bgcolor="#FF9900">
					<th width="40">No.</th>
					<th width="174">Name</th>
					<th width="102">Matric No</th>
					<th width="75">Order date</th>
					<th width="82">Order status</th>
					<!-- <th width="70">Action</th> -->
				</tr>
				<?php 
				$i = 1;
				while( $data = mysql_fetch_array( $query ) ){
				?> 
				<tr style="overflow:scroll;">
					<td align="center"><?php echo $i++; ?></td>		
					<td  align="center"><?php echo $data['student_name']; ?></td>
			        <td  align="center"><?php echo $data['student_noMatric']; ?></td>
					<td  align="center"><?php echo $data['order_date']; ?></td>
					<td  align="center"><?php echo $data['order_status']; ?></td>
				</tr>
				<?php 
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
