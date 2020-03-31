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


		<?php 
		//Custom WP_Query() for post types located in the footer of your site that pulls in the 3 most recent posts with the following info: Featured Image, Title, Excerpt, and Post Link (kat)
			$args = array(
				'post_type' => 'map',
				'orderby' => 'post_date',
				'posts_per_page' => 3,
				'post_status' => 'publish'
			);

			$map_query = new WP_Query($args);

			while ($map_query->have_posts()) : $map_query->the_post();

				the_title();
				the_post_thumbnail('thumbnail');
				the_excerpt();
				get_permalink();

			endwhile; 
			wp_reset_query();
		?>


		
		



		<!-- // Use the customizer control that has been set -->
		<?php if ( get_theme_mod('travel_theme_facebook_url') || get_theme_mod('travel_theme_twitter_url') || get_theme_mod('travel_theme_instagram_url') || get_theme_mod('travel_theme_youtube_url') ) { ?>
			<div class="social-media-section">
				<ul class="social-media">
					<?php if ( get_theme_mod( 'travel_theme_facebook_url' ) ) { ?>
						<li class="facebook">
							<a href="<?php echo get_theme_mod( 'travel_theme_facebook_url' ); ?>">
								<!-- <i href="#" class="fab fa-facebook-square"></i> -->
								<img src="<?php echo get_template_directory_uri() . '/assets/images/icons/facebook.svg'; ?>" alt="<?php echo esc_html__( 'Facebook', 'travel_theme' ); ?>" height="35" width="35">
							</a>
						</li>
					<?php } ?>
					<?php if ( get_theme_mod( 'travel_theme_twitter_url' ) ) { ?>
						<li class="twitter">
							<a href="<?php echo get_theme_mod( 'travel_theme_twitter_url' ); ?>">
								<!-- <i href="#" class="fab fa-twitter"></i> -->
								<img src="<?php echo get_template_directory_uri() . '/assets/images/icons/twitter.svg'; ?>" alt="<?php echo esc_html__( 'Twitter', 'travel_theme' ); ?>" height="35" width="35">
							</a>
						</li>
					<?php } ?>
					<?php if ( get_theme_mod( 'travel_theme_instagram_url' ) ) { ?>
						<li class="instagram">
							<a href="<?php echo get_theme_mod( 'travel_theme_instagram_url' ); ?>">
							<!-- <i href="#" class="fab fa-instagram"></i> -->
							<img src="<?php echo get_template_directory_uri() . '/assets/images/icons/instagram.svg'; ?>" alt="<?php echo esc_html__( 'Instagram', 'travel_theme' ); ?>" height="35" width="35">
							</a>
						</li>
					<?php } ?>
					<?php if ( get_theme_mod( 'travel_theme_youtube_url' ) ) { ?>
						<li class="youtube">
							<a href="<?php echo get_theme_mod( 'travel_theme_youtube_url' ); ?>">
								<!-- <i href="#" class="fab fa-youtube"></i> -->
								<img src="<?php echo get_template_directory_uri() . '/assets/images/icons/youtube.svg'; ?>" alt="<?php echo esc_html__( 'Youtube', 'travel_theme' ); ?>" height="35" width="35">
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
