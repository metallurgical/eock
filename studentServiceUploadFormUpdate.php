<?php 
session_start();

require_once('Conn/dbconn.php');
//$jabatan = isset( $_REQUEST['id'][0] ) ? $_REQUEST['id'][0] : $_REQUEST['jabatan'];

if ( isset( $_POST['hantar'] ) ) {

	extract( $_POST );

  if ( $_FILES['myFile']['name'] == "" ) {

    $sql  = "UPDATE services set
                service_copy = '".$service_copy."' 
                WHERE service_id = '".$service_id."'";
      mysql_query($sql) or die ("Error: ".mysql_error());

  }
  else {

    $name     = $_FILES['myFile']['name'];
    $size     = $_FILES['myFile']['size'];
    $type     = $_FILES['myFile']['type'];
    $tmp_name = $_FILES['myFile']['tmp_name'];

    $h        = fopen($tmp_name, 'r');
    $content  = fread($h, filesize($tmp_name));
    $content1 = addslashes($content);
    fclose($h);

    if(($type=="image/jpeg")||($type=="image/png")||($type=="image/bmp")||($type=="image/gif")) {
      echo '<script type="text/javascript">';
      echo 'alert("This type of file are not allowed !");';
      echo 'window.location="studentServicesUploadForm.php";';
      echo '</script>';
    }

      $sql  = "UPDATE services set
                service_copy = '".$service_copy."' 
                WHERE service_id = '".$service_id."'";
      mysql_query($sql) or die ("Error: ".mysql_error());

      $sql1  = "UPDATE service_files SET
                          service_file_name = '".$name. "',
                          service_file_size = '".$size."',
                          service_file_type = '".$type."',
                          service_file_content = '".$content1."'
                  WHERE service_file_id = '".$service_file_id."'";

        mysql_query($sql1) or die ("Error: ".mysql_error());
  
  }

	


  echo '<script type="text/javascript">';
  echo 'alert("Successfull Updated !");';
  echo 'window.location="myServices.php";';
  echo '</script>';

}

		
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
<center><h2>Edit Uploaded File</h2></center>
<br />
<form action="" name="register" method="post" enctype="multipart/form-data">
<?php
if ( isset($_REQUEST['service_id'] ) ) {

  $sel = mysql_query('SELECT *FROM services WHERE service_id = "'.$_REQUEST['service_id'].'"');
  $getSel = mysql_fetch_array( $sel );
}?>
	  <table align="center" cellspacing="1" cellpadding="1" width="544" bordercolor="#999999">	  
       <title></title>

        <tr>
          <th colspan="3" bgcolor="#CC9900">Upload Form Edit</th>
        </tr>
       
        <tr>
        <td>
            <table align="center" cellpadding="3" cellspacing="3">
              <tr>
                <td>Choose File</td>
                <td>:</td>
                <td><input type="file" name="myFile"></td>
              </tr>
              <tr>
                <td>No of Copy</td>
                <td>:</td>
                <td><input type="text" name="service_copy" value="<?php echo $getSel['service_copy']; ?>" /></td>
              </tr>
                                
              <tr>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="3" align="center">
                	<input type="hidden" name="service_id" value="<?php echo $_REQUEST['service_id']; ?>"/>
                  <input type="hidden" name="service_file_id" value="<?php echo $_REQUEST['service_file_id']; ?>"/>
                	<input type="submit" name="hantar" value=" SAVE " />
                </td>
              </tr>
              <tr>
                <td colspan="3">&nbsp;</td>
              </tr>
            </table>
          </td></tr>
	  </table>
      
  </form>
<!-- <form action="studentServicesUploadForm.php" method="post" name="orderBoh">
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
	</form> -->
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