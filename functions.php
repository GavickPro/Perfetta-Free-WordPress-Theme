<?php
/**
 *
 * Perfetta functions and definitions
 *
 */

// loading the necessary elements
get_template_part( 'comments', 'template' );
get_template_part( 'theme', 'customizer' );

/**
 *
 * Functions used to generate post excerpt
 *
 * @return HTML output
 *
 **/

function perfetta_excerpt($text) {
    return $text . '&hellip;';
}

add_filter( 'get_the_excerpt', 'perfetta_excerpt', 999 );

function perfetta_excerpt_more($text) {
    return '';
}

add_filter( 'excerpt_more', 'perfetta_excerpt_more', 999 );


/**
 * Perfetta setup.
 *
 * Sets up theme defaults and registers the various WordPress features
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_theme_support() To add support for automatic feed links, post
 * formats, and post thumbnails.
 * @uses register_nav_menu() To add support for a navigation menu.
 *
 *
 * @return void
 */
function perfetta_setup() {
	global $content_width;
	
	if ( ! isset( $content_width ) ) $content_width = 900;
	
	/*
	 * Makes Perfetta available for translation.
	 *
	 */
	load_theme_textdomain( 'perfetta', get_template_directory() . '/languages' );

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Switches default core markup for search form, comment form,
	 * and comments to output valid HTML5.
	 */
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

	/*
	 * This theme supports all available post formats by default.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'gallery', 'image', 'link', 'quote', 'video'
	) );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menu( 'primary', __( 'Navigation Menu', 'perfetta' ) );
	register_nav_menu( 'footer', __( 'Footer Menu', 'perfetta' ) );

	/*
	 * This theme uses a custom image size for featured images, displayed on
	 * "standard" posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );
	
	// Support for custom background
	$args = array(
		'default-color' => 'f3f3f3',
		'default-image' => get_template_directory_uri() . '/images/bg-desktop.jpg',
		'default-repeat' => 'no-repeat',
		'default-position-x' => 'left',
		'default-attachment' => 'fixed'
	);
	add_theme_support( 'custom-background', $args );
	
	// Support for infinite scroll from Jetpack
	add_theme_support( 'infinite-scroll', array(
		'container'  => 'content',
		'footer'     => 'gk-footer',
		'wrapper'   => false
	));

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
}
add_action( 'after_setup_theme', 'perfetta_setup' );

/**
 * Enqueue scripts for the back-end.
 *
 * @return void
 */
function perfetta_add_editor_styles() {
    add_editor_style('editor.css');
}
add_action('init', 'perfetta_add_editor_styles');


/**
 * Enqueue scripts for the front end.
 *
 * @return void
 */
function perfetta_scripts() {
	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	// Loads JavaScript file with functionality specific to Perfetta.
	wp_enqueue_script( 'perfetta-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '', true );
	
	// Loads JavaScript file for responsive video.
	wp_enqueue_script('perfetta-video',  get_template_directory_uri() . '/js/jquery.fitvids.js', false, false, true);
	
	// Loads JavaScript file for responsive video.
	wp_enqueue_script('perfetta-scroll-reveal',  get_template_directory_uri() . '/js/scrollreveal.js', false, false, true);
}

add_action( 'wp_enqueue_scripts', 'perfetta_scripts' );

/**
 * Enqueue styles for the front end.
 *
 * @return void
 */
function perfetta_styles() {
	// Add normalize stylesheet.
	wp_enqueue_style('perfetta-normalize', get_template_directory_uri() . '/css/normalize.css', false);

	// Add Google font from the customizer
	wp_enqueue_style('perfetta-fonts', get_theme_mod('perfetta_google_font', '//fonts.googleapis.com/css?family=Cookie'), false);
	wp_enqueue_style('perfetta-fonts-body', get_theme_mod('perfetta_body_google_font', '//fonts.googleapis.com/css?family=Raleway:300,400,700'), false);
	
	// Font Awesome
	wp_enqueue_style('perfetta-font-awesome', get_template_directory_uri() . '/css/font.awesome.css', false, '4.2.0' );

	// Loads our main stylesheet.
	wp_enqueue_style( 'perfetta-style', get_stylesheet_uri());
	
	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'perfetta-ie8', get_template_directory_uri() . '/css/ie8.css', array( 'perfetta-style' ) );
	wp_style_add_data( 'perfetta-ie8', 'conditional', 'lt IE 9' );
	
	wp_enqueue_style( 'perfetta-ie9', get_template_directory_uri() . '/css/ie9.css', array( 'perfetta-style' ) );
	wp_style_add_data( 'perfetta-ie9', 'conditional', 'IE 9' );
}

add_action( 'wp_enqueue_scripts', 'perfetta_styles' );

/**
 * Filter the page title.
 *
 * Creates a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 *
 * @param string $title Default title text for current view.
 * @param string $sep   Optional separator.
 * @return string The filtered title.
 */
function perfetta_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'perfetta' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'perfetta_wp_title', 10, 2 );

/**
 * Register widget area.
 *
 * @return void
 */
function perfetta_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Top widget area', 'perfetta' ),
		'id'            => 'top',
		'description'   => __( 'Appears at the top of the website.', 'perfetta' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Bottom widget area', 'perfetta' ),
		'id'            => 'bottom',
		'description'   => __( 'Appears at the bottom of the website.', 'perfetta' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'perfetta_widgets_init' );

if ( ! function_exists( 'perfetta_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 *
 * @return void
 */
function perfetta_paging_nav() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h3 class="screen-reader-text"><?php _e( 'Posts navigation', 'perfetta' ); ?></h3>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'perfetta' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'perfetta' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'perfetta_meta' ) ) :
/**
 * Print HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 *
 * @return void
 */
function perfetta_meta() {

	if ('post' == get_post_type() ) {
		perfetta_date();
	}
	echo '<div>';
	// Post author	
	if ( 'post' == get_post_type() ) {
		echo '<span>' . __( 'by ', 'perfetta' ) . '</span>';
		printf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'perfetta' ), get_the_author() ) ),
			get_the_author()
		);
		
		if(get_theme_mod('perfetta_show_author_avatar', '0') == '1') {
			echo '<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="avatar-link">';
			echo get_avatar(get_the_author_meta('ID'), apply_filters('perfetta_author_avatar_size', '32'));
			echo '</a>';
		}
	}
	
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'perfetta' ) );
	if ( $categories_list ) {
		echo '<span class="categories-links">' . $categories_list . '</span>';
	}

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'perfetta' ) );
	if ( $tag_list ) {
		echo '<span class="tags-links">' . $tag_list . '</span>';
	}
	
	if(current_user_can('edit_posts') || current_user_can('edit_pages')) {
		echo '<div>';
		edit_post_link(__( 'Edit', 'perfetta'), '<span class="edit-link">', '</span>');
		echo '</div>';
	}
	echo '</div>';
}
endif;


if ( ! function_exists( 'perfetta_date' ) ) :
/**
 * Print HTML with date information for current post.
 *
 *
 * @param boolean $echo (optional) Whether to echo the date.
 * @return string The HTML post date.
 */
function perfetta_date( $echo = true ) {
	$date_format = esc_html(get_the_date('Mj')). '<span>'. esc_html(get_the_date('Y')) .'</span>'; 
	
	if(get_theme_mod('perfetta_date_format', 'default') == 'wordpress') {
		$date_format = get_the_date(get_option('date_format'));
	} 
	
	// Post Formats
	$post_format = '';
	
	if(get_post_format() != '') {
		$post_format = '<span class="format gk-format-'. get_post_format(). '"></span>';
	}
	
	$date = sprintf( '<time class="entry-date" datetime="'. esc_attr(get_the_date('c')) . '">'. $date_format . $post_format .'</time>' );

	if ( $echo ) {
		echo $date;
	}

	return $date;
}
endif;

if( ! function_exists( 'perfetta_video_code' ) ) :

function perfetta_video_code() {
	$video_condition = stripos(get_the_content(), '</iframe>') !== FALSE || stripos(get_the_content(), '</video>') !== FALSE; 
	
	if($video_condition) {
		$video_code = '';
		
		if(stripos(get_the_content(), '</iframe>') !== FALSE) {
			$start = stripos(get_the_content(), '<iframe');
			$len = strlen(substr(get_the_content(), $start, stripos(get_the_content(), '</iframe>', $start)));
			$video_code = substr(get_the_content(), $start, $len + 9); 
		} elseif(stripos(get_the_content(), '</video>') !== FALSE) {
			$start = stripos(get_the_content(), '<video');
			$len = strlen(substr(get_the_content(), $start, stripos(get_the_content(), '</video>', $start)));
			$video_code = substr(get_the_content(), $start, $len + 8); 
		}
		
		return $video_code;
	} else {
		return FALSE;
	}
}

endif;


if ( ! function_exists( 'perfetta_the_attached_image' ) ) :
/**
 * Print the attached image with a link to the next attached image.
 *
 * @since Perfetta 1.0
 *
 * @return void
 */
function perfetta_the_attached_image() {
	/**
	 * Filter the image attachment size to use.
	 *
	 * @since Perfetta 1.0
	 *
	 * @param array $size {
	 *     @type int The attachment height in pixels.
	 *     @type int The attachment width in pixels.
	 * }
	 */
	$attachment_size     = apply_filters( 'perfetta_attachment_size', array( 724, 724 ) );
	$next_attachment_url = wp_get_attachment_url();
	$post                = get_post();

	/*
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID'
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id )
			$next_attachment_url = get_attachment_link( $next_id );

		// or get the URL of the first image attachment.
		else
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
	}

	printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
		esc_url( $next_attachment_url ),
		the_title_attribute( array( 'echo' => false ) ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;