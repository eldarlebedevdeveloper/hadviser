<?php get_header(); ?>
<main class="content-vnpage">
    <div class="wrap">
        <section class="left-boxcont">
            <?php echo dimox_breadcrumbs(); ?>
            <?php
            $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
            $author_nickname = $curauth->nickname;
            $author_description = $curauth->user_description;
            $autor_facebook = get_the_author_meta('fb', $author_id);
            $autor_instagram = get_the_author_meta('insta', $author_id);
            $autor_twitter = get_the_author_meta('twitter', $author_id);
            $autor_linkedin = get_the_author_meta('linkedin', $author_id);
            $autor_medium = get_the_author_meta('medium', $author_id);
            $autor_pinterest = get_the_author_meta('pinterest', $author_id);
            $template_directory_uri = get_template_directory_uri();
            
            $default = get_stylesheet_directory_uri() . '/i/default-image.png';
            if (get_the_author_meta('thumbnail', $author_id)) {
                $image_attributes = wp_get_attachment_image_src(get_the_author_meta('thumbnail', $author_id), 'thumb_author');
                $src = $image_attributes[0];
            } else {
                $src = $default;
            }
            ?>

            <div class='author-information'>
                <div class='author-information__picture'>
                    <img data-src='<?php echo $default ?>' src='<?php echo $src ?>' />
                </div>
                <div class="author-information__content">
                    <h5 class='author-information__name'><?php echo $author_nickname; ?></h5>
                    <ul class='author-information__social-links'>
                        <?php if (!empty($autor_facebook)) { ?>
                            <li><a href='<?php echo $autor_facebook ?>'><img src='<?php echo $template_directory_uri ?>/i/icons/social-facebook.svg' /></a></li>
                        <?php } ?>
                        <?php if (!empty($autor_instagram)) { ?>
                            <li><a href='<?php echo $autor_instagram ?>'><img src='<?php echo $template_directory_uri ?>/i/icons/social-instagram.svg' /></a></li>
                        <?php } ?>
                        <?php if (!empty($autor_linkedin)) { ?>
                            <li><a href='<?php echo $autor_linkedin ?>'><img src='<?php echo $template_directory_uri ?>/i/icons/social-linkedin.svg' /></a></li>
                        <?php } ?>
                        <?php if (!empty($autor_twitter)) { ?>
                            <li><a href='<?php echo $autor_twitter ?>'><img src='<?php echo $template_directory_uri ?>/i/icons/social-twitter.svg' /></a></li>
                        <?php } ?>
                        <?php if (!empty($autor_medium)) { ?>
                            <li><a href='<?php echo $autor_medium ?>'><img src='<?php echo $template_directory_uri ?>/i/icons/social-medium.svg' /></a></li>
                        <?php } ?>
                        <?php if (!empty($autor_pinterest)) { ?>
                            <li><a href='<?php echo $autor_pinterest ?>'><img src='<?php echo $template_directory_uri ?>/i/icons/social-pinterest.svg' /></a></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="author-information__description"><?php echo $author_description; ?></div>
            </div>
            <div class="author-posts-by">
                <h3 class="author-posts-by__title w-500">Posts by <?php echo $author_nickname; ?>:</h3>
                <ul class="author-posts-by__list">
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                            <li class="author-posts-by__item ">
                                <a href="<?php the_permalink() ?>" class="text-underline" rel="bookmark" title="Permanent Link: <?php the_title(); ?>">
                                    <?php the_title(); ?></a>,
                                <?php the_time('d M Y'); ?> in <?php the_category('&'); ?>
                            </li>

                        <?php endwhile;
                    else : ?>
                        <p><?php _e('No posts by this author.'); ?></p>

                    <?php endif; ?>
                </ul>
            </div>
        </section>
        <?php get_sidebar(); ?>
    </div>
</main>
<?php get_footer(); ?>