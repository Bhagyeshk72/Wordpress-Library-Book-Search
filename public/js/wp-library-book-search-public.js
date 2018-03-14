/* 
 * Slider for Price field and Ajax call for search functionality
*/

jQuery(function () {
	jQuery("#slider-range").slider({
		range: true,
		min: 1,
		max: 3000,
		values: [1, 3000],
		slide: function (event, ui) {
			jQuery("#lbs_book_display_amount").val(ui.values[0] + " - " + ui.values[1]);
			jQuery("#lbs_book_price_min").val(ui.values[0]);
			jQuery("#lbs_book_price_max").val(ui.values[1]);
		}
	});
	jQuery("#lbs_book_display_amount").val(jQuery("#slider-range").slider("values", 0) + " - " + jQuery("#slider-range").slider("values", 1));
	jQuery("#lbs-book-search-form").submit(function (e) {
		e.preventDefault();
		var input_data = jQuery(this).serialize();
		jQuery.ajax({
			type: "POST",
			url: wp_library_book_search_ajax.ajax_url,
			data: input_data,
			success: function (alrt) {
				jQuery('.lbs-book-search-result').html(alrt);
			}
		});
	});
});