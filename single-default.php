<?php get_header(); ?>
<main class="single-default main-template">
	<div class="main-template__container container">
		<?php while (have_posts()) : the_post(); ?>

			<section class="main-template__content">
				<?php if (function_exists('FreeStar_player')) {
					echo FreeStar_player();
				} ?>
				<?php echo dimox_breadcrumbs(); ?>
				<article class="single-defaul__article main-template__article">
					<div class="title-box-top">
						<h1 class="h1"><?php the_title(); ?></h1>
					</div>
					<div class="description-box">
						<?php do_action('section_author_of_post');?>
						<?php do_action('top_adv_hook'); ?>
						<?php the_content('Read more&raquo;'); ?>
						<?php do_action('bottom_adv_hook'); ?>
						<?php do_action('post_extra_content', $post); ?>
					</div>

				</article>
				<div style="margin-top: 50px;"></div>
				<?php if (function_exists('vidverto_player')) {
					echo vidverto_player();
				} ?>
				<?php endwhile; ?>

				<div class="single-default__related-posts">
					<div class="related-posts">
						<div class="related-posts__header">
							<h2 class="h2">Related Posts</h2>
						</div>
						<form class="related-posts__search-form">
							<div class="related-posts__search-field">
								<input type="text" placeholder="Search here">
							</div>
							<div class="related-posts__search-button">
								<button class="button-more-red">
									<h4 class="button-more-red__link h4">Search</h4>
								</button>
							</div>
						</form>
						<div class="related-posts__cards">
							<div class="related-posts__card">
								<div class="card-related">
									<div class="card-related__picture">
										<img src="https://hadviserprod.local/wp-content/uploads/2024/07/1-1.png" alt="">
									</div>
									<p class="card-related__title text w-500">20 Flattering Short Hairstyles for Older Women with Thin...</p>
								</div>
							</div>
							<div class="related-posts__card">
								<div class="card-related">
									<div class="card-related__picture">
										<img src="https://hadviserprod.local/wp-content/uploads/2024/07/2.png" alt="">
									</div>
									<p class="card-related__title text w-500">50 Screenshot-Worthy Short Layered Hairstyles</p>
								</div>
							</div>
							<div class="related-posts__card">
								<div class="card-related">
									<div class="card-related__picture">
										<img src="https://hadviserprod.local/wp-content/uploads/2024/07/3.png" alt="">
									</div>
									<p class="card-related__title text w-500">50 Best Short Haircuts and Hairstyles for Fine Hair</p>
								</div>
							</div>
							<div class="related-posts__card">
								<div class="card-related">
									<div class="card-related__picture">
										<img src="https://hadviserprod.local/wp-content/uploads/2024/07/4-2.png" alt="">
									</div>
									<p class="card-related__title text w-500">30 Versatile Short Gray Hairstyles for Any Age and H...</p>
								</div>
							</div>
							<div class="related-posts__card">
								<div class="card-related">
									<div class="card-related__picture">
										<img src="https://hadviserprod.local/wp-content/uploads/2024/07/3.png" alt="">
									</div>
									<p class="card-related__title text w-500">50 Best Short Haircuts and Hairstyles for Fine Hair</p>
								</div>
							</div>
							<div class="related-posts__card">
								<div class="card-related">
									<div class="card-related__picture">
										<img src="https://hadviserprod.local/wp-content/uploads/2024/07/4-2.png" alt="">
									</div>
									<p class="card-related__title text w-500">30 Versatile Short Gray Hairstyles for Any Age and H...</p>
								</div>
							</div>
						</div>
					</div>
				</div>

				<?php
				$categories = get_the_category($post->ID);
				if ($categories) {
					$category_ids = array();
					foreach ($categories as $individual_category) $category_ids[] = $individual_category->term_id;
					$args = array(
						'category__in' => $category_ids,
						'post__not_in' => array($post->ID),
						'showposts' => 2,
						'caller_get_posts' => 1
					);
					$my_query = new wp_query($args);
					if ($my_query->have_posts()) { ?>
						<?php if (function_exists('mgid_test')) {
							echo mgid_test();
						}
				?>
				<div class="single-default__read-next">
					<div class="title-box-top">
						<h2 class="h2">Read next</h2>
					</div>
					<div class="single-default__cards">
						<?php while ($my_query->have_posts()) {
							$my_query->the_post();
							$is++;
							global $post; ?>
							<div class="single-default__card">
								<div class="card-article">
									<div class="card-article__picture">
										<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumb_1'); ?></a>
									</div>
									<div class="card-article__text-container">
										<h2 class="card-article__title h2"><a href="<?php the_permalink(); ?>" class="c-black"><?php the_title(); ?></a></h2>
										<div class="card-article__meta">
											<h3 class="card-article__author h3 c-gray w-400 text-lowercase">by <?php the_author(); ?></h3>
											<div class="card-article__button">
												<div class="button-more-red">
													<a href="<?php the_permalink(); ?>" class="button-more-red__link h4 text-uppercase">Read more</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php if ($is == 2) {
								$is = 0;
							}
						} ?>
					</div>
				</div>
			<?php }
				wp_reset_query();
			} ?>


			<?php comments_template(); ?>
			</section>
			<aside class="main-template__sidebar">
				<?php get_sidebar(); ?>
			</aside>  
	</div>
</main>
<?php get_footer(); ?>