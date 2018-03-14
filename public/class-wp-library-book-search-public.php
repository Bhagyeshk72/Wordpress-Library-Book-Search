<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    wp-library-book-search
 * @subpackage wp-library-book-search/public/
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    wp-library-book-search
 * @subpackage wp-library-book-search/public
 * @author     Bhagyesh Koshti <bhagyeshk72@gmail.com>
 */
class WP_Library_Book_Search_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * Enqueue style
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-library-book-search-public.css', array(), $this->version, 'all' );
		
		wp_register_style('wp_lbs_jquery_ui', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
		wp_enqueue_style('wp_lbs_jquery_ui');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * Register script
		 */

		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-library-book-search-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'wp_library_book_search_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
		wp_enqueue_script( $this->plugin_name );
		
		wp_enqueue_script( 'jquery-ui-core ' );
		wp_enqueue_script( 'jquery-ui-slider' );

	}
	
	/**
	 * Register Book Custom Post type.
	 *
	 * @since    1.0.0
	 */
	public function wp_library_book_search_plugin_register_book_cpt() {

		$labels = array(
			'name'               => _x( 'Books', 'post type general name', 'wp-library-book-search' ),
			'singular_name'      => _x( 'Book', 'post type singular name', 'wp-library-book-search' ),
			'menu_name'          => _x( 'Books', 'admin menu', 'wp-library-book-search' ),
			'name_admin_bar'     => _x( 'Book', 'add new on admin bar', 'wp-library-book-search' ),
			'add_new'            => _x( 'Add New', 'book', 'wp-library-book-search' ),
			'add_new_item'       => __( 'Add New Book', 'wp-library-book-search' ),
			'new_item'           => __( 'New Book', 'wp-library-book-search' ),
			'edit_item'          => __( 'Edit Book', 'wp-library-book-search' ),
			'view_item'          => __( 'View Book', 'wp-library-book-search' ),
			'all_items'          => __( 'All Books', 'wp-library-book-search' ),
			'search_items'       => __( 'Search Books', 'wp-library-book-search' ),
			'parent_item_colon'  => __( 'Parent Books:', 'wp-library-book-search' ),
			'not_found'          => __( 'No books found.', 'wp-library-book-search' ),
			'not_found_in_trash' => __( 'No books found in Trash.', 'wp-library-book-search' )
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Book Custom post type.', 'wp-library-book-search' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'lbs_book' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
		);

		register_post_type( 'lbs_book', $args );

	}
	
	/**
	 * Register Author and publisher taxonomy.
	 *
	 * @since    1.0.0
	 */
	public function wp_library_book_search_plugin_register_book_taxonomy() {

		register_taxonomy(
			'lbs_author',
					'lbs_book',
					array(
						'label' => __( 'Author' ),
						'rewrite' => array( 'slug' => 'lbs_author' ),
						'hierarchical' => true,
					)
			);
			
		register_taxonomy(
			'lbs_publisher',
				'lbs_book',
				array(
					'label' => __( 'Publisher' ),
					'rewrite' => array( 'slug' => 'lbs_publisher' ),
					'hierarchical' => true,
				)
			);
	}
	
	/**
	 * Redirect to plugin single page on book detail page.
	 *
	 * @since    1.0.0
	 */		
	public function wp_library_book_custom_template($single){
		global $wp_query, $post;

		/* Checks for single template by post type */
		if ( $post->post_type == 'lbs_book' ) {
			if ( file_exists( plugin_dir_path( __FILE__ ) . '/partials/wp-library-book-search-single-page.php' ) ) {
				return plugin_dir_path( __FILE__ ) . '/partials/wp-library-book-search-single-page.php';
			}
		}
		return $single;
	}
	
	/**
	 * Add shortcode [lbs-library-book] for display search form.
	 *
	 * @since    1.0.0
	 */	
	public function wp_library_book_search_plugin_shortcode(){
		?>
		<div class="lbs-book-search-wrap">
				<h2>Book Search</h2>
				<div class="lbs-form-wrap">
					<form action="<?php echo site_url(); ?>" method="POST" id="lbs-book-search-form">
						<div class="lbs-book-fields left-wrap">
							<label for="lbs_book_name"><?php _e( 'Book Name : ', 'wp-library-book-search' ); ?></label>
							<input type="text" id="lbs_book_name" name="lbs_book_name" placeholder="book name"/>
						</div>
						
						<div class="lbs-book-fields right-wrap">
							<label for="lbs_book_author"><?php _e( 'Author : ', 'wp-library-book-search' ); ?></label>
							<input type="text" id="lbs_book_author" name="lbs_book_author" placeholder="author"/>
						</div>
						
						<div class="lbs-book-fields left-wrap">
							<label for="lbs_book_publisher"><?php _e( 'Publisher : ', 'wp-library-book-search' ); ?></label>
							<select id="lbs_book_publisher" name="lbs_book_publisher">
								<option value="0">Select Publisher</option>
								<?php 
									$terms = get_terms('lbs_publisher');
									if ($terms) {
										foreach($terms as $term) { ?>
											<option value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
										<?php
										} 
									} 
								?>
							</select>
						</div>
												
						<div class="lbs-book-fields right-wrap">
							<label for="lbs_book_rating"><?php _e( 'Rating : ', 'wp-library-book-search' ); ?></label>
							<select id="lbs_book_rating" name="lbs_book_rating">
							<option value="0">Select Rating</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							</select>
						</div>
						
						<div class="lbs-book-fields left-wrap">
							<label for="lbs_book_display_amount">Price range:</label>
							<input type="text" id="lbs_book_display_amount" readonly>
							<input type="hidden" id="lbs_book_price_min" name="lbs_book_price_min" value="1">
							<input type="hidden" id="lbs_book_price_max" name="lbs_book_price_max" value="3000">
							<div id="slider-range"></div>
						</div>	
				
						<input type="hidden" name="action" value="lbs_book_search_ajax">
						<input type="hidden" name="lbs-search-book-ajax-nonce" id="lbs-search-book-ajax-nonce" value="<?php echo wp_create_nonce( 'lbs-search-book-ajax-nonce' ); ?>" />
					
						<div class="lbs-search-btn-wrap">
							<input type="submit" name="lbs-submit" value="Search">
						</div>
					</form>
				</div>
				
				<div class="lbs-book-search-result"></div>
		</div>
		<?php
	}
}
