<?php
session_start();


require_once('Conn/dbconn.php');

if( isset( $_POST['hantar'] ) && $_SERVER["REQUEST_METHOD"] == "POST" ) {

  extract( $_POST );

  if ( empty( $student_username ) ){ 
    $usernameError = "Required !";
  } 
  else if ( $student_password != $cstudent_password ) {
    $passError = "Password not match !";
  } 
  else if( empty( $student_ic ) ) {
    $icError = "Required !";
  }   
  else {


    $sql01   = "SELECT * FROM `students`  WHERE `student_noMatric` = '$student_noMatric'" ; 
    $query01 = mysql_query( $sql01 ) or die ("Error: ".mysql_error());
    $row01   = mysql_num_rows( $query01 );

	  if ( $row01 > 0 ) {
      //echo 's';
      echo '<script type="text/javascript">';
      echo 'alert("Matric No. have been use.. !");';
      echo 'window.location="registerStudent.php";';
      echo '</script>';
    }
    else {

    
      $sql0   = "SELECT * FROM students  WHERE student_username = '$student_username' AND student_password = '$student_password'" ; 
      $query0 = mysql_query( $sql0 ) or die ("Error: ".mysql_error());
      $row0   = mysql_num_rows( $query0 );
      $data2  = mysql_fetch_array( $query0 );
      
        if( $row0 > 0 ) {
          echo '<script type="text/javascript">';
          echo 'alert("Username or Password have been use.. !");';
          echo 'window.location="registerStudent.php";';
          echo '</script>';
        }
        else {
          
            $sql  = "INSERT INTO students ( 
                          student_username, 
                          student_password,
                          student_ic,
                          student_noMatric,
                          student_name,
                          student_phone
                      ) VALUES( 
                          '".$student_username."', 
                          '".$student_password. "',
                          '".$student_ic."',
                          '".$student_noMatric."',            
                          '".$student_name ."',
                          '".$student_phone. "')";

            mysql_query($sql) or die ("Error: ".mysql_error());
            echo '<script type="text/javascript">';
            echo 'alert("Successfull register !");';
            echo 'window.location="loginStaff.php";';
            echo '</script>';
            //header("location:loginStaff.php");  
        }

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
          <th colspan="3" bgcolor="#CC9900">Student Registration Form</th>
        </tr>
       

        <tr>
          <td colspan="3"><span style="color:red;">* required field</span>
           <br />
<h3 align="right"><!-- <a href="addStaff.php?bil=<?php echo $row1['bil']; ?>"> ADD STAFF <img src="images/addd.png" swidth="15" height="15"/></a> --></b></td>
        </tr>
        <tr>
        <td>
            <table align="center" cellpadding="3" cellspacing="3">
              <tr>
                <td>Username</td>
                <td>:</td>
                <td><input type="text" name="student_username" required/><span style="color:red;">* <?php if ( isset( $usernameError ) ) echo $usernameError; ?></span></td>
              </tr>
              <tr>
                <td>Password</td>
                <td>:</td>
                <td><input type="password" name="student_password" required/><span style="color:red;">* </span></td>
              </tr>
              <tr>
                <td>Re-type password</td>
                <td>:</td>
                <td><input type="password" name="cstudent_password" required/><span style="color:red;">* <?php if ( isset( $passError ) ) echo $passError; ?></span></td>
              </tr>
              <tr>
                <td>Name</td>
                <td>:</td>
                <td><input type="text" name="student_name" required/></td>
              </tr>
              <tr>
                <td>Identification Card( IC )</td>
                <td>:</td>
                <td><input type="text" name="student_ic" required/><span style="color:red;">* <?php if ( isset( $icError ) ) echo $icError; ?></span></td>
              </tr>
              <tr>
                <td>Matric No</td>
                <td>:</td>
                <td><input type="text" name="student_noMatric" required/></td>
              </tr>                    
              <tr>
                <td>Phone</td>
                <td>:</td>
                <td><input type="text" name="student_phone" placeholder="0117659578" required/></td>
              </tr>                    
              <tr>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="3" align="center"><input type="submit" name="hantar" value=" S U B M I T " /></td>
              </tr>
              <tr>
                <td colspan="3">&nbsp;</td>
              </tr>
            </table>
          </td></tr>
	  </table>
      
  </form>
    
</div>
<div id="kaki" align="center">Copyright 2015. Electronic Operational Center KIOSK (EOCK)</div>

</body>
</html>