<?php
Function setMenu(){

	if(isset($_SESSION['UserName']))
	{
	include("menuStaff.php");
	}
	
}
?>