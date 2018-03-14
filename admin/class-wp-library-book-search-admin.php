<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    wp-library-book-search
 * @subpackage wp-library-book-search/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    wp-library-book-search
 * @subpackage wp-library-book-search/admin
 * @author     Bhagyesh Koshti <bhagyeshk72@gmail.com>
 */
class WP_Library_Book_Search_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_wp_library_book_search_plugin_styles() {

		/**
		 * Enqueue admin style
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-library-book-search-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
	}
	
	
	/**
	 * Display plugin acvitvation notice for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function wp_library_book_search_plugin_activation_notice() {

		if( get_transient( '_wp_library_book_search_admin_notice_activation' ) ){
		?>
			<div class="updated notice is-dismissible">
				<p>Thank you for using this plugin! Use Shortcode <strong>[lbs-library-book]</strong> on any post/page editor side to display search tool on front side.</p>
				<p><a href="<?php echo admin_url('admin.php?page=wp_library_book_search_plugin_menu'); ?>" title="view details">View plugin information</a></p>
			</div>
		<?php 
		delete_transient( '_wp_library_book_search_admin_notice_activation' );
		}
	}
	
	/**
	 * Book rating and price custom field validation.
	 *
	 * @since    1.0.0
	 */
	public function wp_library_book_search_plugin_books_meta_notice() {

		if( get_transient( '_wp_library_book_search_admin_notice_books_meta' ) ){
		?>
			<div class="updated notice is-dismissible">
				<p>Add Book Price / Rating values to save these fields.</p>
			</div>
		<?php 
		delete_transient( '_wp_library_book_search_admin_notice_books_meta' );
		}
	}

	
	/**
	 * Register the Admin mnu for wp library book search plugin for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function wp_library_book_search_plugin_admin_menu() {

		add_menu_page(
			'WP Library Book Search Plugin', 
			__('WP Library Book Search Plugin'), 
			'manage_options', 
			'wp_library_book_search_plugin_menu', 
			array($this, 'wp_library_book_search_plugin_menu_page'), 
			'dashicons-welcome-widgets-menus'
		);  		
	}
	
	/**
	 * Provide a admin area view for the plugin information page.
	 *
	 * @since    1.0.0
	 */	
	public function wp_library_book_search_plugin_menu_page() { 
        require_once('partials/wp-library-book-search-plugin-information-page.php');
    }
	
	/**
	 * Add meta box for book custom fields like price and rating.
	 *
	 * @since    1.0.0
	 */		
	public function wp_library_book_search_plugin_meta_box() {

		add_meta_box(
			'wp_library_book_search_plugin_meta_box_id',
			'Book Rating & Price Details',
			array( $this, 'wp_library_book_search_plugin_meta_box_callback' ),
			'lbs_book', 
			'normal', 
			'high'
		);
	}

	/**
	 * Plugin Book meta box callback function for admin area.
	 *
	 * @since    1.0.0
	 */
	public function wp_library_book_search_plugin_meta_box_callback() {
		
		global $post; 
		wp_nonce_field( 'wp_library_book_search_plugin_meta_box_data', 'wp_library_book_search_plugin_meta_box_nonce' );

		/*
		 * Use get_post_meta() to retrieve an existing value
		 * from the database and use the value for the form.
		 */
		$lbs_book_price_value = get_post_meta( $post->ID, '_lbs_book_price', true );
		$lbs_book_rating_value = get_post_meta( $post->ID, '_lbs_book_rating', true );
		?>
		
		<div class="lbs_book_price_wrap">
			<label for="lbs_book_price"><?php _e( 'Book Price : ', 'wp-library-book-search' ); ?></label>
			<input type="number" id="lbs_book_price" name="lbs_book_price" value="<?php echo esc_attr( $lbs_book_price_value ); ?>" placeholder="Add Book Price" min="1"/>
		</div>
		
		<div class="lbs_book_rating_wrap">
			<label for="lbs_book_rating"><?php _e( 'Book Rating : ', 'wp-library-book-search' ); ?></label>
			<select id="lbs_book_rating" name="lbs_book_rating">
				<option value="0">Select Rating</option>
				<option value="1" <?php if($lbs_book_rating_value == 1) { echo "selected" ;} ?>>1</option>
				<option value="2" <?php if($lbs_book_rating_value == 2) { echo "selected" ;} ?>>2</option>
				<option value="3" <?php if($lbs_book_rating_value == 3) { echo "selected" ;} ?>>3</option>
				<option value="4" <?php if($lbs_book_rating_value == 4) { echo "selected" ;} ?>>4</option>
				<option value="5" <?php if($lbs_book_rating_value == 5) { echo "selected" ;} ?>>5</option>
			</select>
		</div>
		
	<?php
	}


	/**
	 * When the post is saved, saves our books custom data.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	 public  function wp_library_book_search_plugin_save_meta_box_data( $post_id ) {

		 if ( ! isset( $_POST['wp_library_book_search_plugin_meta_box_nonce'] ) ) {
			return;
		 }

		 if ( ! wp_verify_nonce( $_POST['wp_library_book_search_plugin_meta_box_nonce'], 'wp_library_book_search_plugin_meta_box_data' ) ) {
			return;
		 }

		 if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		 }

		 // Check the user's permissions.
		 if ( isset( $_POST['post_type'] ) && 'lbs_book' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
		 } else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		 }
		 
		 if ( !$_POST['lbs_book_price'] || !$_POST['lbs_book_rating']) { 
			 set_transient( '_wp_library_book_search_admin_notice_books_meta', true, 5 );
			return false;
		 }

		 $lbs_book_price = $_POST['lbs_book_price'];
		 $lbs_book_rating = $_POST['lbs_book_rating'];

		 update_post_meta( $post_id, '_lbs_book_price', $lbs_book_price );
		 update_post_meta( $post_id, '_lbs_book_rating', $lbs_book_rating );
	}

	/**
	 * Ajax function for display search result.
	 *
	 */	
	
	public function lbs_book_search_ajax(){
		
		check_ajax_referer( 'lbs-search-book-ajax-nonce', 'lbs-search-book-ajax-nonce' );

		if($_REQUEST['lbs_book_author'] && $_REQUEST['lbs_book_publisher']){
			
			$taxquery = array(
					'relation' => 'AND',
					array(
						'taxonomy' => 'lbs_author',
						'field'    => 'name',
						'terms'    => $_REQUEST['lbs_book_author'],
					),
					array(
						'taxonomy' => 'lbs_publisher',
						'field'    => 'term_id',
						'terms'    => $_REQUEST['lbs_book_publisher'],
					),
				);
			
		} else if($_REQUEST['lbs_book_author'] && $_REQUEST['lbs_book_publisher'] == 0){
			
			$taxquery = array(
					'relation' => 'AND',
					array(
						'taxonomy' => 'lbs_author',
						'field'    => 'name',
						'terms'    => $_REQUEST['lbs_book_author'],
					)
					
				);
				
		} else if(!$_REQUEST['lbs_book_author'] && $_REQUEST['lbs_book_publisher']){
			
			$taxquery = array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'lbs_publisher',
					'field'    => 'term_id',
					'terms'    => $_REQUEST['lbs_book_publisher'],
				)
			);
		}
	
		if($_REQUEST['lbs_book_rating'] && $_REQUEST['lbs_book_price_min'] && $_REQUEST['lbs_book_price_max']){
			
			$metaquery = array(
						'relation' => 'AND',
						array(
							'key'     => '_lbs_book_rating',
							'value'   => $_REQUEST['lbs_book_rating'],
							'compare' => '=',
						),
						array(
							'key'     => '_lbs_book_price',
							'value'   => array( $_REQUEST['lbs_book_price_min'], $_REQUEST['lbs_book_price_max'] ),
							'type'    => 'numeric',
							'compare' => 'BETWEEN',
						),
						
			);
			
		} else if(!$_REQUEST['lbs_book_rating'] && $_REQUEST['lbs_book_price_min'] && $_REQUEST['lbs_book_price_max']){
			
			$metaquery = array(
							'relation' => 'AND',
							
							array(
								'key'     => '_lbs_book_price',
								'value'   => array( $_REQUEST['lbs_book_price_min'], $_REQUEST['lbs_book_price_max'] ),
								'type'    => 'numeric',
								'compare' => 'BETWEEN',
							),
						);
		}
	
		$args = array(
					'post_type'=> 'lbs_book',
					'post_status' => 'publish',
					'posts_per_page' => -1,
					's' => $_REQUEST['lbs_book_name'],
					'tax_query' => $taxquery,
					'meta_query' => $metaquery
				);    
		
		$search_query = new WP_Query( $args );

		if ( $search_query->have_posts() ) { 
			$counter = 1;
		?>
		<table>
			<tr>
				<th style="width:8%">No</th>
				<th style="width:30%">Book Name</th>
				<th style="width:12%">Price</th>
				<th style="width:15%">Author</th>
				<th style="width:15%">Publisher</th>
				<th style="width:20%">Rating</th>
			</tr>
		
		<?php 
		while ( $search_query->have_posts() ) {
				$search_query->the_post();
			?>
			<tr>
				<td>
					<?php echo $counter; ?>
				</td>
				<td>
					<a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
				</td>
				<td>
					<?php echo get_post_meta( get_the_ID(), '_lbs_book_price', true ); ?>
				</td>
				<td>
					<?php
						$terms = get_the_terms( get_the_ID() ,  'lbs_author');
						if($terms){ 
							foreach ( $terms as $term ) {
								$term_link = get_term_link( $term,  'lbs_author');
								?>
									<a href="<?php echo $term_link; ?>"><?php echo $term->name; ?></a>
								<?php 
							}
				
						}
					?>
				</td>
				<td>
					<?php 
						$terms_publisher = get_the_terms( get_the_ID() ,  'lbs_publisher');
						if($terms_publisher){ 
							foreach ( $terms_publisher as $term_publisher ) {
								$term_publisher_link = get_term_link( $term_publisher,  'lbs_author');
								?>
									<a href="<?php echo $term_publisher_link; ?>"><?php echo $term_publisher->name; ?></a>
								<?php 
								}
						} ?>
				</td>
				<td class="front-rating-wrap">
					<?php 
					$rating_value = get_post_meta( get_the_ID(), '_lbs_book_rating', true ); 
					for($rating_counter = 1; $rating_counter <= 5; $rating_counter++){
						if($rating_counter <= $rating_value){
							echo "<span class='highlight'>★</span>";
						} else {
							echo "<span>★</span>";
						}
					} 
					?>
				</td>
			
			</tr>
			<?php $counter++;
			}
				
			wp_reset_postdata(); ?>
			
		</table>
		<?php 
		} else { 
		?>
			<h3>No Books found!</h3>
		<?php 
		}
		die();
	}
}