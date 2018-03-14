<?php
/**
 * The template for displaying all single posts for books
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package    wp-library-book-search
 * @subpackage wp-library-book-search/public/partials
 */

get_header(); ?>

<div class="lbs-single-book-page-wrap">
	<div id="primary" class="content-area">
		

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();
				
				the_title("<h1>","</h1>");
				$terms = get_the_terms( get_the_ID() ,  'lbs_author');
				
				if($terms){ ?>
					<p>Author : 
						<?php
							foreach ( $terms as $term ) {
								$term_link = get_term_link( $term,  'lbs_author');
								?>
									<a href="<?php echo $term_link; ?>"><?php echo $term->name; ?></a>
							<?php 
							}
						?>
					</p>
				<?php
				}
				
				$terms_publisher = get_the_terms( get_the_ID() ,  'lbs_publisher');
				if($terms_publisher) { ?>
					<p>Publisher : 
						<?php
							foreach ( $terms_publisher as $term_publisher ) {
								$term_publisher_link = get_term_link( $term_publisher,  'lbs_author');
								?>
									<a href="<?php echo $term_publisher_link; ?>"><?php echo $term_publisher->name; ?></a>
								<?php 
							} 
						?>
					</p>
				<?php
				}
								
				echo "<p>Price : " . get_post_meta( get_the_ID(), '_lbs_book_price', true ) . "</p>";
				echo "<p>Rating : " . get_post_meta( get_the_ID(), '_lbs_book_rating', true ) . "</p>";
				the_content();
							
			endwhile; // End of the loop.
			?>

	</div><!-- #primary -->
	
</div><!-- .wrap -->

<?php get_footer();
