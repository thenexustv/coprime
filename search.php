<?php get_header(); ?>

		<?php do_action('before_hero'); ?>

		<section id="hero-container">
			<div class="hero-wrapper">
				
				<div class="hero-meta">

					<h1 class="loop-title archive-title">Search Results <?php echo ( isset($_GET['s']) && !empty($_GET['s']) ? 'for <em>' . esc_html(urldecode($_GET['s'])) . '</em>' : "" ); ?></h1>


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

					<?php if (have_posts()) : while (have_posts()) : the_post();
						$episode = Nexus_Episode::factory(get_the_ID());
						$cp_episode = new Coprime_Episode($episode);
					?>

					<article id="item-<?php the_ID(); ?>" role="article" <?php post_class('stand-alone'); ?>>
						
						<?php do_action('before_in_content'); ?>

						<header class="content-header">
							<div class="show-albumart"><?php echo $cp_episode->get_showboard_albumart(); ?></div>
							<h2 class="show-title"><?php echo $cp_episode->get_title(); ?></h2>
							<h4 class="show-number"><?php echo $cp_episode->get_episode_position(); ?></h3>
							<h4 class="show-date"><?php echo $cp_episode->get_is_new(); ?> <?php echo $cp_episode->get_posted_date_ago(); ?></h4>

							<div class="show-description">
								<?php echo $cp_episode->get_episode_description(); ?>
							</div>

							<?php do_action('in_content_header'); ?>
						</header>

						
						<?php do_action('after_in_content'); ?>

					</article>

					<?php endwhile; endif; ?>

					<?php get_template_part('partials/loop-pagination'); ?>

					<?php do_action('after_content'); ?>

				</div>
			</div>
		</section>

		<?php do_action('after_world'); ?>

<?php get_footer(); ?>
