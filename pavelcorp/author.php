<?php 
	if ( is_author() ) {
    // Redirect to homepage, set status to 301 permenant redirect. 
    // Function defaults to 302 temporary redirect. 
    wp_redirect(get_option('home'), 301); 
    exit; 
	} ?>