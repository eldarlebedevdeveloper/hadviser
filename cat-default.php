<?php get_header();
$queried_object = get_queried_object(); 
$taxonomy = $queried_object->taxonomy;
$term_id = $queried_object->term_id; 
?>
<main class="category-default main-template">
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
			<div class="category-default__cards">
				<?php while (have_posts()) : the_post();$is++; $s++; ?>
						<div class="category-default__card <?php if($is==2){ ?> last-element<?php } ?>">
							<div class="card-article">
								<div class="card-article__picture">
									<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumb_1'); ?></a>
								</div>
								<div class="card-article__text-container">
									<h2 class="card-article__title h2"><a href="<?php the_permalink(); ?>" class="c-black"><?php echo wp_trim_words(get_the_title(), 8);?></a></h2>
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
						<?php if($is==2){ ?>
							<div class="main-template__advertising">
								<div class="advertising-box-big">
									<?php if (function_exists('get_category_ad_block')) echo get_category_ad_block(); ?>
								</div>
							</div>
						
						<?php $is=0;} ?>
				<?php endwhile; ?>
			</div>
			<?php kama_pagenavi(); ?>
		</section>
		<aside class="main-template__sidebar">
			<?php get_sidebar(); ?>
		</aside>  
	</div>
</main>
<?php get_footer(); ?>