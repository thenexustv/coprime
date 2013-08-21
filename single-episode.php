<?php
/**
 * Single Episode Template
 */
?>
<?php get_header(); ?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post();

			$episode = Nexus_Episode::factory(get_the_ID());
			$series = $episode->get_series();

			// var_dump($episode);

			$cp_episode = new Coprime_Episode($episode);
			$cp_series = new Coprime_Series($series);


		?>

		<?php do_action('before_hero'); // better name for this hook, please? ?>

		<section id="hero-container">
			<div class="hero-wrapper">
				
				<div class="hero-meta">
					<h2 class="show-series-name"><?php echo $cp_series->get_series_name(); ?></h2>
					<div class="show-series-description"><?php echo $cp_series->get_series_description(); ?></div>
				</div>
				<div class="hero-album-art">
					<img src="http://i1.wp.com/the-nexus.tv/wp-content/uploads/2012/10/at-the-nexus-site.jpg?fit=300%2C300" alt="Alpaca Poncho" class="Thumbnail thumbnail medium ">
				</div>
				<?php do_action('in_hero'); // better name for this hook, please? ?>

			</div>
		</section>

		<?php do_action('after_hero'); // better name for this hook, please? ?>


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
									<h3 class="show-date"><?php echo $cp_episode->get_posted_date(); ?></h3>
								</div>
								
								<?php if ( $episode->get_excerpt() != '' ): ?>
				 				<div class="show-description">
				 					<?php echo $cp_episode->get_episode_description(); ?>
				 				</div>
					 			<?php endif; ?>

								<?php do_action('in_content_header'); ?>

							</header>
							<aside class="content-aside">
 
								<?php if ( $episode->get_enclosure() ): ?>
									<div class="show-file">
										
										<?php echo $cp_episode->get_podcast_player(); ?>
										<div class="download-meta">
											<span class="show-length">43 minutes</span> &blacksquare; <span class="show-size">37.2 MB</span>
											<span class="show-download"><a href="dww">Download</a></span></div>

									</div>
								<?php endif; ?>		

							</aside>
							<section class="content-section">						

								<?php echo $episode->get_content(); ?> 

								<?php do_action('in_content_section'); ?>


							</section>
							<footer class="content-footer">

								<?php do_action('in_content_footer'); ?>

							</footer>
							
							<?php do_action('after_in_content'); ?>

						</div>
					</article>

					<?php do_action('after_content'); ?>

					<?php do_action('before_sidebar'); ?>

					<div class="sidebar">
						<div class="box">
							<h3>People</h3>
						</div>

						<div class="box">
							<h3>Subscribe</h3>
							<!-- subscribe -->
						</div>
						<!-- share -->
						<!-- navigation -->

					</div>

					<?php do_action('after_sidebar'); ?>

				</div>
			</div>
		</section>

		<?php do_action('after_world'); ?>

		<?php endwhile; ?>
		<?php endif; ?>

<?php get_footer(); ?>
