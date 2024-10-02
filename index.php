<?php
get_header();
$goplyak_settings = get_option('goplyak_settings');
?>

<section class="home-most-popular">
	<div class="container">

		<div class="title-box-top">
			<h2 class="h2">Most popular</h2>
		</div>

		<div class="home-most-popular__cards-container  ">
			<div class="swiper-wrapper">
				
			
				<!-- <div class="home-most-popular__card swiper-slide">
						<div class="card-article<?php // if ($i_sl == 3) { ?> <?php // $i_sl = 0;} ?>">
							<div class="card-article__picture">
								<a href="<?php // the_permalink(); ?>"> <img src="https://hadviserprod.local/wp-content/uploads/2024/06/4-1-1.png" alt=""></a>
							</div>
							<div class="card-article__text-container">
								<p class="card-article__categories text text-capitalize">Categroy ?></p>
								<h2 class="card-article__title h2"><a href="<?php // the_permalink(); ?>" class="c-black">50 Best Short Haircuts and Hairstyles for Fine Hair50 Best Short Haircuts and Hairstyles for Fine Hair</a></h2>
								<div class="card-article__meta">
									<h3 class="card-article__author h3 c-gray w-400 text-lowercase">by Autroh</h3>
									<div class="card-article__button">
										<div class="button-more-red">
											<a href="<?php //the_permalink(); ?>" class="button-more-red__link h4 text-uppercase">Read more</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div> -->
			<?php
			$arg_1 = array('post_type' => 'post', 'post_status' => 'publish', 'category__not_in' => $goplyak_settings['home_1_cat'], 'orderby' => "meta_value_num", 'order' => 'DESC', 'meta_key' => 'views', 'posts_per_page' => 3);
			$query_1 = new WP_Query($arg_1);
			if ($query_1->have_posts()) { ?>
				<?php while ($query_1->have_posts()) {
					$query_1->the_post();
					// $i_sl++;
					global $post; ?>
					
					<div class="home-most-popular__card swiper-slide">
						<div class="card-article<?php // if ($i_sl == 3) { ?> <?php // $i_sl = 0;} ?>">
							<div class="card-article__picture">
								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumb_1'); ?></a>
							</div>
							<div class="card-article__text-container">
								<p class="card-article__categories text text-capitalize"><?php the_category('/'); ?></p>
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
				<?php } ?>
			</div>
			
		</div>
		<div class="home-popular-post__prev swiper-button-prev"></div>
  		<div class="home-popular-post__next swiper-button-next"></div>
		
		<div class="home-popular-post__pagination swiper-pagination"></div>
		
	<?php }
			wp_reset_query(); ?> 
	</div>
</section> 



<div align="center" data-freestar-ad="__336x280 __728x280" id="hadvisecom_homepage_incontent">
	<script data-cfasync="false" type="text/javascript">
		freestar.config.enabled_slots.push({
			placementName: "hadvisecom_homepage_incontent",
			slotId: "hadvisecom_homepage_incontent"
		});
	</script>
</div>

<section class="home-page-questions">
	<div class="home-page-questions__container container">
		<div class="home-page-questions__list">
			<?php
			$arg_2 = array('post_type' => 'post', 'post_status' => 'publish', 'category_name' => 'ask-hair-expert', 'posts_per_page' => 10);
			global $post;
			$query_2 = new WP_Query($arg_2);
			if ($query_2->have_posts()) { ?>
				<div class="list-questions">
					<div class="title-box-top">
						<?php // echo options_theme('title_home_2'); 
						?>
						<div class="title-box-top__title">
							<h2 class="h2">Q&A</h2>
						</div>
						<div class="title-box-top__link">
							<h2 class="h2 text-underline w-400 "><a href="<?php echo get_category_link(options_theme('home_2_cat')); ?>" class="c-black">All questions</a></h2>
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
			<?php // get_template_part('box-question'); 
			?>
		</div>
		<div class="home-page-questions__sidebar">
			<div class="side-box-questions">
				<img class="side-box-questions__picture" src="<?php echo get_template_directory_uri(); ?>/i/images/questions-girl-master.png" alt="" >
				<h2 class="side-box-questions__title h2 w-700">Have a question?</h2>
				<h3 class="side-box-questions__description h3 w-400">Get all of your hair questions answered by our experts! It's FREE!</h3>
				<div class="side-box-questions__button text-uppercase button-white">
					<a href="<?php echo get_category_link(options_theme('home_2_cat')); ?>" class="h4">Add question</a>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="home-page-artists">
	<div class="container">
		<?php
		$artists_category_id = get_cat_ID('Artists');
		$artists_category_link = get_category_link($artists_category_id);
		?>
		<div class="title-box-top">
			<div class="title-box-top__title">
				<h2 class="h2">Artists</h2>
			</div>
			<div class="title-box-top__link">
				<h2 class="h2 text-underline w-400"><a href="<?php echo $artists_category_link; ?>" class="c-black">View all artists</a></h2>
			</div>
		</div>
		<div class="home-page-artists__cards-container">
			<div class="swiper-wrapper">
				<?php
				$args = array('category_name' => 'hair-stylists', 'post_status' => 'publish', 'order' => 'DESC', 'posts_per_page' => 4);
				$the_query = new WP_Query($args);
				if ($the_query->have_posts()) {
					while ($the_query->have_posts()) {
						$the_query->the_post();
						$id =  get_the_ID();
						$post = get_post($id);
						$artist_page_link = $post->guid;
						$artist_thumbnail_url = get_the_post_thumbnail_url($post);
						$artist_name = $post->post_title;
						$artist_adress = get_post_meta($id, 'adress', true);
						$artist_phone = get_post_meta($id, 'phone', true);
						$artist_comment_count = $post->comment_count;
				?>
				<div class="home-page-artists__card swiper-slide">
					<div class="card-artist">
						<a href="<?php echo $artist_page_link; ?>" class="card-artist__link-container">
							<img src="<?php echo $artist_thumbnail_url; ?>" alt="" class="card-artist__background-picture">
							<h2 class="h2 card-artist__name w-600 c-white"><?php echo $artist_name; ?></h2>
							<p class="card-artist__adress text c-white"><?php echo $artist_adress; ?></p>
							<p class="card-artist__phone text w-700 c-white"><?php echo $artist_phone; ?></p>
							<p class="card-artist__comment-count text text-underline c-white"><?php echo $artist_comment_count; ?> comments</p>
						</a> 
					</div>
				</div>
				<?php
					}
				} else {
					esc_html_e('Artists not found.');
				}
				// Restore original Post Data.
				wp_reset_postdata();
				?>
			</div>
		</div> 
		 
		<div class="home-page-artists__prev swiper-button-prev"></div>
  		<div class="home-page-artists__next swiper-button-next"></div>
		
		<div class="home-page-artists__pagination swiper-pagination"></div>
	</div> 
</section>

<section class="home-page-salons">
	<?php
	$salons_category_id = get_cat_ID('Salons');
	$salons_category_link = get_category_link($salons_category_id);
	?>
	<div class="container">
		<div class="title-box-top">
			<div class="title-box-top__title">
				<h2 class="h2">Salons</h2>
			</div>
			<div class="title-box-top__link">
				<h2 class="h2 text-underline w-400"><a href="<?php echo $salons_category_link; ?>" class="c-black">View all salons</a></h2>
			</div>
		</div>
		<div class="home-page-salons__cards-container">
			<div class="swiper-wrapper">
				<?php
				$args = array('category_name' => 'hair-salons', 'post_status' => 'publish', 'order' => 'DESC', 'posts_per_page' => 4);
				// The Query.
				$the_query = new WP_Query($args);

				// The Loop.
				if ($the_query->have_posts()) {
					while ($the_query->have_posts()) {
						$the_query->the_post();
						$id =  get_the_ID();
						$post = get_post($id);
						$salon_page_link = $post->guid;
						$salon_thumbnail_url = get_the_post_thumbnail_url($post);
						$salon_name = $post->post_title;
						$salon_adress = get_post_meta($id, 'adress', true);
						$salon_phone = get_post_meta($id, 'phone', true);
						$salon_comment_count = $post->comment_count;
				?>
				<div class="home-page-salons__card swiper-slide">
					<div class="card-salon">
						<a class="card-salon__link" href="<?php  echo $salon_page_link; ?>">
							<img class="card-salon__static-picture" src="<?php echo $salon_thumbnail_url; ?>" alt=""/>
						</a>
						<a class="card-salon__link" href="<?php  echo $salon_page_link; ?>">
							<h2 class="h2 card-salon__name w-600"><?php echo $salon_name; ?></h2>
						</a>
						<p class="card-salon__adress text"><?php echo $salon_adress; ?></p>
						<p class="card-salon__phone text w-700"><?php echo $salon_phone; ?></p>
						<p class="card-salon__comment-count text text-underline"><?php echo $salon_comment_count; ?> comments</p>
						<!-- </a> -->
					</div>
				</div>
						 
				<?php

					}
				} else {
					esc_html_e('Salons not found.');
				}
				// Restore original Post Data.
				wp_reset_postdata();
				?>
			</div>
		</div>
			
		<div class="home-page-salons__prev swiper-button-prev"></div>
  		<div class="home-page-salons__next swiper-button-next"></div>
		
		<div class="home-page-salons__pagination swiper-pagination"></div>
	</div>
</section>

<main class="home-latest-articles">
	<div class="home-latest-articles__container container">
		<div class="title-box-top">
			<div class="title-box-top__title">
				<h2 class="h2">Latest articles</h2>
			</div>
		</div>
		<section class="home-latest-articles__content">
			<?php $query_foot_1 = new WP_Query(array('post_type' => 'post', 'post_status' => 'publish', 'category__not_in' => $goplyak_settings['home_6_cat'], 'orderby' => 'date', 'order' => 'DESC', 'posts_per_page' => 7));
			if ($query_foot_1->have_posts()) {
				while ($query_foot_1->have_posts()) {
					$query_foot_1->the_post();
					// $isf_1++;
					global $post; ?>
					<div class="home-latest-articles__card">
						<div class="card-article-horizontal">
							<div class="card-article-horizontal__picture">
								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumb_1'); ?></a>
							</div>
							<div class="card-article-horizontal__text-container">
								<div class="card-article-horizontal__categories text-capitalize text-underline text"><?php the_category('/'); ?></div>
								<h2 class="card-article-horizontal__title h2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<!-- <div class="card-article-horizontal__description text"><?php // echo kama_excerpt(array('maxchar' => 20)); ?></div> -->
								<div class="card-article-horizontal__description text">
									<?php echo wp_trim_words(get_the_excerpt(), 20); ?>
								</div>
								<div class="card-article-horizontal__meta">
									<h3 class="card-article-horizontal__author h3 w-400 c-gray text-lowercase">by <?php the_author(); ?></h3>
									<div class="card-article-horizontal__button">
										<div class="button-more-red">
											<a href="<?php the_permalink(); ?>" class="button-more-red__link h4  text-uppercase">Read more</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
		<?php }
				wp_reset_query(); ?>

			<div class="home-latest-articles__load-more">
				<div class="home-latest-articles__load-more-button">
					<div class="button-more-red">
						<a href="#" class="button-more-red__link h4  text-uppercase">Load more</a>
					</div>
				</div>
			</div>
		</section>
		<aside class="home-latest-articles__sidebar">
			<?php dynamic_sidebar('sidebar_home'); ?>
		</aside>
	</div>
</main>


<!-- </div> -->

<script>
	const homeMostPopularSlider = new Swiper('.home-most-popular__cards-container', {
		direction: 'horizontal',
		loop: true, 
		speed: 600,
		pagination: {
			el: '.home-popular-post__pagination',
		},
		navigation: {
			nextEl: '.home-popular-post__next',
			prevEl: '.home-popular-post__prev',
		}, 
		slidesPerView: 'auto',
		// slidesPerView: 1.05,     
		initialSlide: 0,  
		breakpoints: {
			// 576:{
			// 	slidesPerView: 'auto',
			// } 
		}
	});
</script>
  

<script>
	const homeArtistslider = new Swiper('.home-page-artists__cards-container', {
		direction: 'horizontal',
		loop: true, 
		speed: 600,
		navigation: {
			nextEl: '.home-page-artists__next',
			prevEl: '.home-page-artists__prev',
		}, 
		pagination: {
			el: '.home-page-artists__pagination',
		},
		slidesPerView: 1.05,    
		initialSlide: 0,  
		breakpoints: {
			576:{
				slidesPerView: 'auto',
			}
		}
	});
</script> 
  
<script>
	const homeSalonsslider = new Swiper('.home-page-salons__cards-container', {
		direction: 'horizontal',
		loop: true, 
		speed: 600,
		navigation: {
			nextEl: '.home-page-salons__next',
			prevEl: '.home-page-salons__prev',
		}, 
		pagination: {
			el: '.home-page-salons__pagination',
		},
		slidesPerView: 1.05,    
		initialSlide: 0,  
		breakpoints: {
			576:{
				slidesPerView: 'auto',
			}
		}
	});
</script>

 

<?php get_footer(); ?>  