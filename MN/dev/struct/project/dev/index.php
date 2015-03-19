<?php
include 'include/login.php';
include 'include/index_part.php';
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style/style.css">
	<link rel="stylesheet" type="text/css" href="style/index.css">
	<script type="text/javascript" src="js/jquery.min.js"></script>
<style type="text/css">
#<?php echo $li_type; ?>{
	border-right-color: green;
}
#<?php echo $li_type; ?>:hover{
	background: green;
}
</style>
</head>
<body>
<div id="main">
	<div class="first">
	<h1 class="caption">Developer's tool for MN framework.</h1>
	<div class="report">
	   <?php
	   if(isset($_GET['report'])){
		  $report=$_GET['report'];
		  echo $report;
	   }
	?>
    </div>
	<div class="container">
		<div class="left">
			<span>Select module</span>
			<?php include 'include/left/index.php'; ?> <!--  include left side menu  -->
		</div>
		<div class="right">
            <h4>Create new <?php echo str_replace('.php','',$right_file); ?></h4>
			<?php include "include/right/{$right_file}"; ?>
		</div>
	</div>
    </div>
    </div>
<?php include "include/back.php"; ?>
</body>
</html>
