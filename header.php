<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=yes">
<title><?php wp_title(''); ?></title>

<!--
      ___           ___           ___                    ___           ___           ___           ___           ___     
     /\  \         /\__\         /\  \                  /\__\         /\  \         |\__\         /\__\         /\  \    
     \:\  \       /:/  /        /::\  \                /::|  |       /::\  \        |:|  |       /:/  /        /::\  \   
      \:\  \     /:/__/        /:/\:\  \              /:|:|  |      /:/\:\  \       |:|  |      /:/  /        /:/\ \  \  
      /::\  \   /::\  \ ___   /::\~\:\  \            /:/|:|  |__   /::\~\:\  \      |:|__|__   /:/  /  ___   _\:\~\ \  \ 
     /:/\:\__\ /:/\:\  /\__\ /:/\:\ \:\__\          /:/ |:| /\__\ /:/\:\ \:\__\ ____/::::\__\ /:/__/  /\__\ /\ \:\ \ \__\
    /:/  \/__/ \/__\:\/:/  / \:\~\:\ \/__/          \/__|:|/:/  / \:\~\:\ \/__/ \::::/~~/~    \:\  \ /:/  / \:\ \:\ \/__/
   /:/  /           \::/  /   \:\ \:\__\                |:/:/  /   \:\ \:\__\    ~~|:|~~|      \:\  /:/  /   \:\ \:\__\  
   \/__/            /:/  /     \:\ \/__/                |::/  /     \:\ \/__/      |:|  |       \:\/:/  /     \:\/:/  /  
                   /:/  /       \:\__\                  /:/  /       \:\__\        |:|  |        \::/  /       \::/  /   
                   \/__/         \/__/                  \/__/         \/__/         \|__|         \/__/         \/__/    
-->

<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

<?php do_action('before_universe'); ?>

<div id="universe">
	
	<?php do_action('before_header'); ?>

	<header id="header-container" role="header">
		<div class="header-wrapper">
			
			<?php do_action('before_identity'); ?>

			<?php get_template_part('partials/identity'); ?>

			<?php do_action('after_identity'); ?>

		</div>
	</header>

	<?php do_action('after_header'); ?>

	<?php do_action('before_galaxy'); ?>

	<main id="galaxy" role="main">