<?php 
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');
require_once('Conn/dbconn.php');
$jabatan = isset( $_REQUEST['id'][0] ) ? $_REQUEST['id'][0] : $_REQUEST['jabatan'];

if ( isset( $_POST['hantar'] ) ) {
	extract($_POST);
	$name     = $_FILES['myFile']['name'];
	$size     = $_FILES['myFile']['size'];
	$type     = $_FILES['myFile']['type'];
	$tmp_name = $_FILES['myFile']['tmp_name'];

	$h        = fopen($tmp_name, 'r');
	$content  = fread($h, filesize($tmp_name));
	$content1 = addslashes($content);
	fclose($h);

	if(($type=="image/jpeg")||($type=="image/png")||($type=="image/bmp")||($type=="image/gif"))	{
		echo '<script type="text/javascript">';
      	echo 'alert("This type of file are not allowed !");';
     	echo 'window.location="studentServicesUploadForm.php";';
      	echo '</script>';
	}
	else {

		if ( !isset( $_REQUEST['lastId'] ) ) {
			$sql  = "INSERT INTO services ( 
                          student_id, 
                          service_jabatan,
                          service_copy,
                          service_cat,
                          service_status,
                          servis_date_created
                      ) VALUES( 
                          '".$_SESSION['user_id']."', 
                          '".$jabatan. "',
                          '".$service_copy."',
                          '".$cat."',
                          '0',
                          '".date('Y-m-d H:i:s')."')";
			mysql_query($sql) or die ("Error: ".mysql_error());

			$lastId = mysql_insert_id();

      $datassss=mysql_fetch_assoc(mysql_query("select student_noMatric from `students` where student_id = '".$_SESSION['user_id']."'"));

        $sm = $datassss['student_noMatric'];

        require 'phpmailer/PHPMailerAutoload.php';
        $mail = new PHPMailer;
        $body = "Service have been ordered by Student with Matric No $sm at ".date('d-m-y H:i:s');
        $mail->SMTPAuth = true; 
        $mail->Host = "smtp.mail.yahoo.com";
        $mail->Port = 587; 
        $mail->Username = "alamat_email_yahoo"; // ubah hok ni
        $mail->Password = "password_email_yahoo"; // ubah hok ni
        $mail->isSMTP();
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->setFrom('alamat_email_yahoo', 'Student'); // ubah hok ni
        $mail->addReplyTo('alamat_email_yahoo', 'First Last'); // ubah hok ni
        $mail->addAddress('alamat_email_gmail', 'Administrator'); // ubah hok ni
        $mail->Subject = 'New message from student order[product]'; 
        $mail->MsgHTML($body);
        $mail->send();

		}
		else {
			$lastId = $_REQUEST['lastId'];
		}
		

		$sql1  = "INSERT INTO service_files ( 
                          service_id, 
                          service_file_name,
                          service_file_size,
                          service_file_type,
                          service_file_content
                      ) VALUES( 
                          '".$lastId."', 
                          '".$name. "',
                          '".$size."',
                          '".$type."',
                          '".$content1."')";

        mysql_query($sql1) or die ("Error: ".mysql_error());

        echo '<script type="text/javascript">';
        echo 'alert("Successfull upload !");';
        echo 'window.location="studentServicesUploadForm.php?cat='.$cat.'&jabatan='.$jabatan.'&lastId='.$lastId.'";';
        echo '</script>';

	}
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
<center><h2>Upload</h2></center>
<br />
<form action="" name="register" method="post" enctype="multipart/form-data">
	  <table align="center" cellspacing="1" cellpadding="1" width="544" bordercolor="#999999">	  
       <title></title>

        <tr>
          <th colspan="3" bgcolor="#CC9900">Upload Form</th>
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
                <td><input type="text" name="service_copy" required/></td>
              </tr>
                                
              <tr>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="3" align="center">
                	<input type="hidden" name="cat" value="<?php echo $_REQUEST['cat']; ?>"/>
                	<input type="hidden" name="jabatan" value="<?php echo $jabatan; ?>"/>
                	<?php
                	if ( isset($_REQUEST['lastId'])) {?>
                		<input type="hidden" name="lastId" value="<?php echo $_REQUEST['lastId']; ?>"/>
                	<?php } ?>
                	<input type="submit" name="hantar" value=" S U B M I T " />
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