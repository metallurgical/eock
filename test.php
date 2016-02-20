<?php

$name = "Muhamad Firdaus Abdul Rahman";
$ic = "911029-14-5455";
$matrix = "19191";

$file = fopen("$matrix.txt","w");
echo fwrite($file,"$name\r\n$ic");
fclose($file);

/*?>echo file_put_contents("$matrix.txt","$name\r\n$ic",FILE_APPEND);<?php */?>

<?php echo print_r(file("$matrix.txt"));?>

