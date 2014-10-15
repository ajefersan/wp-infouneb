<?php
/* 
Template Name: Documentos
*/
 if ( have_posts() ) : ?>
<?php while ( have_posts() ) : the_post(); ?>

	<!DOCTYPE html>
	<html>
	<head>
		<title><?php the_title(); ?></title>
		<link rel="stylesheet" media="all" type="text/css" href="<?php bloginfo('template_url'); ?>/assets/css/docs.css" />
	</head>
	<body>
		<div id="wrapper">
			

			<header>
				<div id="logo"></div>
				<div id="title">
					<h1><?php the_title(); ?></h1>
				</div>
			</header>

			<?php the_content(); ?>

			
		</div>
	</body>
	</html>

<?php endwhile; ?>
<?php endif; ?>