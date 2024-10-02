<?php get_header();
$queried_object = get_queried_object(); 
$taxonomy = $queried_object->taxonomy;
$term_id = $queried_object->term_id; 
?>

<main class="category-questions main-template">
	<div class="main-template__container container">
		<section class="category-questions__content main-template__content">
			<?php echo dimox_breadcrumbs();?>
			<article class="main-template__header">
				<div class="title-box-top">
					<h1 class="h1"><?php single_cat_title(); ?></h1>
				</div>
				<?php if ( $paged < 2 ) { ?>
				<?php if (category_description()) { ?>
					<div class="description-box"><?php echo category_description(); ?></div>
				<?php } } ?>
			</article>
			<?php $users = get_option("users_".$cat_id); if($users){?>
			

			<div class="category-questions__authors">
				<?php foreach($users as $user_id ) {
				// $user_info = get_userdata($user_id);
				$autor_firstname =  get_the_author_meta('first_name', $user_id);
				$autor_lastname =  get_the_author_meta('last_name', $user_id);
				$autor_description = get_the_author_meta('user_description', $user_id);

				$autor_facebook = get_the_author_meta('fb', $user_id);
				$autor_instagram = get_the_author_meta('insta', $user_id);
				$autor_twitter = get_the_author_meta('twitter', $user_id);
				$autor_linkedin = get_the_author_meta('linkedin', $user_id);
				$autor_medium = get_the_author_meta('medium', $user_id);
				$autor_pinterest = get_the_author_meta('pinterest', $user_id);
	            $template_directory_uri = get_template_directory_uri();

				$default = get_stylesheet_directory_uri() . '/i/default-image.png';
				if (get_the_author_meta('thumbnail', $user_id)) {
					$image_attributes = wp_get_attachment_image_src(get_the_author_meta('thumbnail', $user_id), 'thumb_author');
					$src = $image_attributes[0];
				} else {
					$src = $default;
				}
		
				?>
				<div class="category-questions-authors__card">
					<div class="card-author">
						<?php //if(get_the_author_meta('thumbnail',$id)){ ?>
						<div class="card-author__picture">
							<?php // echo wp_get_attachment_image(get_the_author_meta('thumbnail',$id), 'thumb_5'); ?>
							<img data-src="<?php echo $default; ?>" src="<?php echo $src; ?>" alt=""> 
						</div>
						<?php //} ?>
						<div class="card-author__container">
							<div class="card-author__name">
								<p class="text w-600"><?php echo $autor_firstname . ' ' . $autor_lastname; ?></p>
							</div>
							<div class="card-author__social-links">
								<div class="socia-icons">
								<?php if (!empty($autor_facebook)) { ?>
									<a class="socia-icons__item" href='<?php echo $autor_facebook ?>'><img src='<?php echo $template_directory_uri ?>/i/icons/social-facebook-red.svg' /></a>
								<?php } ?>
								<?php if (!empty($autor_instagram)) { ?>
									<a class="socia-icons__item" href='<?php echo $autor_instagram ?>'><img src='<?php echo $template_directory_uri ?>/i/icons/social-instagram-red.svg' /></a>
								<?php } ?>
								<?php if (!empty($autor_linkedin)) { ?>
									<a class="socia-icons__item" href='<?php echo $autor_linkedin ?>'><img src='<?php echo $template_directory_uri ?>/i/icons/social-linkedin.svg' /></a>
								<?php } ?>
								<?php if (!empty($autor_twitter)) { ?>
									<a class="socia-icons__item" href='<?php echo $autor_twitter ?>'><img src='<?php echo $template_directory_uri ?>/i/icons/social-twitter.svg' /></a>
								<?php } ?>
								<?php if (!empty($autor_medium)) { ?>
									<a class="socia-icons__item" href='<?php echo $autor_medium ?>'><img src='<?php echo $template_directory_uri ?>/i/icons/social-medium.svg' /></a>
								<?php } ?>
								<?php if (!empty($autor_pinterest)) { ?>
									<a class="socia-icons__item" href='<?php echo $autor_pinterest ?>'><img src='<?php echo $template_directory_uri ?>/i/icons/social-pinterest-red.svg' /></a>
								<?php } ?>
								
								</div>
							</div>
							<div class="card-author__profession"><h5 class="h5 w-400 c-gray">Hairstylist</h5></div>
							<div class="card-author__description"><h4 class="h4 c-total-black"><?php echo $autor_description; ?></h4></div>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
			<?php } ?>
			<div class="category-questions__form-contact">
				<div class="form-contact">
					<?php echo do_shortcode("[contact-form-7 id='6926' title='Ask hair expert' html_class='form-contact']"); ?>
				</div>
			</div>
			<div class="category-questions__list-questions">
				<div class="list-questions">
					<?php
					$questions_category_id = get_cat_ID('Questions');
					$questions_category_link = get_category_link($questions_category_id);
					?>
					<div class="title-box-top">
						<div class="title-box-top__title">
							<h2 class="h2">New</h2>
						</div>
						<div class="title-box-top__link">
							<h2 class="h2 text-underline w-400"><a href="<?php echo $questions_category_link; ?>" class="c-black">All questions</a></h2>
						</div>
					</div>
					<ul class="list-questions__container">
						<?php while (have_posts()) : the_post();$is++; $s++; 
						?>
							<li class="list-questions__item h2 w-400"><a href="<?php the_permalink(); ?>" class="c-black"><?php the_title(); ?></a></li>
						<?php endwhile; ?>
						<script id="true_loadmore">
						var ajaxurl = '<?php   echo site_url() ?>/wp-admin/admin-ajax.php';
						var true_posts = '<?php  echo serialize($wp_query->query_vars); ?>';
						var current_page = <?php echo (get_query_var('paged')) ? get_query_var('paged') : 1; ?>;
						var max_pages = '<?php echo $wp_query->max_num_pages; ?>';
					</script>
					</ul>
				</div>
			</div>
		</section>
		<aside class="category-questions__sidebar main-template__sidebar">
			<?php get_sidebar(); ?>
		</aside>  
	</div>
</main>
<?php get_footer(); ?>