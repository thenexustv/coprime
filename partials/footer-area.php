<?php

	if ( is_active_sidebar('footer-area') ):
	$widgets = Coprime::get_instance()->get_widget_count('footer-area');
	$class = "footer-widgets-{$widgets}";
?>

<div class="footer-area-container <?php echo $class ?>">
	<?php dynamic_sidebar('footer-area'); ?>
</div>

<?php endif; ?>