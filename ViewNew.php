<?php
if (!isset($_SESSION)) {
  session_start();
}
require_once('Conn/dbconn.php');

$no =1;

//code for search function
if(isset($_POST['btn_search'])) {
	$txt_search = $_POST['txt_search'];
	$qs = "select * from staff where staff_id like '%$txt_search%'";
	$qs1 = mysql_query($qs) or die("sql error".$qs);
	$no_result = mysql_num_rows($qs1);
} else {
	$qs = "select * from staff order by staff_id desc";
	$qs1 = mysql_query($qs)  or die("sql error".$qs);
	$no_result = mysql_num_rows($qs1);
}

//display msg
$msg = $_GET['msg'];

switch($msg) {
	case "del": $not = "1 record successfully deleted"; break;
	case "edit": $not = "1 record successfully update"; break;
	default : $not ="";
}
?>
<?php include("menu.php");?>
<center>
<table>
<form name="frm search" action="" method="POST">

<tr>
<table width="40%" border="0" cellspacing="1" cellpadding="1" align="center">
<form name="frm search" action="" method="post">
  <tr bgcolor="#CC99CC">
    <td colspan="2">Search Staff</td>
  </tr>
  <tr>
    <td>Enter Staff No</td>
    <td><label for="textfield"></label>
    <input type="text" name="txt_search" id="textfield" /> <input type="submit" name="btn_search" value="Search" /></td>
  </tr>
  <tr bgcolor="#CC99CC">
    <td colspan="2">&nbsp;</td>
  </tr>
  </form>
</table>
<table align="center"> 
<tr bgcolor="#00FF66"> <td> <?php echo strtoupper($not);?></td></tr>
</table>
<p> 
<?php if($no_result > 0 ) { ?>
<table width="67%" border="1" align="center" cellpadding="1" cellspacing="1">
  <tr align="center" bgcolor="#00CCCC">
    <td width="4%"><strong>No.</strong></td>
    <td width="25%"><strong>Name / ID</strong></td>
    <td width="31%"><strong>Phone No</strong></td>
    <td width="13%"><strong>Email</strong></td>
    <td width="27%"><a href="add.php">Add Staff</a></td>
  </tr>
  <?php while($d1 = mysql_fetch_array($qs1)) {
	    extract($d1);
	  ?>
  <tr>
    <td><?php echo $no++;?>.</td>
    <td><a href="edit.php?id_edit=<?php echo $s_id;?>"><img src="image/<?php echo $pic;?>" width="30" height="30" /><br /><?php echo $s_id."-".$name;?> </a></td>
    <td><?php echo $phone;?></td>
    <td><?php echo $email;?></td>
    <td><a href="edit.php?id_edit=<?php echo $s_id;?>">Edit</a>  &nbsp; <a href="javascript:check(<?php echo $s_id; ?>)"> Delete </a> </td>
  </tr> <?php } ?>
 
</table>

  <?php } ?>
<script type="text/javascript" >
function check(nilai)
{
	//alert("masuk");
	if(confirm('Are you sure to delete this record?'))
	{  
   document.location.href = "delete.php?id_delete=" + nilai; 
   }

}
</script>