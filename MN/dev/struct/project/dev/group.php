<?php
include 'template2.php';
$group = new TemplateMaker('group');

$group->setName(isset($_POST['name'])?$_POST['name']:null);
$group->setParent(isset($_POST['parent'])?$_POST['parent']:'');
$group->run();

?>