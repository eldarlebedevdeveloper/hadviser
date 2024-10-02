<?php

function author_comment_with_author_info($atts, $content = null) {
    $output = '';
    if (is_single()) {
        global $post;
        $author_id = $post->post_author;
        $author_firstname =  get_the_author_meta('first_name', $author_id);
        $author_lastname =  get_the_author_meta('last_name', $author_id);
        $user = get_userdata($author_id);
      
        $author_facebook = get_the_author_meta('fb', $author_id);
        $author_instagram = get_the_author_meta('insta', $author_id);
        $author_twitter = get_the_author_meta('twitter', $author_id);
        $author_linkedin = get_the_author_meta('linkedin', $author_id);
        $author_medium = get_the_author_meta('medium', $author_id);
        $author_pinterest = get_the_author_meta('pinterest', $author_id);
        $template_directory_uri = get_template_directory_uri();

        $default = get_stylesheet_directory_uri() . '/i/default-image.png';
        if (get_the_author_meta('thumbnail', $user->ID)) {
            $image_attributes = wp_get_attachment_image_src(get_the_author_meta('thumbnail', $user->ID), 'thumb_author');
            $src = $image_attributes[0];  
        } else { 
            $src = $default;
        }  
        $output .= '
        <div class="author-comment">
            <div class="author-comment__message-container">
                <div class="author-comment__message">
                    <p class="text">' . esc_html($content) . '  <img class="author-comment__brackets" src="' . esc_url($template_directory_uri) . '/i/icons/shortcode-author-brackets.svg" /></p>
                    <img class="author-comment__tringle" src="' . esc_url($template_directory_uri) . '/i/icons/shortcode-author-tringle.svg" />
                </div>
            </div> 
            <div class="author-comment__author-info">
                <div class="author-comment__picture"> 
                    <img src="' . esc_url($src) . '" alt="">
                </div>
                <div class="author-comment__name">
                    <p class="text w-600">' . esc_html($author_firstname) . ' ' . esc_html($author_lastname) . ' </p>
                </div>
                <div class="author-comment__account-type">
                    <h5 class="h5 c-gray">Author</h5>
                </div>
                <ul class="author-comment__social-links"> ';
                if(!empty($author_facebook)) { 
                   $output .= '<li><a href="' . esc_url($author_facebook) . '"><img src="' . esc_url($template_directory_uri) . '/i/icons/social-facebook-red.svg" /></a></li> ';
                }   
                if(!empty($author_instagram)) { 
                   $output .= '<li><a href="' . esc_url($author_instagram) . '"><img src="' . esc_url($template_directory_uri) . '/i/icons/social-instagram-red.svg" /></a></li>';
                }   
                if(!empty($author_linkedin)) { 
                   $output .=  '<li><a href="' . esc_url($author_linkedin) . '"><img src="' . esc_url($template_directory_uri) . '/i/icons/social-linkedin-red.svg" /></a></li>';
                }         
                if(!empty($author_twitter)) { 
                   $output .=  '<li><a href="' . esc_url($author_twitter) . '"><img src="' . esc_url($template_directory_uri) . '/i/icons/social-twitter-red.svg" /></a></li>';
                }    
                if(!empty($author_medium)) { 
                   $output .=  '<li><a href="' . esc_url($author_medium) . '"><img src="' . esc_url($template_directory_uri) . '/i/icons/social-medium-red.svg" /></a></li>';
                }        
                if(!empty($author_pinterest)) { 
                   $output .=  '<li><a href="' . esc_url($author_pinterest) . '"><img src="' . esc_url($template_directory_uri) . '/i/icons/social-pinterest-red.svg" /></a></li>';
                }                   
        $output .= '
                </ul> 
            </div>
        </div>';
    }
 

    return $output;
}
// [author_comment_with_author_info]Hello [/author_comment_with_author_info]
add_shortcode('author_comment_with_author_info', 'author_comment_with_author_info');


// [author_comment_1 author_url="https://www.test.test" author_link="test.test"]Message from Author[/author_comment_1]
function author_comment_1($atts, $content = null) {
       $atts = shortcode_atts(
        array(
            'author_url' => '',
            'author_link' => '',
        ), 
        $atts, 
        'author_comment_1'
    );
        $output = '
        <div class="author-comment-simple">
            <div class="author-comment-simple__icon">
                <img src="' . get_template_directory_uri() . '/i/icons/shortcode-author-question.svg" alt="">
            </div>
            <div class="author-comment-simple__container">
                <div class="author-comment-simple__message author-comment-simple__message--comment-1">
                  ' .  esc_html($content) . '
                </div>
                <a class="author-comment-simple__link" href="' . esc_url($atts["author_url"]) . '">' . esc_url($atts["author_link"]) . '</a>
            </div>
        </div>
        ';
    return $output;
}
// [author_comment_1]Hello [/author_comment_1]
add_shortcode('author_comment_1', 'author_comment_1');



function author_comment_2($atts, $content = null) {
       $atts = shortcode_atts(
        array(
            'author_url' => '',
            'author_link' => '',
        ), 
        $atts, 
        'author_comment_1'
    );
        $output = '
        <div class="author-comment-simple">
            <div class="author-comment-simple__icon">
                <img src="' . get_template_directory_uri() . '/i/icons/shortcode-author-message.svg" alt="">
            </div>
            <div class="author-comment-simple__container">
                <div class="author-comment-simple__message text ">
                  ' .  esc_html($content) . '
                </div>
                <a class="author-comment-simple__link w-600" href="' . esc_url($atts["author_url"]) . '">' . esc_html($atts["author_link"]) . '</a>
            </div>
        </div>
        ';
    return $output;
}
// [author_comment_2 author_url="" author_link=""]Hello [/author_comment_2]
add_shortcode('author_comment_2', 'author_comment_2');



function author_comment_3($atts, $content = null) {
       $atts = shortcode_atts(
        array(
            'author_url' => '',
            'author_link' => '',
        ), 
        $atts, 
        'author_comment_1'
    );
        $output = '
        <div class="author-comment-simple">
            <div class="author-comment-simple__icon">
                <img src="' . get_template_directory_uri() . '/i/icons/shortcode-author-information.svg" alt="">
            </div>
            <div class="author-comment-simple__container">
                <div class="author-comment-simple__message text">
                  ' .  esc_html($content) . '
                </div>
                <a class="author-comment-simple__link w-600" href="' . esc_url($atts["author_url"]) . '">' . esc_html($atts["author_link"]) . '</a>
            </div>
        </div>
        ';
    return $output;
}
// [author_comment_3 author_url="" author_link=""]Hello [/author_comment_3]
add_shortcode('author_comment_3', 'author_comment_3');