<?php
include 'template2.php';
$form = new TemplateMaker('form');

$form->setName(isset($_POST['name'])?$_POST['name']:null);
$form->setParent(isset($_POST['parent'])?$_POST['parent']:null);
$form->run();

?>
 