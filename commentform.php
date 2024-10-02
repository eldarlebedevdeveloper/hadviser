		<div id="respond" class="comments-form">
			<div class="comments-form__header">
				<div class="title-box-top">
					<h2 class="title-box-top__title h2"><?php cancel_comment_reply_link('Cancel'); ?></h2>
				</div>
			</div>
			<div class="comments-form__body">
				<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
				<?php else : ?>
					<?php if ( $user_ID ) : ?>
					<form class="comments-form__form" action="<?php bloginfo('url'); ?>/wp-comments-post.php" method="post" id="commentform">
						<div class="comments-form__textarea">
							<textarea  required id="comment" name="comment" class="comtextarea" rows="5" cols="50" placeholder="Enter your comment"></textarea>
						</div>
						<div class="comments-form__submit">
							<div class="button-more-red">
								<input class="button-more-red__link h4 text-uppercase" name="submit" type="submit" id="submit" value="Add comment" class="button">
							</div>
						</div>

						<?php else : ?>

						<form class="comments-form__form" action="<?php bloginfo('url'); ?>/wp-comments-post.php" method="post" id="commentform1">
							<?php $commenter = wp_get_current_commenter(); // Данные о комментаторе ?>
							<div class="comments-form__field">
								<label for="author"><h4 class="h4 w-500">Your name</h4></label>
								<input id="author" type="text" class="ninput1" required name="author" value="<?php echo empty($commenter['comment_author']) ? '' : $commenter['comment_author']; ?>" tabindex="2" placeholder="Enter your name">
							</div>
							<div class="comments-form__field">
								<label for="email"><h4 class="h4 w-500">E-mail</h4></label>
								<input id="email" type="text" name="email" required class="ninput2" value="<?php echo empty($commenter['comment_author_email']) ? '' : $commenter['comment_author_email']; ?>" tabindex="3" placeholder="Enter e-mail">
							</div>
							<div class="comments-form__textarea">
								<label for="comment"><h4 class="h4 w-500">Comment</h4></label>
								<textarea required  id="comment" name="comment" class="comtextarea" placeholder="Enter your comment"></textarea>
							</div>
							<div class="comments-form__submit">
								<div class="button-more-red">
									<input class="button-more-red__link h4 text-uppercase" name="submit" type="submit" id="submit" value="Add comment" class="button">
								</div>
							</div>
						<?php endif; ?>
							<?php comment_id_fields(); ?>
							<?php do_action('comment_form', $post->ID); ?>
						</form>

				<?php endif; // if ( get_option('comment_registration') && !$user_ID ) ?>
			</div>
		</div>