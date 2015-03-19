<?php

include 'template2.php';
$pages = new TemplateMaker('pages');

$pages->setName(isset($_POST['name'])?$_POST['name']:null);
$pages->setParent(isset($_POST['parent'])?$_POST['parent']:'');
$pages->run();

?>
