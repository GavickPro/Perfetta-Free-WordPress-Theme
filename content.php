<?php
/**
 * The default template for displaying content
 * Used for both single and index/archive/search.
 *
 */
 
$reveal = get_theme_mod('perfetta_scroll_reveal', '0');
$reveal_data = '';

if($reveal == '1' && !is_singular()) {
	$reveal_data = ' data-scroll-reveal="enter bottom"';
} 

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php echo $reveal_data; ?>>
	<?php get_template_part( 'content', 'meta' ); ?>
	<div>
		<?php get_template_part( 'content', 'header'); ?>
	
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
