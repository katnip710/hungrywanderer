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
			<a href="<?php echo esc_url( __( '#', 'travel-theme' ) ); ?>">
				<?php
				/* translators: %s: CMS name, i.e. WordPress. */
				printf( esc_html__( '%s', 'travel-theme' ), 'Privacy Policy' );
				?>
			</a>
			<span class="sep"> | </span>
				<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( '%1$s', 'travel-theme' ), '<a href="#">Developers API</a>' );
				?>
			<span class="sep"> | </span>
				<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( '%1$s', 'travel-theme' ), '<a href="#">Site Map</a>' );
				?>
			<span class="sep"> | </span>
				<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( '%1$s', 'travel-theme' ), '<a href="#">Terms & Conditions</a>' );
				?>
				<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( '%1$s', 'travel-theme' ), '<i href="#" class="fab fa-facebook-square"></i>' );
				?>
				<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( '%1$s', 'travel-theme' ), '<i href="#" class="fab fa-instagram"></i>' );
				?>
				<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( '%1$s', 'travel-theme' ), '<i href="#" class="fab fa-twitter"></i>' );
				?>
				<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( '%1$s', 'travel-theme' ), '<i href="#" class="fab fa-youtube"></i>' );
				?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
