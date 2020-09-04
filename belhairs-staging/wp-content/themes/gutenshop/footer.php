<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package guten_shop
 */

?>

</div><!-- #content -->
</div>

<div class="footer-container">
	<div id="page" class="site grid-container">
		<footer id="colophon" class="site-footer">
			<?php if ( is_active_sidebar( 'footer-widget-one') ||  is_active_sidebar( 'footer-widget-two') ||  is_active_sidebar( 'footer-widget-three')  ) : ?>
			<div class="footer-widgets-container">
				<div class="footer-widget-three">

					<?php if ( is_active_sidebar( 'footer-widget-one' ) ) : ?>
					<div class="footer-column">
						<?php dynamic_sidebar( 'footer-widget-one' ); ?>				
					</div>
				<?php endif; ?>

				<?php if ( is_active_sidebar( 'footer-widget-two' ) ) : ?>
				<div class="footer-column">
					<?php dynamic_sidebar( 'footer-widget-two' ); ?>				
				</div>
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'footer-widget-three' ) ) : ?>
			<div class="footer-column">
				<?php dynamic_sidebar( 'footer-widget-three' ); ?>				
			</div>
		<?php endif; ?>

	</div>
</div>
<?php endif; ?>


	<!-- Delete below lines to remove copyright from footer -->
	
	<!-- Delete above lines to remove copyright from footer -->



</div><!-- .site-info -->
</footer><!-- #colophon -->
</div>
</div>
<?php wp_footer(); ?>

</body>