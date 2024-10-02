<?php
// --------------------------Start-----------------------------------------------------------
// Layout of Metabox authors and artists of post with Popup for Author and  Links for Artists
// --------------------------Start------------------------------------------------------------
add_action('section_author_of_post', 'section_author_of_post_template');
function section_author_of_post_template()
{
    if (is_single()) {
        global $post;
        $author_id = $post->post_author;
        $autor_nicename =  get_the_author_meta('nicename', $author_id);
        $autor_firstname =  get_the_author_meta('first_name', $author_id);
        $autor_lastname =  get_the_author_meta('last_name', $author_id);
        $autor_description = get_the_author_meta('user_description', $author_id);
        $autor_description_yoast = get_the_author_meta('wpseo_metadesc', $author_id);
        $user = get_userdata($author_id);
        $id =  get_the_ID();
        $post = get_post($id);
        $all_artists_added_to_article_json = get_post_meta($id, 'metabox-artists', false);
        $all_artists_added_to_article = json_decode($all_artists_added_to_article_json[0], false);

        $default = get_stylesheet_directory_uri() . '/i/default-image.png';
        if (get_the_author_meta('thumbnail', $user->ID)) {
            $image_attributes = wp_get_attachment_image_src(get_the_author_meta('thumbnail', $user->ID), 'thumb_author');
            $src = $image_attributes[0];  
        } else { 
            $src = $default;
        }   
?>
        <?php if (in_array('author', (array) $user->roles) && !empty($autor_firstname)) {
        ?>
            <div class="authors-post w-500" id="autors_of_post_top_section">
                by
                <div class="author-trigger__wrapper">
                    <a onclick="event.preventDefault()" class="author-click-link text-underline" data-author-click-link="<?php echo $autor_nicename; ?>"><?php echo $autor_firstname . ' ' . $autor_lastname; ?></a>
                    <div class="author-popup hidden" data-author-popup="<?php echo $autor_nicename; ?>">
                        <div class="author-popup__header">
                            <div class="author-popup__avatar">
                                <img data-src="<?php echo $default; ?>" src="<?php echo $src; ?>" />
                            </div>
                            <p class="author-popup__name"><strong><?php echo $autor_firstname . ' ' . $autor_lastname; ?></strong></p>
                            <div class="author-popup__close">
                                <img src="<?php echo get_template_directory_uri() ?>/i/icons/author_popup-close.png" />
                            </div>
                        </div>
                        <p class="author-popup__description w-400"><?php echo $autor_description_yoast; ?></p>
                        <p class="author-popup__readbio w-700"><a href="/author/<?php echo $autor_nicename; ?>/" class="text-underline w-700">Read full bio</a></p>
                        <p class="author-popup__editorial w-700"><a href="#" class="text-underline w-700">Editorial guidelines <img src="<?php echo get_template_directory_uri() ?>/i/icons/author_popup-arrow.png" class="author-popup__arrow"></a></p>
                    </div>
                </div>
                <?php
                    $artitst_to_post_metabox_shortcodes = get_post_meta(get_the_ID(), '_add_artits_to_post_key', true);
                    if (!empty($artitst_to_post_metabox_shortcodes)) {
                        $artists_templates .= do_shortcode($artitst_to_post_metabox_shortcodes);
                    }
                    echo $artists_templates; 
                ?>

                <!-- <p class="authors-post__date w-500">Last updated on <?php // echo get_post_modified_time('F j, Y', false); ?></p> -->
            </div>
        <?php }
        ?>

    <?php
    }
}
// --------------------------End--00----------------------------------------------------------
// Layout of Metabox authors and artists of post with Popup for Author and Links for Artists
// --------------------------End-------------------------------------------------------------




// --------------------------Start-----------------------------------------------------------
// Layout of Metabox Authors and Artists of post with PopUp for Authors and Artists
// --------------------------Start-----------------------------------------------------------
add_action('section_author_of_post_with_popup', 'author_of_post_with_popup_template');
function author_of_post_with_popup_template()
{
    if (is_single()) {
        global $post;
        $author_id = $post->post_author;
        $autor_nicename =  get_the_author_meta('nicename', $author_id);
        $autor_firstname =  get_the_author_meta('first_name', $author_id);
        $autor_lastname =  get_the_author_meta('last_name', $author_id);
        $autor_description = get_the_author_meta('user_description', $author_id);
        $autor_description_yoast = get_the_author_meta('wpseo_metadesc', $author_id);
        $user = get_userdata($author_id);
        $id =  get_the_ID();
        $post = get_post($id);
        $all_artists_added_to_article_json = get_post_meta($id, 'metabox-artists', false);
        $all_artists_added_to_article = json_decode($all_artists_added_to_article_json[0], false);

        $default = get_stylesheet_directory_uri() . '/i/default-image.png';
        if (get_the_author_meta('thumbnail', $user->ID)) {
            $image_attributes = wp_get_attachment_image_src(get_the_author_meta('thumbnail', $user->ID), 'thumb_author');
            $src = $image_attributes[0];  
        } else { 
            $src = $default;
        }  
?> 
        <?php if (in_array('author', (array) $user->roles) && !empty($autor_firstname)) {
        ?>
            <div class="authors-post w-500" id="autors_of_post_top_section">
                by
                <div class="author-trigger__wrapper">
                    <a onclick="event.preventDefault()" class="author-click-link text-underline" data-author-click-link="<?php echo $autor_nicename; ?>"><?php echo $autor_firstname . ' ' . $autor_lastname; ?></a>
                    <div class="author-popup hidden" data-author-popup="<?php echo $autor_nicename; ?>">
                        <div class="author-popup__header">
                            <div class="author-popup__avatar">
                                <img data-src="<?php echo $default; ?>" src="<?php echo $src; ?>" />
                            </div>
                            <p class="author-popup__name"><strong><?php echo $autor_firstname . ' ' . $autor_lastname; ?></strong></p>
                            <div class="author-popup__close">
                                <img src="<?php echo get_template_directory_uri() ?>/i/icons/author_popup-close.png" />
                            </div>
                        </div>
                        <p class="author-popup__description w-400"><?php echo $autor_description_yoast; ?></p>
                        <p class="author-popup__readbio w-700"><a href="/author/<?php echo $autor_nicename; ?>/" class="text-underline w-700">Read full bio</a></p>
                        <p class="author-popup__editorial w-700"><a href="#" class="text-underline w-700">Editorial guidelines <img src="<?php echo get_template_directory_uri() ?>/i/icons/author_popup-arrow.png" class="author-popup__arrow"></a></p>
                    </div>
                </div>

                <?php
                $count_of_artists = 0;
                foreach ($all_artists_added_to_article as $artist) {
                    $status = $artist->status;
                    $artist_name = $artist->name;
                    $artist_link = $artist->link;

                    if ($status === 'yes' && $count_of_artists <= 2 && $artist_name !== '') {
                        $count_of_artists++; 

                ?> 
                    <div class="author-trigger__wrapper artist-trigger__wrapper">
                        <span class="artist-click-container"> 
                            <a class="text-underline" href="<?php echo $artist_link; ?>"><?php echo $artist_name; ?></a>
                        </span>
                    </div>
                <?php
                    }
                } ?>

                <!-- <p class="authors-post__date w-500">Last updated on <?php // echo get_post_modified_time('F j, Y', false); ?></p> -->
            </div>
        <?php }
        ?>

    <?php
    }
}
// --------------------------End-------------------------------------------------------------
// Layout of Metabox Authors and Artists of post with PopUps for Authors and Artists
// --------------------------End-------------------------------------------------------------
