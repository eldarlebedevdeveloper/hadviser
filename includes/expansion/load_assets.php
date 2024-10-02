<?php
// Підключення стилів та скриптів для 
function load_all_types_assets()
{
    // // Libraries
    // wp_enqueue_style('library_swipper_style', get_template_directory_uri() . '/assets/libs/swiper-bundle.min.css', array(), '11', 'all');
    // wp_register_script('library_swipper_script',
    //                     get_template_directory_uri() . '/assets/libs/swiper-bundle.min.js', 
    //                     array(), NULL, true); 
    // wp_enqueue_script('library_swipper_script');

     
    // wp_register_style( 'library_swipper_style', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css' );
    // wp_enqueue_style('library_swipper_style');
    // wp_register_script( 'library_swipper_script', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', null, null, true );
    // wp_enqueue_script('library_swipper_script');

    // Main  
    wp_enqueue_style('main', get_template_directory_uri() . '/assets/scss/main.scss', array(), '1.1', 'all');

    // Metaboxes  
    wp_enqueue_style('metaboxes', get_template_directory_uri() . '/assets/scss/metaboxes.scss', array(), '1.1', 'all');
    wp_enqueue_script('metabox-author_of_post_wiSth_popup_script', get_template_directory_uri() . '/assets/js/metabox-author_of_post_with_popup.js', false, 1.1, true);

    // Templates
    wp_enqueue_style('templates_old_design_style', get_template_directory_uri() . '/assets/scss/templates-old-design.scss', array(), '1.1', 'all');
    wp_enqueue_style('templates_style', get_template_directory_uri() . '/assets/scss/templates.scss', array(), '1.1', 'all');
    wp_enqueue_script('templates_script', get_template_directory_uri() . '/assets/js/templates.js', array(), '1.1', 'all');

    // Template parts
    wp_enqueue_style('template_parts_style', get_template_directory_uri() . '/assets/scss/template-parts.scss', array(), '1.1', 'all');
    wp_enqueue_style('template_parts_old_design_style', get_template_directory_uri() . '/assets/scss/template-parts-old-design.scss', array(), '1.1', 'all');

    // Shortcodes
    wp_enqueue_style('shortcodes_style', get_template_directory_uri() . '/assets/scss/shortcodes.scss', array(), '1.1', 'all');



}
add_action('wp_enqueue_scripts', 'load_all_types_assets');