<?php 
session_start();

require_once('Conn/dbconn.php');
/*$sql = "SELECT * FROM `product` where product_category='Food'";
	$query = mysql_query($sql) or die("MySQL Error: " . mysql_error());	
	$row = mysql_num_rows($query);
		
		$i = 0;
  		while($data = mysql_fetch_array($query))
		{
		
	$id[$i] = $data['product_id'];
	$name[$i] = $data['product_name'];
	$category[$i] = $data['product_category'];
	$priceUnit[$i] = $data['product_priceUnit'];
	$stock[$i] = $data['product_stock'];
	$i++;
	
		}
		*/
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EOCK</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
</head>

<body>
<?php include( 'header.php' ); ?>
        <div id="header2">
            
        </div>
        </div>
	<div id="backgroundMenu">
    <?php include( 'menuExternal.php' ); ?>
	</div>
</div>  

<div id="content">
<center><h2>List of Department</h2></center>
<br />
<form action="studentServicesUploadForm.php?cat=<?php echo $_REQUEST['cat']; ?>" method="post" name="orderBoh">
<table width="720" align="center" bordercolor="#FF9900">
	<tr>
		<td width="566">
			<table width="698" align="center"  cellpadding="2" cellspacing="2">
				<tr bgcolor="#FF9900">
					
					<th width="33">No.</th>
					<th width="229">Department</th>
				</tr>
				<tr style="overflow:scroll;">
			        <td align="center"><input type="checkbox" name="id[]" value="jtmk" /> 1</td>
					<td align="center">Jabatan teknologi Maklumat Dan Komunikasi</td>	
				</tr>
				<tr style="overflow:scroll;">
			        <td align="center"><input type="checkbox" name="id[]" value="jke" /> 2</td>
					<td align="center">Jabatan Kejuteraan Elektrik</td>	
				</tr>
				<tr style="overflow:scroll;">
			        <td align="center"><input type="checkbox" name="id[]" value="jkm" /> 3</td>
					<td align="center">Jabatan Kejuteraan Mekanikal</td>	
				</tr>
				<tr style="overflow:scroll;">
			        <td align="center"><input type="checkbox" name="id[]" value="jka" /> 4</td>
					<td align="center">Jabatan Kejuteraan Awam </td>	
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td  align="center">
			<input type="hidden" name="cat" value="<?php echo $_REQUEST['cat']; ?>"/>
			<input type="submit" name="orderProduct" value="Submit"/>
		</td>
	</tr>
</table>
	</form>
<script type="text/javascript">
	$(function () {
		$( '[name="id[]"]').click(function(){
			$( '[name="id[]"]').attr('checked', false );
			$( this ).attr('checked', true );
		});
	});
</script>


</div>
<div id="kaki" align="center">Copyright 2015. Electronic Operational Center KIOSK (EOCK)</div>
</body>
</html>