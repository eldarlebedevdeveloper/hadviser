<?php get_header(); ?>
<main class="single-company main-template">
	<div class="main-template__container container">
		<?php while (have_posts()) : the_post(); ?>
			<section class="main-template__content">
				<?php echo dimox_breadcrumbs(); ?>
				<article class="single-company__article main-template__article">
					<div class="single-company__header">
						<?php the_post_thumbnail('medium'); ?>
						<h1 class="h1"><?php the_title();?></h1>
						<p class="text c-gray"><?php comments_number('0 comments', '1 comments', '% comments'); ?></p>
					</div>
					<div class="single-company__content">
						<div class="single-company__description">
							<h3 class="h3 w-600">About artist:</h3>
							<?php if (get_post_meta($post->ID, 'artist_description', true)) { ?>
								<?php echo wpautop(get_post_meta($post->ID, 'artist_description', true)); ?>
							<?php } ?>
						</div>
						<div class="single-company__contacts">
							<h3 class=" h3 w-600">Contacts:</h3>
							<?php if (get_post_meta($post->ID, 'phone', true)) { ?>
								<p class="text">
									<img src="<?php echo get_template_directory_uri() ?>/i/icons/company-phone.svg" alt="">
									<a class="c-black w-600" href="tel:<?php echo preg_replace('/[^\d+]/', '', get_post_meta($post->ID, 'phone', true)); ?>"><?php echo get_post_meta($post->ID, 'phone', true); ?></a>
								</p>
							<?php } ?>
							<?php if (get_post_meta($post->ID, 'adress', true)) { ?>
								<p class="text">
									<img src="<?php echo get_template_directory_uri() ?>/i/icons/company-location.svg" alt="">
									<?php echo get_post_meta($post->ID, 'adress', true); ?>
								</p>
							<?php } ?>
							<?php if (get_post_meta($post->ID, 'site_link', true)) { ?>
								<p class="text">
									<img src="<?php echo get_template_directory_uri() ?>/i/icons/company-link.svg" alt="">
									<a class="c-red w-600" href="<?php echo get_post_meta($post->ID, 'site_link', true); ?>" target="_blank"><?php echo get_post_meta($post->ID, 'site_name', true); ?></a>
								</p>
							<?php } ?>
							<?php if (get_post_meta($post->ID, 'googlemap', true)) { ?>
								<div class="single-company__map">
									<?php echo wpautop(get_post_meta($post->ID, 'googlemap', true)); ?>
								</div>
							<?php } ?>
						</div>

						<?php the_content('Читать далее&raquo;'); ?>
					</div>
				</article>
				<div class="single-company__share">
					<div class="rating_buttons_post">
						<?php
						// $cats =  get_the_category();
						// $cat_id = $cats[0]->cat_ID;
						// if ($cat_id == 1) {
						// 	$title_rating = "Rate artist";
						// } elseif ($cat_id == 33) {
						// 	$title_rating = "Rate salon";
						// } else {
						// 	$title_rating = "Rate company";
						// }
						?>
						<!-- <div class="linkes-stat"><?php // echo $title_rating; ?></div> -->
						<!-- <div class="ratingb-share">
							<?php // if (function_exists("kk_star_ratings")) : echo kk_star_ratings($pid); endif; ?>
						</div> -->
					</div>
				</div>
				<?php endwhile; ?>
				<div class="single-company__comments">
					<?php comments_template(); ?>
				</div>
			</section>
			<aside class="main-template__sidebar">
				<?php get_sidebar(); ?>
			</aside>  
	</div>
</main>
<?php get_footer(); ?>