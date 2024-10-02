<?php if (comments_open()) : ?>
	<!-- <div id="comments" class="comments_wrap-box"> -->
	<div class="comments-box">
		<?php if ( have_comments() ) : ?>		
		<div class="comments-box__header ">
			<div class="title-box-top">
				<h2 class="title-box-top__title h2">Comments</h2>
				<h2 class="title-box-top__link h2 c-red" id="button-comments-colapse">Colapse</h2>
			</div>
		</div>
		<div class="comments-box__list-comments-container">
			<ul class="list-commets">
				<?php wp_list_comments(array('callback' => 'theme_comments')); ?>
			</ul>
		</div>
		<?php endif; ?>
		<div class="comments-box__comment-form">
			<?php echo get_template_part('commentform'); ?>
		</div>
	</div>
<?php endif; ?>
