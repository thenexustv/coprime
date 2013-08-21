<?php
/* Showboard loop */
$episode = Nexus_Episode::factory(get_the_ID());
?>

<article id="item-<?php the_ID(); ?>" role="article" <?php post_class('showboard'); ?>>

	<a><img src /></a>
	<h3><a href="<?php echo $episode->get_permalink(); ?>"><?php echo $episode->get_title(); ?></a></h3>
	<!-- show name - # ep -->
	<!-- show date - new state -->

</article>