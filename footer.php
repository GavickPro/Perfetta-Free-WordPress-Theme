<?php
/**
 * The template for displaying the footer
 *
 */
 
$bottom_color = get_theme_mod('perfetta_bottom_color', 'dark'); 
 
?>

		</div><!-- #main -->
		<footer id="gk-footer"<?php echo $bottom_color == 'dark' ? '' : ' class="light-bg"'; ?> role="contentinfo">
			<?php if ( is_active_sidebar( 'bottom' ) ) : ?>
			<div id="gk-bottom" role="complementary">
				<div class="widget-area">
					<?php dynamic_sidebar( 'bottom' ); ?>
				</div>
			</div>
			<?php endif; ?>
			
			<div id="gk-social">
				<?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_class' => 'social-menu' ) ); ?>
			</div>
			
			<div id="gk-copyrights">
				<?php do_action( 'perfetta_credits' ); ?>
				
				<p class="copyright"><?php _e('Free WordPress Theme designed by ','perfetta'); ?><a href="https://www.gavick.com/wordpress-themes">GavickPro</a></p>
				<p class="poweredby"><?php _e('Proudly published with ','perfetta'); ?><a href="http://wordpress.org/">WordPress</a></p>
			</div><!-- .site-info -->
		</footer><!-- end of #gk-footer -->
	</div><!-- #page -->
	
	<a href="#menu" id="aside-menu-toggler"><i class="fa fa-bars"></i></a>
	<i id="close-menu" class="fa fa-times"></i>
	<aside id="aside-menu">
		<nav id="aside-navigation" class="main-navigation" role="navigation">
			<h3><?php _e( 'Menu', 'perfetta' ); ?></h3>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-aside-menu' ) ); ?>
		</nav><!-- #aside-navigation -->
	</aside><!-- #aside-menu -->

	<?php wp_footer(); ?>
</body>
</html>
