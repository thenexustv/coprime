	
	</main>
	
	<?php do_action('after_galaxy'); ?>

	<?php do_action('before_footer'); ?>

	<footer id="footer-container" role="contentinfo">

		<?php get_template_part('partials/footer-area') ?>

		<div class="footer-inner">

			<div class="endpoint">
				<p class="source-org copyright">&copy; <?php echo date('Y'); ?> &blacksquare; <a href="<?php echo home_url(); ?>">The Nexus</a></p>
			</div>
			<?php do_action('in_footer'); ?>

			<div class="nx-end"><span></span></div>

		</div>
	</footer>

	<?php do_action('after_footer'); ?>

</div>

<?php do_action('after_universe'); ?>

<?php wp_footer(); ?>

</body>
</html>