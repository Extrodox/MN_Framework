<?php
define("DS",DIRECTORY_SEPARATOR);
define("APPLICATON_PATH",'');
define("AP",APPLICATON_PATH);
define("PAGE_NOT_FOUND","notfound");


include "library/mn/autocontroller/path.php";
include "library/mn/config/class.php";
include "library/mn/debug/class.php";
include "library/mn/namespace/class.php";
include "library/mn/autoloader/class.php";

//geting page names
$app=new MN_App_Class();
$app->run();