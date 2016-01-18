<?php if (!isset($_SESSION)) {
  session_start();
}
require_once('Conn/dbconn.php');

if(isset($_POST['hantar']) && $_SERVER["REQUEST_METHOD"] == "POST")
{
	//retrive from form1
    $user        = $_POST['login']; 
    $password    = $_POST['pass']; 
    
    //SQL injection
    $myusername  = stripslashes($user);
    $mypassword  = stripslashes($password);	
    $myusername  = mysql_real_escape_string($myusername);
    $mypassword  = mysql_real_escape_string($mypassword);	

    if ( $_POST['loginAs'] == 'staff' ) {

      $sqlLogin    = "SELECT staff_name,staff_ic,staff_position,staff_id FROM staff WHERE staff_username='$myusername' and staff_password='$mypassword'";
      $result      = mysql_query($sqlLogin);
      $foundUserAD = mysql_num_rows($result);
      $dataAd      = mysql_fetch_assoc($result);
      $nme         = $dataAd['staff_name'];
      $ic          = $dataAd['staff_ic'];

      if($foundUserAD==1){

        $_SESSION['UserName'] = $nme;
        $_SESSION['username'] = $nme;
        $_SESSION['UserIC']   = $ic;
        $_SESSION['user_id']  = $dataAd['staff_id'];
        $_SESSION['category'] = $dataAd['staff_position']; 
        header("Location:home.php");

       }
       else {

          echo '<script language="javascript">';
          echo 'alert("Incorrect username or password, please try again dear.");';
          echo 'window.location="loginStaff.php";';
          echo '</script>'; 

       }

    }
    elseif ( $_POST['loginAs'] == 'student') {

      $sql   = "SELECT * FROM students  WHERE student_username = '$myusername' and student_password = '$mypassword'" ;
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
          echo 'window.location="loginStaff.php";';
          echo '</script>';   
          
      }
    }
    
    
  	
  	
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EOCK</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />

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
<br />
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" name="login" >
  <table width="256" height="183" align="center" bgcolor="#CCCCCC">
      <tr><th align="center">Login</th></tr>
      <tr>
        <td width="97" colspan="2">Username</td>
      </tr>                    
      <tr>
      	 <td width="192" colspan="2"><input type="text" name="login" size="30" autocomplete="off"></td>
      </tr>
      <tr>
        <td colspan="2">Password</td>
      </tr>
      <tr>  
        <td colspan="2"><input type="password" name="pass" size="30"></td>
      </tr>
      <tr>
        <td colspan="2">Login as</td>
      </tr>
      <tr> 
        <td colspan="2"> 
          <select name="loginAs">
            <option value="">--Please Select--</option>
            <option value="staff">Staff</option>
            <option value="student">Student</option>
          </select>
        </td>
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