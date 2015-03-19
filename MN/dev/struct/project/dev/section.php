<?php
include 'template2.php';
$section = new TemplateMaker('sections');

$section->setName(isset($_POST['name'])?$_POST['name']:null);
$section->setParent(isset($_POST['parent'])?$_POST['parent']:null);
$section->run();

?>
 