<!doctype html>
<html>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title><?php
            global $page, $paged;

            wp_title( '|', true, 'right' );

            bloginfo( 'name' );
                   
            $site_description = get_bloginfo( 'description', 'display' );

            if ( $site_description && ( is_home() || is_front_page() ) )
                echo " | $site_description";
            if ( $paged >= 2 || $page >= 2 )
                echo ' | ' . sprintf( __( 'Página %s', 'twentyten' ), max( $paged, $page ) );
        ?></title>

        <meta name="description" content="<?php bloginfo( 'description'); ?>">
        <meta name = "viewport" content = "width=device-width, user-scalable = no, initial-scale=1">

		<link rel="stylesheet" href="<?php bloginfo( 'template_url' ); ?>/assets/css/base.css">
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>

		<div id="navigation">
			<nav>
			    <ul>
			    	<li><a href="https://twitter.com/infouneb" target="_blank"><span class="social fa fa-twitter"></span></a></li>
					<li><a href="https://www.facebook.com/InfoUNEB" target="_blank"><span class="social fa fa-facebook"></span></a></li>
			        <li><a href="#" class="menu"><span class="fa fa-bars"></span> Menu</a>
			            <ul>
			                <li><a href="#oevento">O Evento</a></li>
			                <li><a href="#programacao">Programação</a></li>
			                <li><a href="#inscricao">Inscrição</a></li>
			                <!-- <li><a href="#patrocinadores">Patrocinadores</a></li> -->
			            </ul>
			        </li>
			        
			    </ul>
			</nav>
		</div>

		<div id="header">
			<div id="logo"></div>
			<div class="info">
				<h1>24 a 28 de novembro</h1>
				
				<h2>Existe muito mais no sucesso profissional<br /> do que o conhecimento técnico</h2>
				<p>Computação e tendências, startups e carreira profissional.</p>
			</div>
		</div>

		<?php 
			foreach ($modulos as $value) {
				include 'pages/page_' . $value . '.php';
			}
		 ?>

 		<div id="footer">
			<div class="wrapper">
				<div class="infouneb-logo"></div>
				<p>
					Realização: CASI - Centro Acadêmico de Sistemas de Informação. <br />
				Apoio: <a href="http://www.consultjr.uneb.br">Consult Jr</a> e <a href="http://www.acso.uneb.br">ACSO</a>.<br />
				Design por <a href="http://www.guirodrigues.com.br">Gui Rodrigues</a>
				</p>
			</div>
		</div>
		
		<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/assets/js/jquery.js"></script>
		<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/assets/js/parallax.js"></script>
		<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/assets/js/detect.js"></script>
		<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/assets/js/scrollto.js"></script>
		<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/assets/js/smoothscroll.js"></script>
		<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/assets/js/validate.js"></script>
		<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/assets/js/messages.js"></script>
		<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/assets/js/maskedinput.js"></script>
		<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/assets/js/main.js"></script>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-53539968-2', 'auto');
		  ga('send', 'pageview');

		</script>
		<?php wp_footer(); ?>
	</body>
</html>