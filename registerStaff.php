<?php 
session_start();
require_once('Conn/dbconn.php');
$usernameError = $passError = $icError = "";

if(isset($_POST['hantar']) && $_SERVER["REQUEST_METHOD"] == "POST")
{
		$username=$_POST['username'];
		$password=$_POST['pass'];
		$password2 = $_POST['pass2'];
		$name=$_POST['name'];
		$BOD=$_POST['BOD'];
		$ic =$_POST['ic'];
		$phone = $_POST['phone'];
		$position = $_POST['position'];
		
		if(empty($username))
		{$usernameError = "Required !";}else
		if($password != $password2)
		{$passError = "Password not same !";}else
		if(empty($ic))
		{$icError = "Required !";}
		
		else{
		
		$sql0 = "SELECT staff_username,staff_ic FROM staff  WHERE staff_username = '$username' and staff_ic = '$ic'" ;	
		$query0 = mysql_query($sql0) or die ("Error: ".mysql_error());
		$row0 = mysql_num_rows($query0);
		$data2 = mysql_fetch_array($query0);
		
		if($row0 != 0)
		{
		?>
		<html>
		<script language="javascript"> alert("Username or Identification Card No. have been use.. !");</script>
		</html>
		<?php
		header("location:registerStaff.php");	
		}
		else
		if($row0 == 0)
		{
			
				$sql  = "INSERT INTO staff ( staff_name, staff_ic, staff_BOD, staff_phone,staff_position,staff_username,staff_password) 
				VALUES( '".$name."', 
						'".$ic. "',
						'".$BOD."',
						'".$phone."',						
						'".$position ."',
						'".$username. "',
						'".$password. "')";
						mysql_query($sql) or die ("Error: ".mysql_error());		
		
		header("location:loginStaff.php");	
		}
		}
		
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EOCK</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/datepickr.css" />
<script type="text/javascript" src="js/datepickr.min.js"></script>
					  
		
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
<!--Ko letak data ko kat sni , nnti dia display kat background putih tuh ..-->
<br />

	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="register" method="post">
	  <table align="center" cellspacing="1" cellpadding="1" width="544" bordercolor="#999999">	  
       <title></title>

        <tr>
          <th colspan="3" bgcolor="#CC9900">Register </th>
        </tr>
       

        <tr>
          <td colspan="3"><p><span style="color:red;"></span>
            <br />
  <h3 align="right">
 
 <center> <p><td><a href="viewStaff.php?"> ADD STAFF <img src="images/addd.png" swidth="15" height="15"/></td>
 <td><a href="viewAllStaff.php">VIEW STAFF <img src="images/addd.png" swidth="15" height="15"/></a></p></td>
          
        </tr>
        
        
        <tr>
        <td>
          </td></tr>
	  </table>
      
  </form>
    
</div>
<div id="kaki" align="center">Copyright 2015. Electronic Operational Center KIOSK (EOCK)</div>

</body>
</html>