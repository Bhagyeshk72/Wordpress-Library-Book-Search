<?php

/**
 * Provide a admin area view for the plugin information page.
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 *
 * @package    wp-library-book-search
 * @subpackage wp-library-book-search/admin/partials
 */
 
?>

<div id="wp-library-book-search-admin-page">
	<h1>WP Library Book Search Details</h1>
	<p>This Plugin is based on library book search which will be based on book name, author, publisher, price, book rating. You have to use Shortcode <strong>[lbs-library-book]</strong> on any post/page editor side to display search tool on front side.</p>
	<p><strong>Important Note : You have to <a href="<?php echo admin_url('edit.php?post_type=lbs_book'); ?>" title="add books">add books</a> and assign author, publisher, add price and rating in custom fields.</strong></p>
	<p>See below screens for WP Library Book Search Plugin Setup.</p>
	<p>Step - 1 : Add Books</p>
	<img src="<?php echo WP_LIBRARY_BOOK_SEARCH_URL; ?>admin/images/lbs-books.png">
	<p>Step - 2 : Add Shortcode</p>
	<img src="<?php echo WP_LIBRARY_BOOK_SEARCH_URL; ?>admin/images/lbs-shortcode.png">
</div>
