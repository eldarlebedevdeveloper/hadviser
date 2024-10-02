<?php get_header(); ?>
<main class="content-vnpage">
	<div class="wrap">
		<section class="left-boxcont category-tpls">
			<?php echo dimox_breadcrumbs();?>
			<article class="post">
				<div class="post-title-line">
					<h1>Search results for "<?php echo get_search_query() ?>"</h1>
				</div>
			</article>
			<div class="ist-companies-posts cat-erap-top">
				<?php while (have_posts()) : the_post();$is++; $s++; ?>
						<div class="item-popular_posts<?php if($is==2){ ?> last-element<?php } ?>">
							<div class="thumb-item_post">
								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumb_1'); ?></a>
							</div>
							<div class="cat-item_post"><?php the_category(', '); ?></div>
							<div class="title-popular_posts"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
							<div class="meta-popular_posts">
								<div class="author-item_post">by <?php the_author(); ?></div>
								<div class="more-item_post"><a href="<?php the_permalink(); ?>" class="button-more">Read more</a></div>
							</div>
						</div>
						<?php if($is==2){ ?><div class="clear mobile-hidden"></div><?php $is=0;} ?>
				<?php endwhile; ?>
			</div>
			<?php kama_pagenavi(); ?>
		</section>
		<?php get_sidebar(); ?>
	</div>
</main>
<?php get_footer(); ?>