<?php
include 'template2.php';
$logic = new TemplateMaker('logic');

$logic->setName(isset($_POST['name'])?$_POST['name']:null);
$logic->setParent(isset($_POST['parent'])?$_POST['parent']:null);
$logic->run();

?>