<?php
define('DS',DIRECTORY_SEPARATOR);
$right_file = 'sections.php';
$li_type = 'sections';
if(isset($_GET['type']) )
{
	$right_file = $_GET['type'].'.php';
	$li_type = $_GET['type'];
}
function getPages(){
	$pages=glob('..'.DS.'pages'.DS.'*');
	$option="";
	foreach ($pages as $page) {
		$page=basename($page);
		$option.="<option value=\"{$page}\">{$page}</option>";
	}
	return $option;
}
?>