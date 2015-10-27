<?php
error_reporting(E_ALL ^ E_NOTICE);

$sendsize = $_FILES['file']['size'];
$filesize = $_POST['size'];
$tmpfile = $_POST['name'].'_'.$filesize.'.tmp'; //name_size, md5 is best
$startsize = $_POST['start'];

//check last time uploaded
if(file_exists($tmpfile)){
	$tmp_size = filesize($tmpfile);
	if($tmp_size > $startsize){
		echo $filesize-$tmp_size;
		exit;
	}
}

if($_FILES['file']){
	$temp = fopen($_FILES['file']['tmp_name'], "rb");
	$tempdata = fread($temp, $sendsize);
	fclose($temp);
	unlink($_FILES['file']['tmp_name']);

	$file = fopen($tmpfile, "a+");
	fwrite($file, $tempdata);
	fclose($file);

	$tmp_size = filesize($tmpfile);
	if($tmp_size < $filesize){
		echo $filesize-$tmp_size; //return remaining size
	}else{
		rename($tmpfile, $_POST['name']);
		echo 0;
	}
}else{
	echo $filesize;
}
?>