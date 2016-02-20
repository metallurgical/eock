<?php 
if (!isset($_SESSION)) {
  session_start();
}
require_once('Conn/dbconn.php');
//require_once('menu.php');
if(isset($_SESSION['UserIC']))
{
	if ( isset( $_POST['btn_search'] ) ) {
		$sql = "SELECT * FROM `staff` WHERE staff_ic = '".$_POST['txt_search']."' AND staff_position != 'admin'";
	}
	else {
		$sql = "SELECT * FROM `staff` WHERE staff_position != 'admin'";
	}
	
	$query = mysql_query($sql) or die("MySQL Error: " . mysql_error());	
	$row = mysql_num_rows($query);		
	$i = 0;

  	/*	while($data = mysql_fetch_array($query))
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
	
		}*/
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
<h4 align="center">List of Staff</h4>
<form action="" method="POST">
<table width="40%" border="0" cellspacing="1" cellpadding="1" align="center">

  <tbody><tr bgcolor="#CC99CC">
    <td colspan="2">Search Staff</td>
  </tr>
  <tr>
    <td>Enter Staff IC</td>
    <td><label for="textfield"></label>
    <input type="text" name="txt_search" id="textfield"> <input type="submit" name="btn_search" value="Search"></td>
  </tr>
  <tr bgcolor="#CC99CC">
    <td colspan="2">&nbsp;</td>
  </tr>
  
</tbody></table></form>
<br/>

<table  cellpadding="2" cellspacing="2" align="center">
	<tr bgcolor="#FF9900">
		<th>No.</th>
		<th>Name</th>
		<th>Ic</th>
		<th>Phone</th>
		<th>Position</th>
		<th>DOB</th>
		<th>Action</th>
	</tr>

<?php 

	if ( $row > 0 ) {
		while( $data = mysql_fetch_array($query) )  {
		?> 
		<tr>
			<td><?php echo $i+1; ?></td>		
			<td><?php echo $data['staff_name']; ?></td>
	        <td><?php echo $data['staff_ic']; ?></td>
			<td><?php echo $data['staff_phone']; ?></td>
			<td><?php echo $data['staff_position']; ?></td>       
			<td><?php echo $data['staff_BOD']; ?></td>
	         <td> 
	         	<a href="profileStaff.php?d=<?php echo $data['staff_id']; ?>">
	         		<input type="button" name="viewOrder" value="View"/>
	         	</a> 
	         	|<a href="delStaff.php?d=<?php echo $data['staff_id']; ?>">
	         		<input type="button" name="delOrder" value="Delete"/>
	         	</a>
	         	</td>
		</tr>
		<?php 
		}
	}
	else {?>
		<tr>
			<td colspan="6"> No data found</td>
			</tr>
	<?php
	}
	?>
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