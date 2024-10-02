<?php get_header();
$queried_object = get_queried_object(); 
$taxonomy = $queried_object->taxonomy;
$term_id = $queried_object->term_id; 
?>
<main class="category-company main-template">
	<div class="main-template__container container">
		<section class="main-template__content">
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
			<?php 
				global $post;
				$page_id = $post->ID;
				$page_category_slug = get_the_category($id)[0]->slug;
				$args = array('category_name' => $page_category_slug, 'post_status' => 'publish', 'order' => 'DESC');
				$the_query = new WP_Query($args);
			?>
			<div class="category-company__cards <?php if($page_category_slug === 'hair-salons'){?> category-company-cards--salons <?php }?>">
			<?php
			if ($the_query->have_posts()) {
				while ($the_query->have_posts()) {
				$the_query->the_post();
				$id =  get_the_ID();
				$post = get_post($id);
			?>
			<?php if($page_category_slug === 'hair-stylists'){ 
				$artist_page_link = $post->guid;
				$artist_thumbnail_url = get_the_post_thumbnail_url($post);
				$artist_name = $post->post_title;
				$artist_adress = get_post_meta($id, 'adress', true);
				$artist_phone = get_post_meta($id, 'phone', true);
				$artist_comment_count = $post->comment_count;
				?>
				<div class="category-company__card">
					<div class="card-artist">
						<a href="<?php echo $artist_page_link; ?>" class="card-artist__link-container">
							<img src="<?php echo $artist_thumbnail_url; ?>" alt="" class="card-artist__background-picture">
							<h2 class="h2 card-artist__name w-600 c-white"><?php echo $artist_name; ?></h2>
							<p class="card-artist__adress text c-white"><?php echo $artist_adress; ?></p>
							<p class="card-artist__phone text w-700 c-white"><?php echo $artist_phone; ?></p>
							<p class="card-artist__comment-count text c-white"><?php echo $artist_comment_count; ?> comments</p>
						</a>
					</div>
				</div>
			<?php } ?>
			<?php if($page_category_slug === 'hair-salons'){
				$salon_page_link = $post->guid;
				$salon_thumbnail_url = get_the_post_thumbnail_url($post);
				$salon_name = $post->post_title;
				$salon_adress = get_post_meta($id, 'adress', true);
				$salon_phone = get_post_meta($id, 'phone', true);
				$salon_comment_count = $post->comment_count;
			?>
				<div class="category-company__card">
					<div class="card-salon">
						<a class="card-salon__link" href="<?php  echo $salon_page_link; ?>">
							<img class="card-salon__static-picture" src="<?php echo $salon_thumbnail_url; ?>" alt=""/>
						</a>
						<a class="card-salon__link" href="<?php  echo $salon_page_link; ?>">
							<h3 class="h3 card-salon__name w-600"><?php echo $salon_name; ?></h3>
						</a>
						<p class="card-salon__adress text"><?php echo $salon_adress; ?></p>
						<p class="card-salon__phone text w-700"><?php echo $salon_phone; ?></p>
						<p class="card-salon__comment-count text c-gray "><?php echo $salon_comment_count; ?> comments</p>
					</div>
				</div>
			<?php } ?>
			<?php 
				}
			}
					// endwhile; 
				?>
			</div>
			<?php kama_pagenavi(); ?>
		</section>
		<aside class="main-template__sidebar">
			<?php get_sidebar(); ?>
		</aside>  
	</div>
</main>
<?php get_footer(); ?>