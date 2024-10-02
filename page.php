<?php get_header(); ?>
<main class="main-template">
	<div class="main-template__container container">
		<?php while (have_posts()) : the_post(); ?>
		<section class="main-template__content">
			<?php echo dimox_breadcrumbs();?>
			<article class="main-template__article">
				<div class="title-box-top">
					<h1 class="h1"><?php the_title(); ?></h1>
				</div>
				<div class="description-box">
					<?php the_content('Read more&raquo;'); ?>
				</div>
			</article>
			<?php endwhile; ?>
		</section>
		<aside class="main-template__sidebar">
			<?php get_sidebar(); ?>
		</aside>
	</div>
</main>
<?php get_footer(); ?>