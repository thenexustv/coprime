<?php
/**
 * Template Name: Shows
 *
 */
?><?php get_header(); ?>

		<?php do_action('before_world'); ?>

		<section id="world">
			<div id="content-container">
				<div class="content-wrapper">
					
					<?php do_action('before_content'); ?>

					<?php

						$post_ids = Coprime::get_instance()->get_series_list_query();
						
						foreach ($post_ids as $post_id):
							$episode = Nexus_Episode::factory($post_id);
							$series = $episode->get_series();

							$cp_episode = new Coprime_Episode($episode);
							$cp_series = new Coprime_Series($series);
					?>

					<article id="item-<?php the_ID(); ?>" role="article" <?php post_class('stand-alone');?>>
						
						<?php do_action('before_in_content'); ?>

						<header class="content-header">
							<div title="View more episodes of <?php echo $series->get_name();?>" class="show-albumart"><?php echo $cp_episode->get_series_list_albumart(); ?></div>
							<h2 title="View more episodes of <?php echo $series->get_name();?>" class="show-series-name"><?php echo $cp_series->get_series_name(); ?></h2>
							
							<?php do_action('in_content_header'); ?>
						</header>

						<aside class="series-subscribe">
							<h4>Subscribe</h4>
							<?php echo $cp_series->get_series_subscriptions(); ?>
						</aside>

						<section class="content-section">	


							<div class="show-description"><?php echo $cp_series->get_series_description(); ?></div>

							<div class="series-status">
								<?php if ($episode->is_new()): ?>
								<?php echo $cp_episode->get_is_new(); ?> &blacksquare;
								<?php endif; ?>
								<h3 class="show-title"><?php echo $cp_episode->get_formatted_title(); ?></h3>
							</div>
							

							<?php do_action('in_content_section'); ?>
						</section>


					</article>

					<?php
						endforeach; wp_reset_postdata();
					?>

					<?php do_action('after_content'); ?>

				</div>
			</div>
		</section>

		<?php do_action('after_world'); ?>

<?php get_footer(); ?>
