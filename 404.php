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
							<!-- stuff -->
							<?php do_action('in_content_header'); ?>
						</header>
						<section class="content-section">
							<?php $requested = home_url( esc_url( $_SERVER['REQUEST_URI'] ) ); ?>
							<p>Hey, your requested page, <code><?php echo $requested; ?></code>, was not found.</p>
							<div id="kawaii-error"></div>
							<?php do_action('in_content_section'); ?>
						</section>
						<footer class="content-footer">
							<!-- empty footer --><!-- footer? edit links, authoring, modified data -->
							<?php do_action('in_content_footer'); ?>
						</footer>
						
						<?php do_action('after_in_content'); ?>

					</article>

				</div>
			</div>
		</section>

		<?php do_action('after_world'); ?>

<?php get_footer(); ?>
