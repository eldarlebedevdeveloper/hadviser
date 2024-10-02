<?php
function true_upload_img()
{
    if (!did_action('wp_enqueue_media')) {
        wp_enqueue_media();
    }
    wp_enqueue_script('upload_img', get_stylesheet_directory_uri() . '/js/upload_img.js', array('jquery'), null, false);
}
add_action('admin_enqueue_scripts', 'true_upload_img');
add_action('show_user_profile', 'extra_user_profile_fields');
add_action('edit_user_profile', 'extra_user_profile_fields');
function extra_user_profile_fields($user)
{
    $default = get_stylesheet_directory_uri() . '/i/default-image.png';
    if (get_the_author_meta('thumbnail', $user->ID)) {
        $image_attributes = wp_get_attachment_image_src(get_the_author_meta('thumbnail', $user->ID), 'thumb_author');
        $src = $image_attributes[0];
    } else {
        $src = $default;
    }
?>
    <table class="form-table">
        <tr>
            <th><label for="address"><?php _e("Photo Author"); ?></label></th>
            <td class="custom-img-upload">
                <img id="item_thumbnail" data-src="<?php echo $default; ?>" src="<?php echo $src; ?>" width="50px" />
                <input type="hidden" name="thumbnail" id="thumbnail" value="<?php echo get_the_author_meta('thumbnail', $user->ID); ?>" />
                <span class="upload_image_button button">Upload</span>
                <span class="remove_image_button button">&times;</span><br>
            </td>
        </tr>
    </table>
    <h3>Socials links</h3>
    <table class="form-table">
        <tr>
            <th><label for="address"><?php _e("Pinterest"); ?></label></th>
            <td>
                <input type="text" name="pinterest" class="regular-text" value="<?php echo get_the_author_meta('pinterest', $user->ID); ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="address"><?php _e("Facebook"); ?></label></th>
            <td>
                <input type="text" name="fb" class="regular-text" value="<?php echo get_the_author_meta('fb', $user->ID); ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="address"><?php _e("Instagram"); ?></label></th>
            <td>
                <input type="text" name="insta" class="regular-text" value="<?php echo get_the_author_meta('insta', $user->ID); ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="address"><?php _e("Twitter"); ?></label></th>
            <td>
                <input type="text" name="twitter" class="regular-text" value="<?php echo get_the_author_meta('twitter', $user->ID); ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="address"><?php _e("LinkedIn"); ?></label></th>
            <td>
                <input type="text" name="linkedin" class="regular-text" value="<?php echo get_the_author_meta('linkedin', $user->ID); ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="address"><?php _e("Medium"); ?></label></th>
            <td>
                <input type="text" name="medium" class="regular-text" value="<?php echo get_the_author_meta('medium', $user->ID); ?>" />
            </td>
        </tr>
    </table>
<?php
}
add_action('personal_options_update', 'save_extra_user_profile_fields');
add_action('edit_user_profile_update', 'save_extra_user_profile_fields');
function save_extra_user_profile_fields($user_id)
{
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }
    update_user_meta($user_id, 'thumbnail', $_POST['thumbnail']);
    update_user_meta($user_id, 'pinterest', $_POST['pinterest']);
    update_user_meta($user_id, 'fb', $_POST['fb']);
    update_user_meta($user_id, 'insta', $_POST['insta']);
    update_user_meta($user_id, 'twitter', $_POST['twitter']);
    update_user_meta($user_id, 'linkedin', $_POST['linkedin']);
    update_user_meta($user_id, 'medium', $_POST['medium']);
}
function thumbnail_user_profile($user_id)
{
    $thumbnail = wp_get_attachment_image(get_the_author_meta('thumbnail', $user_id), 'thumb_6');
    return $thumbnail;
}
