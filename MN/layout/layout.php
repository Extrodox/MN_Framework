<!DOCTYPE html>
<html>
	<head>
		<title>MN Framework</title>
		<?php $this->get_section_headlink(); ?>
	</head>
	<body>
		<header>
			<?php $this->get_section_header(); ?>
		</header>
		<main>
			<?php $this->content(); ?>
			<?php $this->get_section_back(); ?>
		</main>
		<footer>
			<?php $this->get_section_footer(); ?>
		</footer>
	</body>
</html>

