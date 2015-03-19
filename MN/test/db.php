<?php
include "../library/mn/db/config.php";
include "../library/mn/db/class.php";
include "../library/mn/db/row.php";
include "../library/mn/db/query.php";
include "../library/mn/db/table.php";

//geting page names

try{
$x=new MN_Db_Table("meaning",array("name"=>"synoeng"));
$y=$x->newRow();

$y->hemen="asda";

$y->save();

}catch(Exception $e){
	var_dump($e);
	
}