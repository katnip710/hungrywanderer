<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wanderer
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<div class="site-info">
		<?php
			if (has_nav_menu ('footer-menu')) {
					$args = array(
						'theme_location' => 'footer-menu',
						'after' => ' | ',
						'container' => '',
					);
					wp_nav_menu( $args );
				}
		?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
