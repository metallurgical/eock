<?php 
session_start();
require_once('Conn/dbconn.php');
if(isset($_GET['a']))
{	$idd =$_GET['a']; 

	/*#source : http://php.net/manual/en/function.mcrypt-encrypt.php
	$key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
	 $ivsize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
	$ivV = mcrypt_create_iv($ivsize, MCRYPT_RAND);
	$ciphertext_dec = base64_decode($idd);
   
	
    # retrieves the IV, iv_size should be created using mcrypt_get_iv_size()
    $iv_dec = substr($ciphertext_dec, 0, $ivsize);
    # retrieves the cipher text (everything except the $iv_size in the front)
    $ciphertext = substr($ciphertext_dec, $ivsize);

    # may remove 00h valued characters from end of plain text
    $plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,
                                    $ciphertext, MCRYPT_MODE_CBC, $iv_dec);*/
	$sql123 = "SELECT order_id,student_id FROM `order` 
			   WHERE order_id='$idd'";	
	$query123 = mysql_query($sql123) or die ("Error: ".mysql_error());	
	$data = mysql_fetch_assoc($query123);
	$id = $data['order_id'];

    $sqlst = "SELECT * FROM `students` 
               WHERE student_id='".$data['student_id']."'";    
    $queryst = mysql_query($sqlst) or die ("Error: ".mysql_error());  
    $datast = mysql_fetch_assoc($queryst);


	$matrix = $datast['student_noMatric'];
	$name = $datast['student_name'];
	$phone = $datast['student_phone'];
	

?>
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
 <table align="center" cellspacing="1" cellpadding="1" width="344" bordercolor="#999999">	  
       
        <tr>
          <th colspan="4" bgcolor="#999999">Resit Order</th>
        </tr>
        <tr>
        	<td width="144">Order ID</td>
            <td colspan="3">: &nbsp;<label><?php echo $id;?></label></td>
        </tr>
        <tr>
        	<td width="144">Name</td>
            <td colspan="3">: &nbsp;<label><?php echo $name;?></label></td>
        </tr>
        <tr>
        	<td>No. Matric</td>
            <td colspan="3">: &nbsp;<label><?php echo $matrix;?></label></td>
        </tr>
        <tr>
        	<td>No. Phone</td>
            <td colspan="3">: &nbsp;<label>0<?php echo $phone;?></label></td>
        </tr>
        <tr><td colspan="3">&nbsp;</td></tr>
</table>
   

</div>
<div id="kaki" align="center">Copyright 2014. Electronic Operational Center KIOSK (EOCK)</div>
</body>
</html><?php }?>