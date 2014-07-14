<?php
/**
 *
 * 404 Page
 *
 **/

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<article id="post" <?php post_class(); ?>>
				<div>
					<header class="entry-header">
						<h1 class="entry-title"><span><?php _e( 'Not Found', 'perfetta' ); ?></span></h1>
					</header>
		
					<div class="page-wrapper">
						<div class="page-content">
							<h2><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'perfetta' ); ?></h2>
							<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'perfetta' ); ?></p>
		
							<?php get_search_form(); ?>
						</div><!-- .page-content -->
					</div><!-- .page-wrapper -->
				</div>
			</article><!-- #post -->
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>