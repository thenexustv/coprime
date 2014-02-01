<?php get_header(); ?>

		<?php do_action('before_hero'); // better name for this hook, please? ?>

		<section id="hero-container">
			<div class="hero-wrapper">
				
				<?php do_action('in_hero'); // better name for this hook, please? ?>

			</div>
		</section>

		<?php do_action('after_hero'); // better name for this hook, please? ?>

		<?php do_action('before_world'); ?>

		<section id="world">
			<div id="content-container">
				<div class="content-wrapper">
					
					<?php do_action('before_content'); ?>

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<article id="item-<?php the_ID(); ?>" role="article" <?php post_class(); ?>>
						
						<?php do_action('before_in_content'); ?>

						<header class="content-header">
							<h2><?php the_title(); ?></h2>
							<!-- stuff -->
							<?php do_action('in_content_header'); ?>
						</header>
						<section class="content-section">
							<!-- content goes here -->
							<?php do_action('in_content_section'); ?>
						</section>
						<footer class="content-footer">
							<!-- empty footer --><!-- footer? edit links, authoring, modified data -->
							<?php do_action('in_content_footer'); ?>
						</footer>
						
						<?php do_action('after_in_content'); ?>

					</article>

					<?php endwhile; endif; ?>

					<?php do_action('after_content'); ?>

				</div>
			</div>
		</section>

		<?php do_action('after_world'); ?>

<?php get_footer(); ?>
