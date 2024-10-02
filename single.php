<?php get_header();
	$cats =  get_the_category();
    $cat_id = $cats[0]->cat_ID;
    if(get_option("cattpl_".$cat_id) == 2){
      require('single-company.php');
	} else {
	  require('single-default.php');
	}
get_footer(); ?>