<div class="sidebar">
	<?php //  dynamic_sidebar( 'sidebar' ); ?>


	<div class="sidebar__list-questions">
		<?php
		$arg_2 = array('post_type' => 'post', 'post_status' => 'publish', 'category_name' => 'ask-hair-expert', 'posts_per_page' => 5);
		global $post;
		$query_2 = new WP_Query($arg_2);
		if ($query_2->have_posts()) { ?>
			<div class="list-questions">
				<div class="title-box-top">
					<?php // echo options_theme('title_home_2'); 
					?>
					<div class="title-box-top__title">
						<h2 class="h2">Questions</h2>
					</div>
				</div>
				<ul class="list-questions__container">
					<?php while ($query_2->have_posts()) {
						$query_2->the_post();
						// $i_sl_2++;
					?>
						<li class="list-questions__item h2 w-400"><a href="<?php the_permalink(); ?>" class="c-black"><?php the_title(); ?></a></li>
					<?php } ?>
				</ul>

			</div>
		<?php }
		wp_reset_query(); ?>
	</div> 

	<div class="sidebar__advertising-box">
		<div align="center" data-freestar-ad="__325x385" id="hadvisecom_category_right_rail_2">
			<script data-cfasync="false" type="text/javascript">
				freestar.config.enabled_slots.push({ placementName: "hadvisecom_category_right_rail_2", slotId: "hadvisecom_category_right_rail_2" });
			</script>
		</div>
	</div>
	
	<div class="sidebar__box-questions">
		<div class="side-box-questions">
			<img class="side-box-questions__picture" src="<?php echo get_template_directory_uri(); ?>/i/images/questions-girl-master.png" alt="" >
			<h2 class="side-box-questions__title h2 w-700">Have a question?</h2>
			<h3 class="side-box-questions__description h3 w-400">Get all of your hair questions answered by our experts! It's FREE!</h3>
			<div class="side-box-questions__button text-uppercase button-white">
				<a href="<?php echo get_category_link(options_theme('home_2_cat')); ?>" class="h4">Add question</a>
			</div>
		</div>
	</div>

	<div class="sidebar__advertising-box-2">
		<div align="center" data-freestar-ad="__300x600" id="hadvisecom_category_right_rail_2">
			<script data-cfasync="false" type="text/javascript">
				freestar.config.enabled_slots.push({ placementName: "hadvisecom_category_right_rail_2", slotId: "hadvisecom_category_right_rail_2" });
			</script>
		</div>
	</div>
</div>