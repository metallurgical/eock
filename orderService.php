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
		<th>Jabatan</th>		
		<th>Service Date</th>
		<th>Category</th>
		<th>Status</th>
		<th>Action</th>
	</tr>
<?php 	
$i = 0;
$j = 0;
$k = 0;

$sql   = "SELECT * FROM `services`";
$query = mysql_query($sql) or die("MySQL Error: " . mysql_error());	
$row   = mysql_num_rows($query);

while( $data = mysql_fetch_array( $query ) ) { 
?> 
	<tr style="overflow:scroll;"><td><?php echo $i+1; ?></td>		
		<td><?php echo $data['service_jabatan']; ?></td>        
		<td><?php echo $data['servis_date_created']; ?></td>       
		<td><?php echo $data['service_cat']; ?></td>
		<td><?php 
		if ( $data['service_status'] == 0 ) {
			echo 'Dalam Proses';
		}
		else {
			echo 'Siap';
		} ?></td>
        <td> 
        	<a href="orderServicesView.php?service_id=<?php echo $data['service_id']; ?>&jabatan=<?php echo $data['service_jabatan']; ?>&cat=<?php echo $data['service_cat']; ?>&btnId=btn<?php echo $k++; ?>" params="lightwindow_width=700,lightwindow_height=350" class="lightwindow page-options" id="btn<?php echo $j++; ?>">
        		<input type="button" name="viewOrder" value="View"/>
        	</a> |
        	<a href="orderDeleteService.php?service_id=<?php echo $data['service_id']; ?>" onclick="return confirm('Are you sure to delete this ???' );">
        		<input type="button" name="delOrder" value="Delete"/></a> |
        		<a href="orderServiceSiap.php?service_id=<?php echo $data['service_id']; ?>">
        					<input type="button" name="delOrder" value="Siap"/></a>
        	
        	</td> 
	</tr>
<?php }?>
</table>

</td></tr>
</table>

<script type="text/javascript">
//$(function() {
	//alert()
	//var a = '<?php if(isset($_REQUEST["btnId"])) echo $_REQUEST["btnId"];?>';
	//document.getElementById(a).click();
	//if ( a ) {
		//console.log($('a#btn0'));
	//}
//})
</script>
	</form>



</div>
<div id="kaki" align="center">Copyright 2015. Electronic Operational Center KIOSK (EOCK)</div>
</body>
</html>