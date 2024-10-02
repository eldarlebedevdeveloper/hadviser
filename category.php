<?php $queried_object = get_queried_object(); 
$taxonomy = $queried_object->taxonomy;
$term_id = $queried_object->term_id; 
 $category = get_the_category(); 
	$cat_id = get_query_var('cat');
    if(get_option("cattpl_".$cat_id) == 2){
      require('cat-company.php');
    } elseif(get_option("cattpl_".$cat_id) == 3) {
		require('cat-questions.php');
	} else {
		require('cat-default.php');
	} 
?>