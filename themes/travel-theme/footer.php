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
						'container' => 'div',
					);
					wp_nav_menu( $args );
				}
		?>
		<!-- // Use the customizer control that has been set -->
		<?php if ( get_theme_mod('travel_theme_facebook_url') || get_theme_mod('travel_theme_twitter_url') || get_theme_mod('travel_theme_instagram_url') || get_theme_mod('travel_theme_youtube_url') ) { ?>
			<div class="social-media-section">
				<ul class="social-media">
					<?php if ( get_theme_mod( 'travel_theme_facebook_url' ) ) { ?>
						<li class="facebook">
							<a href="<?php echo get_theme_mod( 'travel_theme_facebook_url' ); ?>">
								<i href="#" class="fab fa-facebook-square"></i>
							</a>
						</li>
					<?php } ?>
					<?php if ( get_theme_mod( 'travel_theme_twitter_url' ) ) { ?>
						<li class="twitter">
							<a href="<?php echo get_theme_mod( 'travel_theme_twitter_url' ); ?>">
								<i href="#" class="fab fa-twitter"></i>
							</a>
						</li>
					<?php } ?>
					<?php if ( get_theme_mod( 'travel_theme_instagram_url' ) ) { ?>
						<li class="instagram">
							<a href="<?php echo get_theme_mod( 'travel_theme_instagram_url' ); ?>">
							<i href="#" class="fab fa-instagram"></i>
							</a>
						</li>
					<?php } ?>
					<?php if ( get_theme_mod( 'travel_theme_youtube_url' ) ) { ?>
						<li class="youtube">
							<a href="<?php echo get_theme_mod( 'travel_theme_youtube_url' ); ?>">
								<i href="#" class="fab fa-youtube"></i>
							</a>
						</li>
					<?php } ?>
				</ul>
			</div>
		<?php } ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
