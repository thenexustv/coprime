<?php
/* Showboard loop */
$episode = Nexus_Episode::factory(get_the_ID());
$series = $episode->get_series();

$cp_episode = new Coprime_Episode($episode);
$cp_series = new Coprime_Series($series);
?>

<article id="item-<?php the_ID(); ?>" <?php post_class('showboard'); ?>>
	<div class="wrapper">
	<div class="show-albumart"><?php echo $cp_episode->get_showboard_albumart(); ?></div>
	
	<div class="candy">
		
		<h3 class="show-title"><?php echo $cp_episode->get_title(); ?></h3>
		<h4 class="show-number"><?php echo $cp_series->get_series_name(); ?> #<?php echo $cp_episode->get_episode_number(); ?></h4>
		<h4 class="show-date"><?php echo $cp_episode->get_posted_date(); ?> <?php echo $cp_episode->get_is_new(); ?></h4>

	</div>

	</div>
</article>