<?php
/* Header / identity */
?>
<div class="identity">
	<div class="identity-wrapper">

		<?php
			if (is_home() || is_front_page()):
				$primary_tag = 'h1';
				$secondary_tag = 'h2';
			else:
				$primary_tag = 'div';
				$secondary_tag = 'div';
			endif;
			$url = get_bloginfo('url');
			$name = get_bloginfo('name');
			$description = get_bloginfo('description');
		?>

			<div id="site-logo"><span class="logo"></span></div>
			<<?php echo $primary_tag; ?> id="site-title">
				<span class="nexus-title"><a title="<?php echo esc_attr($name); ?>" href="<?php echo esc_attr($url); ?>"><?php echo $name; ?></a></span>
			</<?php echo $primary_tag; ?>>
			<<?php echo $secondary_tag; ?> id="site-description">
				<?php echo $description; ?>
			</<?php echo $secondary_tag; ?>>
			
			<?php do_action('in_identity'); ?>	
			
	</div>
</div>
