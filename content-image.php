<?php
/**
 * The default template for displaying Image post format
 *
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php get_template_part( 'content', 'meta' ); ?>
	<div>
		<?php get_template_part( 'content', 'header' ); ?>
	
		<?php if ( is_home() || is_search() || is_archive() || is_tag()) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
			<a href="<?php echo get_permalink(get_the_ID()); ?>" class="readon"><?php _e('Read more', 'perfetta'); ?></a>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			<?php the_content( __( 'Read more', 'perfetta' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'perfetta' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
		</div><!-- .entry-content -->
		<?php endif; ?>
	
		<?php get_template_part( 'content', 'footer' ); ?>
	</div>
</article><!-- #post -->

