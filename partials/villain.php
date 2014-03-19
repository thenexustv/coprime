<?php
/* Villain loop */
$episode = Nexus_Episode::factory(get_the_ID());
$series = $episode->get_series();

$cp_episode = new Coprime_Episode($episode);
$cp_series = new Coprime_Series($series);
?>

<article id="item-<?php the_ID(); ?>" <?php post_class('villain'); ?> style="background-image: url(<?php echo $cp_episode->get_villain_albumart(); ?>);">
<a title="<?php echo strip_tags($cp_episode->get_episode_excerpt()); ?>" class="face" href="<?php echo $episode->get_permalink(); ?>">

	<div class="mask">
		<h2 class="show-title"><?php echo $cp_episode->get_villain_title(); ?></h2>
		<h3 class="show-number"><?php echo $series->get_name(); ?> #<?php echo $cp_episode->get_episode_number(); ?></h3>
		<h4 class="show-date"><?php echo $cp_episode->get_posted_date(); ?> <?php echo $cp_episode->get_is_new(); ?></h4>
	</div>

</a>
</article>