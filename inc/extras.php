
<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Ben_Theme
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function theme_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'theme_body_classes' );

// Register options page for ACF field
if( function_exists('acf_add_options_page') ) {
	
    acf_add_options_page(array(
      'page_title' 	=> 'Theme General Settings',
      'menu_title'	=> 'Theme Settings',
      'menu_slug' 	=> 'theme-general-settings',
      'capability'	=> 'edit_posts',
      'redirect'		=> false
    ));
    
    acf_add_options_sub_page(array(
      'page_title' 	=> 'Theme Header Settings',
      'menu_title'	=> 'Header',
      'parent_slug'	=> 'theme-general-settings',
    ));
    
    acf_add_options_sub_page(array(
      'page_title' 	=> 'Theme Footer Settings',
      'menu_title'	=> 'Footer',
      'parent_slug'	=> 'theme-general-settings',
    ));
      
}

//Wp ajax init
add_action( 'wp_head', 'my_wp_ajaxurl' );
function my_wp_ajaxurl() {
	$url = parse_url( home_url( ) );
	if( $url['scheme'] == 'https' ){
	   $protocol = 'https';
	}
	else{
	    $protocol = 'http';
	}
    ?>
    <?php global $wp_query; ?>
    <script type="text/javascript">
        var ajaxurl = '<?php echo admin_url( 'admin-ajax.php', $protocol ); ?>';
    </script>
    <?php
}

// Product AJAX load
add_action('wp_ajax_load-more-blog', 'get_blog_request');
add_action('wp_ajax_nopriv_load-more-blog', 'get_blog_request');

function get_blog_request(){
	global $post;
	$res = new stdClass;
	$res->post = $_POST;
	$res->error = false;
	$res->error_text = '';
	ob_start();

	$post_type = $_POST['post_type'];
	$post_not_in = $_POST['posts_not_in'];
	$post_not_in = array_map('intval', explode(',', $post_not_in));
	$categories = $_POST['category'];
	$posts_per_page = 3;
	$args = array();
	if ( $categories != '' ):
		$args = array( 
			'post_type' 		=> $post_type,
			'posts_per_page'	=> $posts_per_page,
			'orderby'         	=> 'date',
			'order'				=> 'DESC',
            'post__not_in' 		=> $post_not_in,
			'category_name'   	=> $categories,
    );
  	else:
		$args = array( 
			'post_type' 		=> $post_type,
			'posts_per_page'	=> $posts_per_page,
      		'orderby'         	=> 'date',
			'order'			 	=> 'DESC',
			'post__not_in' 		=> $post_not_in,
    );
	endif;
	$the_query = new WP_Query( $args );
	if( $the_query->have_posts() ):
		while( $the_query->have_posts() ): $the_query->the_post();
		get_template_part('templates/loop', 'article');
		array_push($post_not_in, get_the_ID());
		endwhile;
	else:
		echo '<p class="warning-post">No Posts Found</p>';
	endif;
	$res->post_not_in = $post_not_in;
	$res->res = ob_get_clean();
	wp_reset_query();
	echo json_encode( $res );
	die();
}

add_action('wp_ajax_load-filter-blog', 'get_filter_blog_request');
add_action('wp_ajax_nopriv_load-filter-blog', 'get_filter_blog_request');

function get_filter_blog_request() {
	global $post;
	$res = new stdClass;
	$res->post = $_POST;
	$res->error = false;
	$res->error_text = '';
	ob_start();

	$post_type = $_POST['post_type'];
	$post_not_in = $_POST['posts_not_in'];
	$post_not_in = array_map('intval', explode(',', $post_not_in));
	$categories = $_POST['category'];
	$args = array();
	if ( $categories != '' ):
		$args = array( 
			'post_type' 		=> $post_type,
			'posts_per_page'	=> -1,
			'orderby'         	=> 'date',
			'order'				=> 'DESC',
            'post__not_in' 		=> $post_not_in,
			'category_name'   	=> $categories,
    );
  	else:
		$args = array( 
			'post_type' 		=> $post_type,
			'posts_per_page'	=> 3,
      		'orderby'         	=> 'date',
			'order'			 	=> 'DESC',
			'post__not_in' 		=> $post_not_in,
    );
	endif;
	$the_query = new WP_Query( $args );
	if( $the_query->have_posts() ):
		while( $the_query->have_posts() ): $the_query->the_post();
		get_template_part('templates/loop', 'article');
		array_push($post_not_in, get_the_ID());
		endwhile;
	else:
		echo '<p class="warning-post">No Posts Found</p>';
	endif;
	$res->res = ob_get_clean();
	$res->post_not_in = $post_not_in;
	$res->post_type = $post_type;
	wp_reset_query();
	echo json_encode( $res );
	die();
}

//Styling login form
function my_login_stylesheet() {
    wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/assets/css/style-login.css' );
    // wp_enqueue_script( 'custom-login', get_stylesheet_directory_uri() . '/style-login.js' );
}
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );

//add categories and tages for pages
function add_categories_to_pages() {
	register_taxonomy_for_object_type( 'category', 'page' );
}
add_action( 'init', 'add_categories_to_pages' );

add_post_type_support( 'page', 'excerpt' );

/**
 * Function that will automatically update ACF field groups via JSON file update.
 * 
 * @link http://www.advancedcustomfields.com/resources/synchronized-json/
 */
function jp_sync_acf_fields() {

	// vars
	$groups = acf_get_field_groups();
	$sync 	= array();

	// bail early if no field groups
	if( empty( $groups ) )
		return;

	// find JSON field groups which have not yet been imported
	foreach( $groups as $group ) {
		
		// vars
		$local 		= acf_maybe_get( $group, 'local', false );
		$modified 	= acf_maybe_get( $group, 'modified', 0 );
		$private 	= acf_maybe_get( $group, 'private', false );

		// ignore DB / PHP / private field groups
		if( $local !== 'json' || $private ) {
			
			// do nothing
			
		} elseif( ! $group[ 'ID' ] ) {
			
			$sync[ $group[ 'key' ] ] = $group;
			
		} elseif( $modified && $modified > get_post_modified_time( 'U', true, $group[ 'ID' ], true ) ) {
			
			$sync[ $group[ 'key' ] ]  = $group;
		}
	}

	// bail if no sync needed
	if( empty( $sync ) )
		return;

	if( ! empty( $sync ) ) { //if( ! empty( $keys ) ) {
		
		// vars
		$new_ids = array();
		
		foreach( $sync as $key => $v ) { //foreach( $keys as $key ) {
			
			// append fields
			if( acf_have_local_fields( $key ) ) {
				
				$sync[ $key ][ 'fields' ] = acf_get_local_fields( $key );
				
			}

			// import
			$field_group = acf_import_field_group( $sync[ $key ] );
		}
	}

}
add_action( 'admin_init', 'jp_sync_acf_fields' );

add_action('acf/init', 'my_acf_init');
function my_acf_init() {
    acf_update_setting('show_updates', true);
    acf_update_setting('google_api_key', 'xxx');
}

//Saving points
add_filter('acf/settings/save_json', 'my_acf_json_save_point');
 
function my_acf_json_save_point( $path ) {
    
    // update path
    $path = get_stylesheet_directory() . '/acf-json';
    
    
    // return
    return $path;
    
}
//Loading points
add_filter('acf/settings/load_json', 'my_acf_json_load_point');

function my_acf_json_load_point( $paths ) {
    
    // remove original path (optional)
    unset($paths[0]);
    
    
    // append path
    $paths[] = get_stylesheet_directory() . '/acf-json';
    
    
    // return
    return $paths;
    
}

//Register ACF gutenburg blocks
function register_acf_block_types() {
	// register a hero block
	acf_register_block(array(
	  'name'				=> 'Hero',
	  'title'				=> __('Hero'),
	  'description'		=> __('A custom Hero block.'),
	  'render_callback'	=> 'hero_block_render_callback',
	  'category'			=> 'formatting',
	  'icon'				=> 'admin-comments',
	  'keywords'			=> array( 'hero', 'quote' ),
	));

	// register a contact form block
	acf_register_block(array(
		'name'				=> 'Contact Form',
		'title'				=> __('Contact Form'),
		'description'		=> __('A custom contact form block.'),
		'render_callback'	=> 'contact_form_block_render_callback',
		'category'			=> 'formatting',
		'icon'				=> 'admin-comments',
		'keywords'			=> array( 'contact', 'quote' ),
	));

	// register a article block
	acf_register_block(array(
		'name'				=> 'Article',
		'title'				=> __('Article'),
		'description'		=> __('A custom article block.'),
		'render_callback'	=> 'article_block_render_callback',
		'category'			=> 'formatting',
		'icon'				=> 'admin-comments',
		'keywords'			=> array( 'article', 'quote' ),
	));

	// register a general post block
	acf_register_block(array(
		'name'				=> 'General Post',
		'title'				=> __('General Post'),
		'description'		=> __('A custom post block.'),
		'render_callback'	=> 'general_post_block_render_callback',
		'category'			=> 'formatting',
		'icon'				=> 'admin-comments',
		'keywords'			=> array( 'post', 'quote' ),
	));

	// register a youtube movie block
	acf_register_block(array(
		'name'				=> 'Cosmin Video',
		'title'				=> __('Cosmin Video'),
		'description'		=> __('A custom video block.'),
		'render_callback'	=> 'video_block_render_callback',
		'category'			=> 'formatting',
		'icon'				=> 'admin-comments',
		'keywords'			=> array( 'video', 'quote' ),
	));

	// register a Media carousel block
	acf_register_block(array(
		'name'				=> 'Media Carousel',
		'title'				=> __('Media Carousel'),
		'description'		=> __('A custom media carousel block.'),
		'render_callback'	=> 'media_carousel_block_render_callback',
		'category'			=> 'formatting',
		'icon'				=> 'admin-comments',
		'keywords'			=> array( 'carousel', 'quote' ),
	));

	// register a contribution block
	acf_register_block(array(
		'name'				=> 'Contribution',
		'title'				=> __('Contribution'),
		'description'		=> __('A custom contribution block.'),
		'render_callback'	=> 'contribution_block_render_callback',
		'category'			=> 'formatting',
		'icon'				=> 'admin-comments',
		'keywords'			=> array( 'contribution', 'quote' ),
	));

	// register a post gallery block
	acf_register_block(array(
		'name'				=> 'Post Gallery',
		'title'				=> __('Post Gallery'),
		'description'		=> __('A custom post gallery block.'),
		'render_callback'	=> 'post_gallery_block_render_callback',
		'category'			=> 'formatting',
		'icon'				=> 'admin-comments',
		'keywords'			=> array( 'post', 'gallery', 'quote' ),
	));

	// register a Introduction block
	acf_register_block(array(
		'name'				=> 'Introduction',
		'title'				=> __('Introduction'),
		'description'		=> __('A custom introduction block.'),
		'render_callback'	=> 'introduction_block_render_callback',
		'category'			=> 'formatting',
		'icon'				=> 'admin-comments',
		'keywords'			=> array( 'introduction', 'quote' ),
	));
}

// Check if function exists and hook into setup.
if( function_exists('acf_register_block_type') ) {
	add_action('acf/init', 'register_acf_block_types');
}

// hero callback function
function hero_block_render_callback( $block ) {
	$slug = str_replace('acf/', '', $block['name']);
	// include a template part from within the "template-parts/block" folder
	if( file_exists( get_theme_file_path("/page-templates/blocks/content-{$slug}.php") ) ) {
		include( get_theme_file_path("/page-templates/blocks/content-{$slug}.php") );
	}
}

// contact form callback function
function contact_form_block_render_callback( $block ) {
	$slug = str_replace('acf/', '', $block['name']);
	// include a template part from within the "template-parts/block" folder
	if( file_exists( get_theme_file_path("/page-templates/blocks/content-{$slug}.php") ) ) {
		include( get_theme_file_path("/page-templates/blocks/content-{$slug}.php") );
	}
}

// article callback function
function article_block_render_callback( $block ) {
	$slug = str_replace('acf/', '', $block['name']);
	// include a template part from within the "template-parts/block" folder
	if( file_exists( get_theme_file_path("/page-templates/blocks/content-{$slug}.php") ) ) {
		include( get_theme_file_path("/page-templates/blocks/content-{$slug}.php") );
	}
}

// general post callback function
function general_post_block_render_callback( $block ) {
	$slug = str_replace('acf/', '', $block['name']);
	// include a template part from within the "template-parts/block" folder
	if( file_exists( get_theme_file_path("/page-templates/blocks/content-{$slug}.php") ) ) {
		include( get_theme_file_path("/page-templates/blocks/content-{$slug}.php") );
	}
}

// general video callback function
function video_block_render_callback( $block ) {
	$slug = str_replace('acf/', '', $block['name']);
	// include a template part from within the "template-parts/block" folder
	if( file_exists( get_theme_file_path("/page-templates/blocks/content-{$slug}.php") ) ) {
		include( get_theme_file_path("/page-templates/blocks/content-{$slug}.php") );
	}
}

// general media carousel callback function
function media_carousel_block_render_callback( $block ) {
	$slug = str_replace('acf/', '', $block['name']);
	// include a template part from within the "template-parts/block" folder
	if( file_exists( get_theme_file_path("/page-templates/blocks/content-{$slug}.php") ) ) {
		include( get_theme_file_path("/page-templates/blocks/content-{$slug}.php") );
	}
}

// general contribution callback function
function contribution_block_render_callback( $block ) {
	$slug = str_replace('acf/', '', $block['name']);
	// include a template part from within the "template-parts/block" folder
	if( file_exists( get_theme_file_path("/page-templates/blocks/content-{$slug}.php") ) ) {
		include( get_theme_file_path("/page-templates/blocks/content-{$slug}.php") );
	}
}

// general contribution callback function
function post_gallery_block_render_callback( $block ) {
	$slug = str_replace('acf/', '', $block['name']);
	// include a template part from within the "template-parts/block" folder
	if( file_exists( get_theme_file_path("/page-templates/blocks/content-{$slug}.php") ) ) {
		include( get_theme_file_path("/page-templates/blocks/content-{$slug}.php") );
	}
}

// general introduction callback function
function introduction_block_render_callback( $block ) {
	$slug = str_replace('acf/', '', $block['name']);
	// include a template part from within the "template-parts/block" folder
	if( file_exists( get_theme_file_path("/page-templates/blocks/content-{$slug}.php") ) ) {
		include( get_theme_file_path("/page-templates/blocks/content-{$slug}.php") );
	}
}

?>