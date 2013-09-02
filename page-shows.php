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

						// $query = Coprime::get_instance()->get_shows_query();
						$post_ids = Coprime::get_instance()->get_category_guide_query();

						// while ( $query->have_posts() ): $query->the_post();

						foreach ($post_ids as $post_id):
						$episode = Nexus_Episode::factory($post_id);
						$series = $episode->get_series();

						$cp_episode = new Coprime_Episode($episode);
						$cp_series = new Coprime_Series($series);
					?>

					<article id="item-<?php the_ID(); ?>" role="article" class="show-block">
						
						<?php do_action('before_in_content'); ?>

						<header class="content-header">
							<div class="show-albumart"><?php echo $cp_episode->get_showboard_albumart(); ?></div>
							<h3 class="show-series-name"><?php echo $cp_series->get_series_name(); ?></h3>
							
							<?php if ( $episode->is_new() ): ?>
							<div class="series-status">
								<?php echo $cp_episode->get_is_new(); ?> &blacksquare; <h3 class="show-title"><?php echo $cp_episode->get_formatted_title(); ?></h3>
							</div>
							<?php endif; ?>							

							<?php do_action('in_content_header'); ?>
						</header>

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
