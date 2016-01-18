<?php
session_start();
?>
<?php 
require_once('Conn/dbconn.php');

if( isset($_POST['hantar'] ) && $_SERVER["REQUEST_METHOD"] == "POST" )
{
	extract( $_POST );

	$sql   = "SELECT * FROM students  WHERE student_username = '$student_username' and student_password = '$student_password'" ;
    $query = mysql_query( $sql ) or die ("Error: ".mysql_error());
    $row   = mysql_num_rows( $query );
    $data  = mysql_fetch_array( $query );

	if( $row > 0 ) {

		session_start();
		$data = array(
				'user_id'  => $data['student_id'],
				'username' => $data['student_username'],
				'category' => 'student'
            );
		$_SESSION = $data;
	    header("location:index.php");
		
	}
	else {

		echo '<script language="javascript">';
	    echo 'alert("Incorrect username or password, please try again dear.");';
	    echo 'window.location="loginStudent.php";';
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
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" name="login" >
  <table width="256" height="183" align="center" bgcolor="#CCCCCC">
      <tr><th align="center">Student Login</th></tr>
      <tr>
        <td width="97" colspan="2">Username</td>
      </tr>                    
      <tr>
      	 <td width="192" colspan="2"><input type="text" name="student_username" size="30" autocomplete="off"></td>
      </tr>
      <tr>
        <td colspan="2">Password</td>
      </tr>
      <tr>  
        <td colspan="2"><input type="password" name="student_password" size="30"></td>
      </tr>                   
      <tr>
        <td height="5" colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" colspan="2"><input type="submit"  name="hantar" value="Sign In" ></td>
      </tr>
      <tr>
        <td height="5">&nbsp;</td>
      </tr>
    </table>
</form>
	 
</div>
<div id="kaki" align="center">Copyright 2015. Electronic Operational Center KIOSK (EOCK)</div>

</body>
</html>