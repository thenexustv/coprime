<?php

	$episode = Nexus_Episode::factory(); // get the post from the loop
	$series = Nexus_Series::factory($episode->get_series());
	$cp_series = new Coprime_Series($series);

?>
<div class="subscribe">
	<div class="box">
		<h4>Subscribe</h4>
		<?php echo $cp_series->get_series_subscriptions($episode); ?>
	</div>
</div>