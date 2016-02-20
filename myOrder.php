<?php 
session_start();
require_once('Conn/dbconn.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EOCK</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/lightwindow.css" />
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
<br />
<form action="order.php" method="post" name="orderBoh">
<table width="720" align="center" bordercolor="#FF9900">
<tr><td width="566">
<table width="698" align="center"  cellpadding="2" cellspacing="2">
	<tr bgcolor="#FF9900">
		<th>No.</th>
		<th>No. Order</th>		
		<th>Time Booking</th>
		<th>Status</th>
		<th>Action</th>
	</tr>
<?php 	
$i = 0;

$sql   = "SELECT * FROM `order` where student_id ='".$_SESSION['user_id']."' group by order_id ";
$query = mysql_query($sql) or die("MySQL Error: " . mysql_error());	
$row   = mysql_num_rows($query);

while( $data = mysql_fetch_array( $query ) ) { 
?> 
	<tr style="overflow:scroll;"><td><?php echo $i+1; ?></td>		
		<td><?php echo $data['order_id']; ?></td>        
		<td><?php echo $data['order_date']; ?></td>       
		<td><?php echo $data['order_status']; ?></td>
        <td> 
        	<a href="viewOrderStudent.php?d=<?php echo $data['order_id']; ?>" params="lightwindow_width=700,lightwindow_height=350" class="lightwindow page-options">
        		<input type="button" name="viewOrder" value="View"/>
        	</a> |
        	<a href="delOrderStudent.php?d=<?php echo $data['order_id']; ?>">
        		<input type="button" name="delOrder" value="Delete"/>
        	</td> 
	</tr>
<?php }?>
</table>

</td></tr>
</table>
	</form>



</div>
<div id="kaki" align="center">Copyright 2015. Electronic Operational Center KIOSK (EOCK)</div>
</body>
</html>