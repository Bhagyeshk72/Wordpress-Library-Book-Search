<?php

/**
 * The Library Book Search Plugin
 *
 * This Plugin is based on library book search which will be based on book name, author, publisher, price, book rating. 
 * Use Shortcode [lbs-library-book] on any post/page editor side to display search tool on front side.
 *
 * @wordpress-plugin
 * Plugin Name:       WP Library Book Search
 * Plugin URI:        https://github.com/Bhagyeshk72/Wordpress-Library-Book-Search-Plugin
 * Description:       This Plugin is based on library book search plugin, Use Shortcode [lbs-library-book] on any post/page editor side to display search tool on front side.
 * Version:           1.0.0
 * Author:            Bhagyesh Koshti
 * Author URI:        https://github.com/Bhagyeshk72/Wordpress-Library-Book-Search-Plugin
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-library-book-search
 */

/**
 * If this file is called directly, abort.
 */
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'WP_LIBRARY_BOOK_SEARCH_VERSION', '1.0.0' );
define( 'WP_LIBRARY_BOOK_SEARCH_URL', plugin_dir_url( __FILE__ ) );


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-library-book-search-activator.php
 */
function activate_wp_library_book_search_plugin() { 
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-library-book-search-activator.php';
	WP_Library_Book_Search_Activator::activate();
	
}

register_activation_hook( __FILE__, 'activate_wp_library_book_search_plugin' );


/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-library-book-search-deactivator.php
 */
function deactivate_wp_library_book_search_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-library-book-search-deactivator.php';
	WP_Library_Book_Search_Deactivator::deactivate();
}


register_deactivation_hook( __FILE__, 'deactivate_wp_library_book_search_plugin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-library-book-search.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_library_book_search() {

	$plugin = new WP_Library_Book_Search();
	$plugin->run();

}
run_wp_library_book_search();
