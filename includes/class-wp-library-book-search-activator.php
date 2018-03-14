<?php

/**
 * Fired during plugin activation
 *
 *
 * @package    wp-library-book-search
 * @subpackage wp-library-book-search/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    wp-library-book-search
 * @subpackage wp-library-book-search/includes
 * @author     Bhagyesh Koshti <bhagyeshk72@gmail.com>
 */
class WP_Library_Book_Search_Activator {

	/**
	 * Set transient
	 */
	public static function activate() { 
		set_transient( '_wp_library_book_search_admin_notice_activation', true, 5 );
	}

}
