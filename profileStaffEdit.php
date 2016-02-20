<?php 
if (!isset($_SESSION)) {
  session_start();
}
require_once('Conn/dbconn.php');
//require_once('menu.php');
//if( isset( $_REQUEST['d'] ))
//{
	
	$id = $_REQUEST['d'];
	
	$sql = "SELECT * FROM `staff` where staff_id = '$id'";
	$query = mysql_query($sql) or die("MySQL Error: " . mysql_error());	
	$data = mysql_fetch_assoc($query);
	
  $name     = $data['staff_name'];
  $BOD      = $data['staff_BOD'];
  $phone    = $data['staff_phone'];
  $position = $data['staff_position'];
  $password = $data['staff_password'];

	if(isset($_POST['hantar']) && $_SERVER["REQUEST_METHOD"] == "POST")
	{
    $nme   = $_POST['name'];
    $bod   = $_POST['BOD'];
    $Phone = $_POST['phone'];
    $posi  = $_POST['position'];
    $pas   = $_POST['password'];
    $pas2  = $_POST['password2'];
		
		if($pas == $pas2){
		
    		$sql0 = "UPDATE staff set staff_name = '$nme',staff_BOD = '$bod', staff_phone = '$Phone', staff_position = '$posi', staff_password = '$pas' where staff_id = '".$id."'" ;	
    		$query0 = mysql_query($sql0) or die ("Error: ".mysql_error());
  		  echo '<script language="javascript">';
        echo 'alert("Profile have been updated .. !.");';
        echo 'window.location="profileStaff.php?d='.$id.'";';
        echo '</script>';
		
		}

		else {?><script>alert("Please make sure you re-type password is same.");</script><?php }
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EOCK</title>
	<!-- CSS -->
	<link href="css/style.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="css/datepickr.css" />
<script type="text/javascript" src="js/datepickr.min.js"></script>
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
<br />
    <form action="" method="post" name="profileUpdate">
      <table width="312" border="0" align="center">  
      <tr><th colspan="3" bgcolor="#999999">Update Profile</th></tr> 
        <tr><th colspan="3" >&nbsp;</th></tr>  
        <tr>
          <td width="91">Name</td>
          <td width="12">:</td>
          <td width="195">                        
          <input type="text" name="name" value="<?php echo $name; ?>"/>
           </td>
        </tr>
        
        <tr>
          <td width="91">Password</td>
          <td width="12">:</td>
          <td width="195">                        
          <input type="text" name="password" value="<?php echo $password; ?>"/>
           </td>
        </tr>
        
        <tr>
          <td width="91">Re-type Password</td>
          <td width="12">:</td>
          <td width="195">                        
          <input type="text" name="password2" value="<?php echo $password; ?>"/>
           </td>
        </tr>
        
        <tr>
          <td width="91">Birth of date</td>
          <td width="12">:</td>
          <td width="195">                        
          <input type="text" name="BOD" id="BOD" value="<?php echo $BOD; ?>"/>
          <script type="text/javascript">
						new datepickr('BOD', {
				'dateFormat': 'Y-m-d'
			});
						</script>
           </td>
        </tr>
        
        <tr>
          <td width="91">No. phone</td>
          <td width="12">:</td>
          <td width="195">                        
          <input type="text" name="phone" value="0<?php echo $phone; ?>"/>
           </td>
        </tr>
        
        <tr>
          <td width="91">Position</td>
          <td width="12">:</td>
          <td width="195">                        
          <input type="text" name="position" value="<?php echo $position; ?>"/>
           </td>
        </tr>
        
        <tr><td colspan="3" align="center"><input type="submit" name="hantar" value="Update" /></td></tr>
      </table>
     </form>

</div>
<div id="kaki" align="center">Copyright 2014. Electronic Operational Center KIOSK (EOCK)</div> 
</body>
</html>
