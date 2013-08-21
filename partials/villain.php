<?php
/* Villain loop */
$episode = Nexus_Episode::factory(get_the_ID());
?>

<article id="item-<?php the_ID(); ?>" role="article" <?php post_class('villain'); ?>>

	<h2><a href="<?php echo $episode->get_permalink(); ?>"><?php echo $episode->get_title(); ?></a></h2>
	<!-- villain stuff -->

</article>