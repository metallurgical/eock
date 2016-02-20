<?php 
if (!isset($_SESSION)) {
  session_start();
}
require_once('Conn/dbconn.php');
//require_once('menu.php');

if ( isset( $_GET['d'] ) ) {
  $sql = "SELECT * FROM `staff` where staff_id = '".$_GET['d']."'";
}
else {
  $sql = "SELECT * FROM `staff` where staff_ic = '".$_SESSION['UserIC']."'";
}

$query    = mysql_query($sql) or die("MySQL Error: " . mysql_error());	
$data     = mysql_fetch_assoc($query);
$id       = $data['staff_id'];
$name     = $data['staff_name'];
$BOD      = $data['staff_BOD'];
$phone    = $data['staff_phone'];
$position = $data['staff_position'];
$password = $data['staff_password'];
	
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
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" name="profileUpdate">
      <table width="312" border="0" align="center">  
      <tr><th colspan="3" bgcolor="#999999">My Profile</th></tr> 
        <tr><th colspan="3" >&nbsp;</th></tr>  
        <tr>
          <td width="91">Name</td>
          <td width="12">:</td>
          <td width="195">                        
          <label><?php echo $name; ?></label>
           </td>
        </tr>
        
        <tr>
          <td width="91">Password</td>
          <td width="12">:</td>
          <td width="195">                        
          <label><?php echo $password; ?></label>
           </td>
        </tr>
        <tr>
          <td width="91">Birth of date</td>
          <td width="12">:</td>
          <td width="195">                        
          <label><?php echo $BOD; ?></label>
           </td>
        </tr>
        
        <tr>
          <td width="91">No. phone</td>
          <td width="12">:</td>
          <td width="195">                        
          <label>0<?php echo $phone; ?></label>
           </td>
        </tr>
        
        <tr>
          <td width="91">Position</td>
          <td width="12">:</td>
          <td width="195">                        
          <label><?php echo $position; ?></label>
           </td>
        </tr>
        
        <tr><td colspan="3" align="center"><a href="profileStaffEdit.php?d=<?php echo $id;?>"><input type="button" name="updateProfile" value="Update" /></a></td></tr>
      </table>
     </form>

</div>
<div id="kaki" align="center">Copyright 2014. Electronic Operational Center KIOSK (EOCK)</div>
</body>
</html>
