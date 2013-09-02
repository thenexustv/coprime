<?php get_header(); ?>

		<?php do_action('before_hero'); ?>

		<section id="hero-container">
			<div class="hero-wrapper">
				
				<div class="hero-meta">

					<div class="loop-meta archive-meta category-meta">
						<p>Meet the people that make The Nexus incredible.
					</div>

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
						$person = Nexus_Person::factory(get_the_ID());
						$cp_person = new Coprime_Person($person);
					?>

					<article id="item-<?php the_ID(); ?>" role="article" <?php post_class(); ?>>
						
						<?php do_action('before_in_content'); ?>

						<header class="content-header">
							<div class="person-avatar"><?php echo $cp_person->get_avatar(100); ?></div>
							<h2 class="person-name"><?php echo $cp_person->get_formatted_name('span'); ?></h2>

							<div class="person-description">
								<?php echo $cp_person->get_short_content(); ?>
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
