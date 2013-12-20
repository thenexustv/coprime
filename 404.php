<?php get_header(); ?>

		<?php do_action('before_world'); ?>

		<section id="world">
			<div id="content-container">
				<div class="content-wrapper">
					
					<?php do_action('before_content'); ?>


					<article id="item-0" role="article" class="not-found">
						
						<?php do_action('before_in_content'); ?>

						<header class="content-header">
							<h1 class="not-found-title">Not Found</h1>
							<?php do_action('in_content_header'); ?>
						</header>
						<section class="content-section">
							<p class="not-found-notice">Hey. The page you were looking for does not exist.</p>
							
							<div class="episode-suggestion">
							<?php
								$post = Coprime::get_instance()->get_single_recent_episode();
								$episode = Nexus_Episode::factory($post);
								$cp_episode = new Coprime_Episode($episode);
							?>
							<p>Try listening to our latest episode of <?php echo $cp_episode->get_formatted_title(); ?> or browsing the <a href="<?php echo home_url('/episode/') ?>">Episode Archive</a>.</p>
							</div>

							<div id="kawaii-error">
								<img title="404" src="<?php echo get_template_directory_uri() . '/library/images/kawaii-error.png'; ?>" />
							</div>

							<p>Sorry, we stuttered.</p>

							<?php do_action('in_content_section'); ?>
						</section>
						<footer class="content-footer">
							<?php do_action('in_content_footer'); ?>
						</footer>
						
						<?php do_action('after_in_content'); ?>

					</article>

				</div>
			</div>
		</section>

		<?php do_action('after_world'); ?>

<?php get_footer(); ?>
