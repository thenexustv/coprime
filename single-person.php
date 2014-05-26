<?php
/**
 * Single Episode Template
 */
?>
<?php get_header(); ?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post();

			$person = Nexus_Person::factory(get_the_ID());
			$cp_person = new Coprime_Person($person);

		?>

		<?php do_action('before_world'); ?>

		<section id="world">
			<div id="content-container">
				<div class="content-wrapper">
					
					<?php do_action('before_content'); ?>

					<article id="item-<?php the_ID(); ?>" role="article" <?php post_class(); ?>>
						<div class="box">
						
							<?php do_action('before_in_content'); ?>

							<header class="content-header">
								<div class="person-avatar"><?php echo $cp_person->get_avatar(150); ?></div>
								<h1 class="person-name"><?php echo $cp_person->get_formatted_name(); ?></h1>

								<?php echo $cp_person->get_links(); ?>

								<?php do_action('in_content_header'); ?>
							</header>

							<section class="content-section">						

								<?php echo $cp_person->get_content(); ?> 

								<div class="related">
									
									<?php
										$query = Coprime::get_instance()->get_person_episodes($person->get_id());
										
										// save the global wp_query; restore it after
										// this will allow pagination to work
										global $wp_query;
										$_wp_query = $wp_query;
										$wp_query = $query;
										

										if ( $query->have_posts() ):
									?>
									<h3 class="episodes-with">Episodes with <?php echo $cp_person->get_name(); ?></h3>
									<ul class="episode-list">
									<?php while ($query->have_posts()): $query->the_post();
										$episode = Nexus_Episode::factory(get_the_ID());
									?>
										<li><a href="<?php echo $episode->get_permalink(); ?>"><?php echo $episode->get_formatted_title(); ?></a></li>
									<?php endwhile ?>
									</ul>
									<?php loop_pagination(array('mid_size' => 3, 'end_size' => 2)); ?>
									<?php endif; $wp_query = $_wp_query; wp_reset_query(); wp_reset_postdata(); ?>
								</div>

								<?php do_action('in_content_section'); ?>


							</section>
							<footer class="content-footer">

							</footer>
							
							<?php do_action('after_in_content'); ?>

						</div>
					</article>

					<?php do_action('after_content'); ?>

				</div>
			</div>
		</section>

		<?php do_action('after_world'); ?>

		<?php endwhile; ?>
		<?php endif; ?>

<?php get_footer(); ?>
