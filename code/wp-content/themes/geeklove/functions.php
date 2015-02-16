<?php
/**
 * Theme functions and definitions.
 *
 * @package StagFramework
 * @subpackage GeekLove
 */

/**
 * Set Max Content Width.
 *
 * @var integer
 */
if ( ! isset( $content_width ) ) $content_width = 940;

/**
 * Set cookie for Retina displays.
 *
 * @var bool
 */
global $is_retina;
( isset( $_COOKIE['retina'] ) ) ? $is_retina = true : $is_retina = false;

/* Theme Setup */
if ( ! function_exists( 'stag_theme_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 */
function stag_theme_setup(){
	/**
	 * Makes theme available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 */
	load_theme_textdomain( 'stag', get_template_directory().'/languages' );

	// This theme uses wp_nav_menu() in following locations.
	register_nav_menu( 'primary-menu', __( 'Primary Menu', 'stag' ) );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style( 'framework/assets/css/editor-style.css' );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );

	set_post_thumbnail_size( 170, 160 ); // Normal post thumbnails

	add_image_size( 'gallery-thumb', 460, 310, true ); // Photo Gallery Thumbnails
}
endif; // stag_theme_setup
add_action( 'after_setup_theme', 'stag_theme_setup' );

/**
 * Register theme sidebar areas.
 *
 * @return void
 */
function stag_sidebar_init(){
	register_widget( 'Stag_Recent_Post' );
	register_widget( 'Stag_Wedding_Countdown' );
	register_widget( 'Stag_Wedding_Divider' );
	register_widget( 'Stag_Wedding_Event' );
	register_widget( 'Stag_Wedding_Rsvp' );
	register_widget( 'Stag_Wedding_Tweets' );
	register_widget( 'Stag_Wedding_Intro' );
	register_widget( 'Stag_Widget_Static_Content' );

	register_sidebar( array(
		'name'          => __( 'Footer Widgets', 'stag' ),
		'id'            => 'sidebar-footer',
		'before_widget' => '<div class="grid-4">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'stag_sidebar_init' );

/**
 * Filter WordPress Title.
 *
 * @param  string $title
 * @return string
 */
function stag_wp_title( $title ) {
	if ( ! stag_check_third_party_seo() ) {
		if ( is_front_page() ){
			if ( get_bloginfo( 'description' ) == '' ) {
				return get_bloginfo( 'name' );
			} else {
				return get_bloginfo( 'name' ) . ' | ' . get_bloginfo( 'description' );
			}
		} else {
			return trim( $title ) .' | '. get_bloginfo( 'name' );
		}
	}
	return $title;
}
add_filter( 'wp_title', 'stag_wp_title' );

/**
 * Enqueues scripts and styles for front end.
 *
 * @return void
 */
function stag_enqueue_scripts(){
	/** Register Styles */
	wp_register_style( 'lightbox', get_template_directory_uri().'/assets/css/lightbox.css', '', '2.7.1', 'screen' );

	/** Enqueue Styles */
	wp_enqueue_style( 'stag-style', get_stylesheet_uri(), '', STAG_THEME_VERSION );
	wp_dequeue_style( 'stag-shortcode-styles' );
	wp_enqueue_style( 'shortcode-styles', get_template_directory_uri().'/assets/css/shortcodes.css', '', STAG_THEME_VERSION );
	wp_enqueue_style( 'fonts', get_template_directory_uri().'/assets/css/fonts.css' );
	wp_enqueue_style( strtolower( STAG_THEME_NAME ) .'-fonts', stag_google_font_url(), array(), null );

	// IE CSS
	if ( strpos( $_SERVER['HTTP_USER_AGENT'], "MSIE 8" ) ) {
		wp_enqueue_style( 'ie8', get_template_directory_uri().'/assets/css/ie.css' );
	}

	$js_dir = get_template_directory_uri() . '/assets/js/';

	/** Register Scripts */
	wp_register_script( 'script', $js_dir . 'jquery.custom.js', array( 'jquery' ), STAG_THEME_VERSION, true );
	wp_register_script( 'stag-plugins', $js_dir . 'plugins.js', array( 'jquery' ), STAG_THEME_VERSION, true );
	wp_register_script( 'isotope', $js_dir . 'jquery.isotope.js', array( 'jquery' ), '1.5.25', true );
	wp_register_script( 'lightbox', $js_dir . 'lightbox.js', array( 'jquery' ), '2.7.1', true );
	wp_register_script( 'backstretch', $js_dir . 'jquery.backstretch.min.js', array( 'jquery' ), '2.0.4', true );
	wp_register_script( 'countdown', $js_dir . 'jquery.countdown.js', array( 'jquery' ), '1.6.1', true );
	wp_register_script( 'dropdown', $js_dir . 'jquery.dropdown.js', array( 'jquery' ), STAG_THEME_VERSION, true );

	/** Enqueue Scripts */
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'script' );
	wp_enqueue_script( 'stag-plugins' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' ); // loads the javascript required for threaded comments

	if (
		get_page_template_slug() == ( 'widgetized.php' || 'page-templates/template-photo-gallery.php' )
		|| ( is_single() && 'gallery' === get_post_type() )
		) {

		wp_enqueue_script( 'isotope' );

		if ( ! wp_is_mobile() ) {
			wp_enqueue_script( 'lightbox' );
			wp_enqueue_style( 'lightbox' );
		}
	}

	if ( is_page_template( 'widgetized.php' ) ) {
		wp_enqueue_script( 'backstretch' );
		wp_enqueue_script( 'countdown' );
		wp_enqueue_script( 'dropdown' );
	}

	/**
     * Localize strings used in jQuery Countdown.
     *
     * @since 1.2.5
     */
	wp_localize_script( 'stag-plugins', 'objectl10n', array(
		'labels' => array(
			__( 'Years', 'stag' ),
			__( 'Months', 'stag' ),
			__( 'Weeks', 'stag' ),
			__( 'Days', 'stag' ),
			__( 'Hours', 'stag' ),
			__( 'Minutes', 'stag' ),
			__( 'Seconds', 'stag' ),
			),
		'labels1' => array(
			__( 'Year', 'stag' ),
			__( 'Month', 'stag' ),
			__( 'Week', 'stag' ),
			__( 'Day', 'stag' ),
			__( 'Hour', 'stag' ),
			__( 'Minute', 'stag' ),
			__( 'Second', 'stag' ),
			)
		) );

	wp_localize_script( 'script', 'stag_vars', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	));
}
add_action( 'wp_enqueue_scripts', 'stag_enqueue_scripts' );

/**
 * Blog Pagination.
 *
 * @return mixed
 */
function pagination(){
	global $wp_query;

	$total_pages = $wp_query->max_num_pages;
	$big         = 999999999;

	if ( $total_pages > 1 ) {
		$current_page = max( 1, get_query_var( 'paged' ) );

		$return = paginate_links(array(
			'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format'    => '/page/%#%',
			'current'   => $current_page,
			'total'     => $total_pages,
			'prev_next' => false,
		));

		echo "<div class='pages'>{$return}</div>";
	} else {
		return false;
	}
}

/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @return void
 */
function stag_comments( $comment, $args, $depth ) {

	$isByAuthor = false;

	if ( $comment->comment_author_email == get_the_author_meta( 'email' ) ) {
		$isByAuthor = true;
	}

	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div id="comment-<?php comment_ID(); ?>" class="the-comment">

			<div class="comment-body clearfix">
				<div class="avatar-wrap">
					<?php
					global $is_retina;
					if ( $is_retina ) {
						echo get_avatar( $comment, $size = '112' );
					} else {
						echo get_avatar( $comment, $size = '56' );
					}
					?>
				</div>
				<div class="comment-area">
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					<h3 class="comment-author"><?php echo get_comment_author_link(); ?></h3>
					<p class="comment-date"><?php echo human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) .' '. __( 'ago', 'stag' ); ?></p>
					<?php if ( $comment->comment_approved == '0' ) : ?>
						<em class="moderation"><?php _e( 'Your comment is awaiting moderation.', 'stag' ); ?></em>
					<?php endif; ?>
					<div class="comment-text">
						<?php comment_text() ?>
					</div>
				</div>
			</div>

		</div>
	</li>

	<?php
}

function stag_list_pings( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; ?>
	<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?>
	<?php
}


if ( ! function_exists( 'custom_excerpt_length' ) ) {
	function custom_excerpt_length( $length ) {
		return stag_get_option( 'general_post_excerpt_length' );
	}
	add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
}

if ( ! function_exists( 'new_excerpt_more' ) ) {
	function new_excerpt_more( $more ) {
		global $post;
		return ' <a class="read-more" data-through="gateway" data-postid="'.$post->ID.'" href="'. get_permalink( $post->ID ) . '">'.stag_get_option( 'general_post_excerpt_text' ).'</a>';
	}
	add_filter( 'excerpt_more', 'new_excerpt_more' );
}

/**
* Get Wedding Date and Day
*/
function stag_wedding_date( $arg, $data = null ) {
	if ( $data === null ) {
		$date = stag_get_option( 'wedding_date' );
	} else {
		$date = $data;
	}

	return date_i18n( $arg, strtotime( $date ) );
}

/**
 * Retrieve wedding date.
 *
 * @return mixed
 */
function stag_full_wedding_date() {
	return sprintf(
		'<span class="day-date accent-color">%1$s</span> <span class="month">%2$s</span> <span class="year accent-color">%3$s</span>',
		stag_wedding_date( 'l d' ),
		stag_wedding_date( 'F' ),
		stag_wedding_date( 'Y' )
	);
}

function stag_full_date( $date ) {
	return stag_wedding_date( 'l d F Y', $date );
}

/**
* Get All available events
*
* @return array An array containing Events titles.
*/
function stag_all_wedding_events(){
	$query  = new WP_Query( 'post_type=events&posts_per_page=-1' );
	$titles = array();

	if ( $query->have_posts() ) :
		while ( $query->have_posts() ) : $query->the_post();
		$titles[ sanitize_title_with_dashes( get_the_title() ) ] = get_the_title();
		endwhile;
	endif;
	wp_reset_postdata();

	return $titles;
}


/**
* Check if string starts with a particular charcter
*/
function startsWith( $haystack, $needle ) {
	return ! strncmp( $haystack, $needle, strlen( $needle ) );
}

function get_attachment_id_from_src( $image_src ) {
	global $wpdb;
	$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
	$id = $wpdb->get_var( $query );
	return $id;
}

/**
 * Check if there is any third party plugin active
 *
 * @since 1.1
 */
function stag_check_third_party_seo() {
	include_once(ABSPATH .'wp-admin/includes/plugin.php');

	if ( is_plugin_active( 'headspace2/headspace.php' ) ) return true;
	if ( is_plugin_active( 'all-in-one-seo-pack/all_in_one_seo_pack.php' ) ) return true;
	if ( is_plugin_active( 'wordpres-seo/wp-seo.php' ) ) return true;

	return false;
}

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 *
 * @since 1.4
 */
function stag_required_plugins() {
	$plugins = array(
		// This is an example of how to include a plugin from the WordPress Plugin Repository
		array(
			'name'    => 'StagTools',
			'slug'    => 'stagtools',
			'required'  => true,
		),
		array(
			'name'     => 'Stag Custom Sidebar',
			'slug'     => 'stag-custom-sidebars',
			'required' => false,
		),
	);

	tgmpa( $plugins );
}
add_action( 'tgmpa_register', 'stag_required_plugins' );

/**
 * RSVP Widget ajax functionality.
 *
 * @since 1.2.8
 * @return void
 */
function stag_rsvp_widget_form_ajax() {
	if ( wp_verify_nonce( $_POST['_wpnonce'], 'new-post' ) ) {
		$post = array(
			'post_title'  => $_POST['attendee_name'],
			'post_status' => 'publish',
			'post_type'   => 'rsvp',
		);

		$post_id = wp_insert_post( $post );

		if ( $post_id != '' ) {
			if ( $_POST['attendee_event'] == 'no-events' ) $_POST['attendee_number'] = 0;
			add_post_meta( $post_id, '_stag_attendee_number', $_POST['attendee_number'] );
			add_post_meta( $post_id, '_stag_attendee_event', $_POST['attendee_event'] );

			echo apply_filters( 'rsvp_success_message', __( 'Thanks for attending, we will see you at our wedding.', 'stag' ) );
		}
	} else {
		header( 'HTTP/1.0 400 Bad error' );
	}

	die();
}
add_action( 'wp_ajax_rsvp_widget', 'stag_rsvp_widget_form_ajax' );
add_action( 'wp_ajax_nopriv_rsvp_widget', 'stag_rsvp_widget_form_ajax' );

/**
 * Add custom css into head.
 *
 * @since 2.0
 */
function stag_display_custom_css() {
	ob_start();
	$output = '';
	echo apply_filters( 'stag_custom_styles', $output );
	$css = ob_get_clean();

	echo "<style type='text/css'>$css</style>"."\n";
}
add_action( 'wp_head', 'stag_display_custom_css' );

/**
 * Include framework and other files
 */
include_once ( get_template_directory() . '/framework/stag-framework.php' );
include_once ( get_template_directory() . '/includes/_init.php' );
include_once ( get_template_directory() . '/includes/theme-customizer.php' );

include_once ( get_template_directory() . '/config-gravityforms/config.php' );
