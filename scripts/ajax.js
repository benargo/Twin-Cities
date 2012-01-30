/*********************************************************
 * @file: ajax.js
 * @package: twincities
 * @created: 23 January 2012
 * @updated: 23 January 2012
 * @author: 10008548, 09011635 & XXXXXXXX
 *
 * This JavaScript file forms the basis of pulling the
 * applications in via AJAX.
 *
 * Uses Framework: jQuery
 *********************************************************/

$("nav a").click(function(event) {
	
	event.preventDefault();
 	
	// Set a variable for the app we need
	var app = $(this).attr("href");

	// Begin AJAX
	
	$.ajax({
		
		url: "config/ajax.php?app="+ app,
		context: document.body,
		success: function(data) {
		
			$("#primary-content-area article").html(data);
		
		}
		
	}); 
	
});