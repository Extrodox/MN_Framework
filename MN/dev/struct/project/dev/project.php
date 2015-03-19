<?php
include 'template2.php';
$project = new TemplateMaker('project');

$project->setName(isset($_POST['name'])?$_POST['name']:null);
$project->setParent(isset($_POST['parent'])?$_POST['parent']:null);

$project->run();
?>