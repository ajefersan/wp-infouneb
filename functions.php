<?php
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'wlwmanifest_link');
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'index_rel_link');
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );

	add_filter( 'show_admin_bar', '__return_false' );

	$modulos = array('oevento', 'novaprogramacao', 'inscricao', 'patrocinadores');

	include_once "plugin/Inscricoes.php";
