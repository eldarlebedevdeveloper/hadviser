<?php
// --------------------Start----------------------------------------
// Functionality of artists metabox for using personally in textarea
// --------------------Start----------------------------------------
add_action('add_meta_boxes', 'add_artists_to_post_metabox_box');
function add_artists_to_post_metabox_box() {
    add_meta_box(
        'metabox-artists-to-post-fields',         
        'Add artists to post fields', 
        'add_artists_to_post_meta_box_html',
        'post',
        'normal',
        'high'
    );   
}


function add_artists_to_post_meta_box_html($post) {
    $value = get_post_meta($post->ID, '_add_artits_to_post_key', true);
    wp_nonce_field('add_artists_to_post_metabox_nonce', 'metabox_nonce');
    echo '<label for="add_artists_to_post_textarea">Add artists shortcodes:</label>';
    echo '<textarea id="add_artists_to_post_textarea" name="add_artists_to_post_textarea" rows="10" cols="50" style="width:100%;">' . esc_textarea($value) . '</textarea>';
}


add_action('save_post', 'add_artists_to_post_save_postdata');
function add_artists_to_post_save_postdata($post_id) {
    if (!isset($_POST['metabox_nonce']) || !wp_verify_nonce($_POST['metabox_nonce'], 'add_artists_to_post_metabox_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    if (isset($_POST['add_artists_to_post_textarea'])) {
        $allowed_tags = array(
            'a' => array( 
                'href' => array(),
                'title' => array()
            ),
            'div' => array(
                'class' => array(),
            ),
             'span' => array(
                'class' => array(),
            ),
        );
        $value = wp_kses($_POST['add_artists_to_post_textarea'], $allowed_tags);
        update_post_meta($post_id, '_add_artits_to_post_key', $value);
    }
}
// [artist link='https://test-link.com' name='Test Artists']
add_shortcode('artist', 'add_atists_to_post_field_shortcode');
function add_atists_to_post_field_shortcode($atts) {
    $atts = shortcode_atts(array(
        'link' => '#',
        'name' => 'Default Name'
    ), $atts, 'myshortcode');

    // return '<a href="' . esc_url($atts['link']) . '">' . esc_html($atts['name']) . '</a>';
    return '<div class="author-trigger__wrapper artist-trigger__wrapper">
                <span class="artist-click-container">
                    <a class="text-underline" href="' . esc_url($atts['link']) . '">' . esc_html($atts['name']) . '</a>
                </span>
            </div>';
}
// --------------------End------------------------------------------
// Functionality of artists metabox for using personally in textarea
// --------------------End------------------------------------------




// --------------------Start---------------------------------------------------------
// Functionality of authors and artists metabox for using with checkboxes and texarea
// --------------------Start--------------------------------------------------------- 
// add_action('add_meta_boxes', 'add_artists_to_article_metabox');
function add_artists_to_article_metabox($post)
{
    add_meta_box(
        'meta-box-add-artists-to-article',
        'Add Atrtists To Article',
        'add_artists_to_article_metabox_callback',
        'post',
        'normal',
        'core'
    );
}

function add_artists_to_article_metabox_callback($post)
{
    wp_nonce_field('my_awesome_nonce', 'awesome_nonce');

    $checkbox_meta_artists_json = get_post_meta($post->ID, 'metabox-artists', true);
    $checkbox_meta_artists_array = json_decode($checkbox_meta_artists_json);

    global $wpdb;
    $category_id = get_cat_ID('Artists');

    if($category_id){
        $posts = $wpdb->get_results( $wpdb->prepare( "
            SELECT p.*
            FROM {$wpdb->posts} p
            INNER JOIN {$wpdb->term_relationships} tr ON (p.ID = tr.object_id)
            WHERE p.post_type = 'post'
            AND p.post_status = 'publish'
            AND tr.term_taxonomy_id = %d
            ORDER BY p.post_date DESC
        ", $category_id ) );
         
        if (!empty($posts)) {
            foreach ( $posts as $post ) {
                $title = $post->post_title;
                $slug = $post->post_name;
                $artist_slug = 'metabox-artist-' . $slug;

                $artists_with_status_yes = array();
                foreach($checkbox_meta_artists_array as $index => $one_artist_metabox){
                    if ($one_artist_metabox->slug === $artist_slug && $one_artist_metabox->status === 'yes') {
                        $artists_with_status_yes[$artist_slug] = 'yes';
                    }
                } 
                ?> 
                <span class="metabox-artist_item"> 
                    <input type="checkbox" 
                        id="<?php echo $artist_slug; ?>" 
                        name="<?php echo $artist_slug; ?>" 
                        value="yes" 
                        <?php if (isset($artists_with_status_yes[$artist_slug])) checked($artists_with_status_yes[$artist_slug], 'yes'); ?> />
                    <?php echo $title ?><br />
                </span>
                <?php
            }
        } else {
            echo 'No posts found in the "hair-stylists" category.';
        }
    } else {
        echo 'Category "hair-stylists" not found.';
    }
}

// add_action('admin_footer', 'add_artists_to_article_metabox_script'); 
function add_artists_to_article_metabox_script(){
    global $current_screen;
    
    if ( 'post' == $current_screen->post_type ) {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                var postbox = $('#meta-box-add-artists-to-article');
                if (postbox.length) {
                    postbox.removeClass('closed').addClass('closed'); 
                }
            });
        </script>
        <?php
    }
}


// add_action('save_post', 'save_entryform_checkboxes');
function save_entryform_checkboxes($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    if ((isset($_POST['my_awesome_nonce'])) && (!wp_verify_nonce($_POST['my_awesome_nonce'], plugin_basename(__FILE__))))
        return;
    if ((isset($_POST['post_type'])) && ('page' == $_POST['post_type'])) {
        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
    } else {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }


    global $wpdb;
    $category_id = get_cat_ID('Artists');
    $categories = wp_get_post_categories($post_id);

    if($category_id){
        $posts = $wpdb->get_results( $wpdb->prepare( "
            SELECT p.*
            FROM {$wpdb->posts} p
            INNER JOIN {$wpdb->term_relationships} tr ON (p.ID = tr.object_id)
            WHERE p.post_type = 'post'
            AND p.post_status = 'publish'
            AND tr.term_taxonomy_id = %d
            ORDER BY p.post_date DESC
        ", $category_id ) );
        
        if (!empty($posts) ) {
            $metabox_artists = array();
            foreach ( $posts as $post ) {
                $id = $post->ID;
                $title = $post->post_title;
                $excerpt = $post->post_excerpt;
                $link = get_permalink($id);
                $thumbnail_url = get_the_post_thumbnail_url($id);
                $slug = $post->post_name;
                $artist_slug = 'metabox-artist-' . $slug;
                $artist_description = get_post_meta($id, 'artist_description', true);

               
                if (isset($_POST[$artist_slug])) {
                    // update_post_meta($post_id, $artist_slug, 'yes');
                    $artist = array('name' => $title, 
                                    'status' => 'yes', 
                                    'link' => $link, 
                                    'slug' => $artist_slug, 
                                    'excerpt' => $excerpt, 
                                    'thumbnail_url' => $thumbnail_url, 
                                    'artist_description' => $artist_description);
                    array_push($metabox_artists, $artist);
                } else {
                    // update_post_meta($post_id, $artist_slug, 'no');
                    $artist = array('name' => $title, 
                                    'status' => 'no', 
                                    'link' => $link, 
                                    'slug' => $artist_slug, 
                                    'excerpt' => $excerpt, 
                                    'thumbnail_url' => $thumbnail_url, 
                                    'artist_description' => $artist_description);
                    array_push($metabox_artists, $artist);
                }
            }

            $metabox_artists_json = json_encode($metabox_artists);
            update_post_meta($post_id, 'metabox-artists', $metabox_artists_json);
        }
    }

}
 



// add_action('save_post', 'uppload_artists_infortamtion_after_changing', 10, 3);
function uppload_artists_infortamtion_after_changing($post_id)
{ 
    $category_id = get_cat_ID('Artists');

    if (!$category_id) {
        return; 
    }

    $categories = wp_get_post_categories($post_id);

    if (in_array($category_id, $categories)) {
        $post = get_post($post_id);
        $artist_link = get_permalink($post);
        $artist_thumbnail_url = get_the_post_thumbnail_url($post);
        $artist_excerpt = $post->post_excerpt;
        $artist_name = $post->post_title;
        $slug = $post->post_name;
        $artist_slug = 'metabox-artist-' . $slug;
        $artist_description = get_post_meta($post_id, 'artist_description', true);
    
    
        $artist_active_meta= array(
            'name' => $artist_name, 
            'status' => 'yes', 
            'link' => $artist_link, 
            'slug' => $artist_slug, 
            'excerpt' => $artist_excerpt, 
            'thumbnail_url' => $artist_thumbnail_url, 
            'artist_description' => $artist_description);

        global $wpdb;
        $category_id = get_cat_ID('Artists');  
        $query = "
            SELECT p.*
            FROM {$wpdb->posts} p
            LEFT JOIN {$wpdb->term_relationships} tr ON (p.ID = tr.object_id)
            LEFT JOIN {$wpdb->term_taxonomy} tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id AND tt.term_id = %d)
            WHERE p.post_type = 'post'
            AND p.post_status = 'publish'
            AND (tt.term_id IS NULL OR tt.term_id != %d)
        ";
        $posts = $wpdb->get_results($wpdb->prepare($query, $category_id, $category_id));

        if ($posts) {
            foreach ($posts as $post) {
                $get_post_metaboxe_artists_json = get_post_meta($post->ID, 'metabox-artists', true);
                $get_post_metabox_artists_array = json_decode($get_post_metaboxe_artists_json);

                foreach($get_post_metabox_artists_array as $index => $one_artist_metabox){
                    if ($one_artist_metabox->name === $artist_name && $one_artist_metabox->status === 'yes') {
                        // print_r($one_artist_metabox);
                        $get_post_metabox_artists_array[$index] = $artist_active_meta;

                    }
                }
                $new_post_metabox_artists_json = json_encode($get_post_metabox_artists_array);
                update_post_meta($post->ID, 'metabox-artists', $new_post_metabox_artists_json);
            }
            

        }
    }
}
// --------------------End-----------------------------------------------------------
// Functionality of authors and artists metabox for using with checkboxes and texarea
// --------------------End----------------------------------------------------------- 
