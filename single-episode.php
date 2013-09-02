<?php
/**
 * Single Episode Template
 */
?>
<?php get_header(); ?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post();

			$episode = Nexus_Episode::factory(get_the_ID());
			$series = $episode->get_series();

			$cp_episode = new Coprime_Episode($episode);
			$cp_series = new Coprime_Series($series);


		?>

		<?php do_action('before_hero'); ?>

		<section id="hero-container">
			<div class="hero-wrapper">
				
				<div class="hero-meta">
					<h2 class="show-series-name"><?php echo $cp_series->get_series_name(); ?></h2>
					<div class="show-series-description"><?php echo $cp_series->get_series_description(); ?></div>
				</div>
				<div class="hero-album-art">
					<?php
						echo $cp_episode->get_hero_albumart();
					?>
				</div>
				<?php do_action('in_hero'); ?>

			</div>
		</section>

		<?php do_action('after_hero'); ?>


		<?php do_action('before_world'); ?>

		<section id="world">
			<div id="content-container">
				<div class="content-wrapper">
					
					<?php do_action('before_content'); ?>

					<article id="item-<?php the_ID(); ?>" role="article" <?php post_class(); ?>>
						<div class="box">
						
							<?php do_action('before_in_content'); ?>

							<header class="content-header">

								<h1 class="show-title"><?php echo $cp_episode->get_title(); ?></h1>
								<div class="show-meta">
									<h2 class="show-number"><?php echo $cp_episode->get_episode_position(); ?></h2>
									 &blacksquare; 
									<h3 class="show-date"><?php echo $cp_episode->get_posted_date_ago(); ?></h3>
								</div>
								
								<?php if ( $episode->get_excerpt() != '' ): ?>
				 				<div class="show-description">
				 					<?php echo $cp_episode->get_episode_description(); ?>
				 				</div>
					 			<?php endif; ?>

								<?php do_action('in_content_header'); ?>

							</header>
							<aside class="content-aside">
 
								<?php if ( $episode->get_enclosure() ):
									$enclosure = $episode->get_enclosure();
									echo $cp_episode->get_podcast_player($enclosure);
									echo $cp_episode->get_podcast_meta($enclosure);
								endif; ?>		

							</aside>
							<section class="content-section">						

								<?php echo $episode->get_content(); ?> 

								<?php do_action('in_content_section'); ?>


							</section>
							<footer class="content-footer">

								<div class="navigation">
									<span class="previous"><?php echo previous_post_link('%link', '&larr; Previous', true); ?></span>
									<span class="next"><?php echo next_post_link('%link', 'Next &rarr;', true); ?></span>
									<?php do_action('in_content_footer'); ?>
								</div>

							</footer>
							
							<?php do_action('after_in_content'); ?>

						</div>
					</article>

					<?php do_action('after_content'); ?>

					<?php do_action('before_sidebar'); ?>

					<div class="sidebar">
						<div class="sidebar-wrapper">
					
						<?php if ($episode->has_people()): get_template_part('partials/episode-people'); endif; ?>

						<?php get_template_part('partials/episode-subscribe') ?>
						
						<?php get_template_part('partials/episode-share'); ?>
						
						
						</div>
					</div>

					<?php do_action('after_sidebar'); ?>

				</div>
			</div>
		</section>

		<?php do_action('after_world'); ?>

		<?php endwhile; ?>
		<?php endif; ?>

<?php get_footer(); ?>
