<?php

require_once('Conn/dbconn.php');

$id    = $_GET['service_file_id'];

$mm    = @mysql_query("select * from service_files where service_file_id='$id'")or die (@mysql_error());
$kk    = @mysql_fetch_array($mm);
$name1 = $kk['service_file_name'];
$name2 = preg_replace('/\s+/','',$name1);

header("Content-Disposition:attachment; filename=".$name2);
header("Content-type:".$kk['service_file_type']); 
header("Content-lenght:".$kk['service_file_size']);

echo $kk['service_file_content'];

?>