<?php 
if (!isset($_SESSION)) {
  session_start();
}
require_once('Conn/dbconn.php');
//require_once('menu.php');
if(isset($_SESSION['UserIC']))
{
	
	$sql = "SELECT * FROM `order` group by order_id DESC";
	$query = mysql_query($sql) or die("MySQL Error: " . mysql_error());	
	$row = mysql_num_rows($query);
		
		$i = 0;
  		while($data = mysql_fetch_array($query))
		{		
			
			$sql1   = "SELECT * FROM students  WHERE student_id = '".$data['student_id']."'" ;
		    $query1 = mysql_query( $sql1 ) or die ("Error: ".mysql_error());
		    $data1  = mysql_fetch_array( $query1 );

			$id[$i]         = $data['order_id'];
			$studName[$i]   = $data1['student_name'];
			$studMatric[$i] = $data1['student_noMatric'];
			$time[$i]       = $data['order_date'];
			$status[$i]     = $data['order_status'];
			$i++;
	
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EOCK</title>
	<!-- CSS -->
	<link href="css/style.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="css/lightwindow.css" />
    
	<!-- JavaScript -->
	<script type="text/javascript" src="js/prototype.js"></script>
	<script type="text/javascript" src="js/effects.js"></script>
	<script type="text/javascript" src="js/lightwindow.js"></script>
	<script>

function printDiv(divId) {
	var prtContent = document.getElementById(divId);
	var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
	//WinPrint.document.write(cssLinkTag)
	WinPrint.document.write(prtContent.innerHTML);
	WinPrint.document.close();
	WinPrint.focus();
	WinPrint.print();
	WinPrint.close();
    
}
</script>
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
<!--Ko letak data ko kat sni , nnti dia display kat background putih tuh ..-->
<h4 align="center">List of Orders</h4>	
<table  cellpadding="2" cellspacing="2" align="center">
<tr bgcolor="#FF9900">
<th>No.</th>
<th>No. Order</th>
<th>Name</th>
<th>No. Matric</th>
<th>Time Booking</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php 
		for($i = 0; $i < $row; $i++){ 
		?> 
		<tr>
		<td><?php echo $i+1; ?></td>		
		<td><?php echo $id[$i]; ?></td>
        <td><?php echo $studName[$i]; ?></td>
		<td><?php echo $studMatric[$i]; ?></td>
		<td><?php echo $time[$i]; ?></td>       
		<td><?php echo $status[$i]; ?></td>
         <td> <a href="viewOrder.php?d=<?php echo $id[$i]; ?>" params="lightwindow_width=700,lightwindow_height=350" class="lightwindow page-options"><input type="button" name="viewOrder" value="View"/></a> |<a href="delOrder.php?d=<?php echo $id[$i]; ?>"><input type="button" name="delOrder" value="Delete"/></td>
		</tr>
		<?php }?>
</table>


</div>
<div id="kaki" align="center">Copyright 2015. Electronic Operational Center KIOSK (EOCK)</div>
</body>
</html>
<?php
}
else
{

header("Location:index.php");
}
?>