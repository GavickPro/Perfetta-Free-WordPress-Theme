<?php
/**
 * The default template for displaying Link post format
 *
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php get_template_part( 'content', 'meta' ); ?>
	<div>
		<?php get_template_part( 'content', 'header' ); ?>
	
		<div class="entry-content">
			<?php the_content( __( 'Read more', 'perfetta' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'perfetta' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
		</div><!-- .entry-content -->

		<?php get_template_part( 'content', 'footer' ); ?>
	</div>
</article><!-- #post -->

