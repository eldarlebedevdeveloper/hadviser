<?php
add_filter('rest_enabled', '__return_false');
remove_action('xmlrpc_rsd_apis',            'rest_output_rsd');
remove_action('wp_head',                    'rest_output_link_wp_head', 10, 0);
remove_action('template_redirect',          'rest_output_link_header', 11, 0);
remove_action('auth_cookie_malformed',      'rest_cookie_collect_status');
remove_action('auth_cookie_expired',        'rest_cookie_collect_status');
remove_action('auth_cookie_bad_username',   'rest_cookie_collect_status');
remove_action('auth_cookie_bad_hash',       'rest_cookie_collect_status');
remove_action('auth_cookie_valid',          'rest_cookie_collect_status');
remove_filter('rest_authentication_errors', 'rest_cookie_check_errors', 100);
//протестировал на сайте сдоставкой форму (cf7 ver 4.6 и выше) работает и мусор убирается
// remove_action( 'init',          'rest_api_init' );
// remove_action( 'rest_api_init', 'rest_api_default_filters', 10, 1 );
// remove_action( 'parse_request', 'rest_api_loaded' );
remove_action('rest_api_init',          'wp_oembed_register_route');
remove_filter('rest_pre_serve_request', '_oembed_rest_pre_serve_request', 10, 4);
remove_action('wp_head', 'wp_oembed_add_discovery_links');


remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action('wp_head', 'wp_resource_hints', 2);

remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('template_redirect', 'wp_shortlink_header', 11);


remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');

//новое проверить 
// Уберем ссылки на rss категории:
remove_action('wp_head', 'feed_links_extra', 3);
// Уберем ссылки на основной rss, а также rss комментариев:
remove_action('wp_head', 'feed_links', 2);
// Удаляем link rel=EditURI, сервис Really Simple Discovery:
remove_action('wp_head', 'rsd_link');
// Удалим различные ссылки при отображении постов: следующий, предыдущий...
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function my_remove_x_pingback($headers)
{
	unset($headers['X-Pingback']);
	return $headers;
}
add_filter('wp_headers', 'my_remove_x_pingback');
add_filter('wpseo_next_rel_link', '__return_false');
add_filter('wpseo_prev_rel_link', '__return_false');
add_filter('term_description', 'shortcode_unautop');
add_filter('term_description', 'do_shortcode');
function removeTitle($str)
{
	$str = preg_replace('#title="[^"]+"#', '', $str);
	return $str;
}
add_filter("wp_list_categories", "removeTitle");
function enable_more_buttons($buttons)
{
	$buttons[] = 'fontselect';
	$buttons[] = 'fontsizeselect';
	$buttons[] = 'sub';
	$buttons[] = 'justifyfull';
	$buttons[] = 'cut';
	$buttons[] = 'copy';
	$buttons[] = 'paste';
	$buttons[] = 'backcolor';
	return $buttons;
}
add_filter("mce_buttons_2", "enable_more_buttons");
function wpshock_search_filter($query)
{
	if ($query->is_search) {
		$query->set('post_type', array('post'));
	}
	return $query;
}
add_filter('pre_get_posts', 'wpshock_search_filter');
register_sidebar(array(
	'name' => __('Sidebar'),
	'id' => 'sidebar',
	'description' => ('widgets'),
	'before_widget' => '<div id="%1$s" class="widget-box %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<div class="title-section_style">',
	'after_title' => '</div>',
));
register_sidebar(array(
	'name' => __('Sidebar (home)'),
	'id' => 'sidebar_home',
	'description' => ('widgets'),
	'before_widget' => '<div id="%1$s" class="widget-home_side %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<div class="title-section_style">',
	'after_title' => '</div>',
));
if (function_exists('add_theme_support')) {
	add_theme_support('post-thumbnails');
}
if (function_exists('add_image_size')) {
	add_image_size('thumb_1', 330, 270, true);
	add_image_size('thumb_3', 80, 53, true);
	add_image_size('thumb_5', 200, 130, true);
	add_image_size('thumb_6', 60, 60, true);
}
if (function_exists('add_theme_support')) {
	add_theme_support('menus');
}
if (function_exists('register_nav_menus')) {
	register_nav_menus(
		array(
			'topmenu' => 'Top menu',
			'footerbig' => 'Footer menu'
		)
	);
}
require_once('includes/custom_function.php');
require_once('includes/settings.php');
require_once('includes/wid.php');
require_once('includes/tpl_category.php');
require_once('includes/user_fields.php');
require_once('includes/expansion/load_assets.php');
// require_once('includes/expansion/metabox-author_of_post_with_popup.php');
require_once('includes/expansion/metabox-author_of_post_functionality.php');
require_once('includes/expansion/metabox-author_of_post_layouts.php');
require_once('includes/expansion/shortcodes-author_comment.php');
require_once('includes/expansion/settings-different.php');


add_filter('wpcf7_load_js', '__return_false');
add_filter('wpcf7_load_css', '__return_false');

add_action('wp_enqueue_scripts', 'load_wpcf7_scripts');
function load_wpcf7_scripts()
{
	if (is_page('contact-us') || is_category('ask-hair-expert')) {
		if (function_exists('wpcf7_enqueue_scripts')) {
			wpcf7_enqueue_scripts();
		}
	}
}



function wpb_exclude_from_everywhere($query)
{
	if ($query->is_home() || $query->is_feed() ||  $query->is_search() || $query->is_archive()) {
		$query->set('post__not_in', array(18722));
	}
}
add_action('pre_get_posts', 'wpb_exclude_from_everywhere');



// альтернативний tps для статей з десктопним блоком над верхніми кнопками навігації    +18722 (test page)
function remove_tps_js()
{
	if (is_single(array(53, 1910, 3043, 2291, 3486, 951, 2679, 2789, 3884, 372, 2545, 3102, 550, 3161, 2455, 2093, 3698, 2608, 1847, 4134, 2010, 4485, 3828, 4858, 3231, 5480, 5726, 2171, 4247, 1785, 4543, 2080, 3218, 4735, 7157, 4427, 4011, 1467, 4368, 4800, 3953, 3418, 2926, 2983, 5417, 6857, 4191, 3578, 7005, 4618, 7626, 3294, 7479, 7729, 8172, 7993, 7919, 8274, 6117, 8319, 7412, 4984, 5283, 8234, 5348, 7536, 7663, 5166, 7339, 7282, 9292, 8730, 477, 8828, 7116, 9362, 8967, 8547, 8479, 8904, 6459, 6367, 9201, 9142,  10060, 8613, 9818, 9591, 10020, 2348, 10434, 10381, 9358, 10571, 9493, 11067, 10875, 4071, 10683, 4678, 2868, 9668, 11195, 10183, 10126, 10522, 5225, 4920, 5053, 7801, 3756, 9909, 11760, 10249, 10646, 9713, 10815, 9551, 5666, 9773, 9948, 10773, 9054, 10927, 10297, 15773, 14258, 16188, 17072, 15718, 16093, 17188, 16388, 15918, 17726, 11145, 17361, 16133, 16329, 15317, 18722, 17673, 17917, 18383, 18622, 19489, 17794, 10994, 14871, 17320, 14716, 19450, 17455, 18433, 10973, 15533, 17953, 19232, 19616, 20434, 16654, 20498, 16612, 20374, 19850, 18219, 21722, 21892, 21258, 23662, 22723, 18682, 22324, 17626, 23094, 23365, 22917, 23586, 25150, 23532, 23879, 22043, 18302, 23918, 24167, 16822, 25287, 22436, 23431, 17401, 22395, 24560, 23703, 22795, 21846, 20858, 20669, 24680, 27800, 23625, 11236, 26441, 20797, 24604, 25346, 24738, 24293, 27144, 25927, 24038, 24789, 25786, 18822))) {
		wp_deregister_script('theiaPostSlider/theiaPostSlider.js');
		wp_register_script('theiaPostSlider/theiaPostSlider.js', content_url() . "/themes/hairadviser/js/tps-v.3.5.js", array('jquery'), null, false);
		wp_enqueue_script('theiaPostSlider/theiaPostSlider.js');
	}
};
add_action('wp_enqueue_scripts', 'remove_tps_js');


// свіжа версія jquery на початку сторінки (на старій все працювало з багами)
function modify_jquery_version()
{
	if (!is_admin()) {
		wp_deregister_script('jquery');
		wp_register_script(
			'jquery',
			'https://www.hadviser.com/wp-content/themes/hairadviser/js/jquery.min.js',
			false,
			false
		);
		wp_enqueue_script('jquery');
	}
}
add_action('init', 'modify_jquery_version');



// завантаження контент візібіліті одразу після jquery, щоб раніше було згортання слайдера
function my_scripts_cv()
{
	if (is_single(array(53, 1910, 3043, 2291, 3486, 951, 2679, 2789, 3884, 372, 2545, 3102, 550, 3161, 2455, 2093, 3698, 2608, 1847, 4134, 2010, 4485, 3828, 4858, 3231, 5480, 5726, 2171, 4247, 1785, 4543, 2080, 3218, 4735, 7157, 4427, 4011, 1467, 4368, 4800, 3953, 3418, 2926, 2983, 5417, 6857, 4191, 3578, 7005, 4618, 7626, 3294, 7479, 7729, 8172, 7993, 7919, 8274, 6117, 8319, 7412, 4984, 5283, 8234, 5348, 7536, 7663, 5166, 7339, 7282, 9292, 8730, 477, 8828, 7116, 9362, 8967, 8547, 8479, 8904, 6459, 6367, 9201, 9142,  10060, 8613, 9818, 9591, 10020, 2348, 10434, 10381, 9358, 10571, 9493, 11067, 10875, 4071, 10683, 4678, 2868, 9668, 11195, 10183, 10126, 10522, 5225, 4920, 5053, 7801, 3756, 9909, 11760, 10249, 10646, 9713, 10815, 9551, 5666, 9773, 9948, 10773, 9054, 10927, 10297, 15773, 14258, 16188, 17072, 15718, 16093, 17188, 16388, 15918, 17726, 11145, 17361, 16133, 16329, 15317, 18722, 17673, 17917, 18383, 18622, 19489, 17794, 10994, 14871, 17320, 14716, 19450, 17455, 18433, 10973, 15533, 17953, 19232, 19616, 20434, 16654, 20498, 16612, 20374, 19850, 18219, 21722, 21892, 21258, 23662, 22723, 18682, 22324, 17626, 23094, 23365, 22917, 23586, 25150, 23532, 23879, 22043, 18302, 23918, 24167, 16822, 25287, 22436, 23431, 17401, 22395, 24560, 23703, 22795, 21846, 20858, 20669, 24680, 27800, 23625, 11236, 26441, 20797, 24604, 25346, 24738, 24293, 27144, 25927, 24038, 24789, 25786, 18822))) {
		wp_register_script('content-visibility', content_url() . '/themes/hairadviser/js/handle-content-visibility-and-size-v1.4.js', array('jquery'), null, false);
		wp_enqueue_script('content-visibility');
	}
};
add_action('wp_enqueue_scripts', 'my_scripts_cv', 1);







/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// малий рекламний блок перед слайдером
function ads_slider_top_ad_div()
{
	if (is_single(array(53, 1910, 3043, 2291, 3486, 951, 2789, 3884, 2545, 3102, 550, 3161, 2455, 2093, 3698, 2608, 1847, 4134, 2010, 4485, 3828, 4858, 3231, 5480, 5726, 2171, 4247, 1785, 4543, 2080, 3218, 4735, 7157, 4427, 4011, 1467, 4368, 4800, 3953, 3418, 2926, 2983, 5417, 6857, 4191, 3578, 7005, 4618, 7626, 3294, 7479, 7729, 8172, 7993, 7919, 8274, 6117, 8319, 7412, 4984, 5283, 8234, 7536, 7663, 5166, 7339, 7282, 9292, 8730, 477, 8828, 7116, 9362, 8967, 8547, 8479, 8904, 6459, 6367, 9201, 9142,  10060, 8613, 9818, 9591, 10020, 2348, 10434, 10381, 9358, 10571, 9493, 11067, 10875, 4071, 10683, 4678, 2868, 9668, 11195, 10183, 10126, 10522, 5225, 4920, 5053, 7801, 3756, 9909, 11760, 10249, 10646, 9713, 10815, 9551, 5666, 9773, 9948, 10773, 9054, 10927, 10297, 15773, 14258, 16188, 17072, 15718, 16093, 17188, 16388, 15918, 17726, 11145, 17361, 16133, 16329, 15317, 17673, 17917, 18383, 18622, 19489, 17794, 10994, 14871, 17320, 14716, 19450, 17455, 18433, 10973, 15533, 17953, 19232, 19616, 20434, 16654, 20498, 16612, 20374, 19850, 18219, 21722, 21892, 21258, 23662, 22723, 18682, 22324, 17626, 23094, 23365, 22917, 23586, 2679, 372, 5348, 25150, 23532, 23879, 22043, 18302, 23918, 24167, 16822, 25287, 22436, 23431, 17401, 22395, 24560, 23703, 22795, 21846, 20858, 20669, 24680, 27800, 23625, 11236, 26441, 20797, 24604, 25346, 24738, 24293, 27144, 25927, 24038, 24789, 25786, 18822))) {
?>
		<!-- Tag ID: hadvisecom_slider_pages_1_new -->
		<div class='ad' style='margin-bottom:40px; margin-top:0px;' align='center' data-freestar-ad='__320x100 __728x90' id='hadvisecom_slider_pages_1_new'>
			<script data-cfasync='false' type='text/javascript'>
				freestar.config.enabled_slots.push({
					placementName: 'hadvisecom_slider_pages_1_new',
					slotId: 'hadvisecom_slider_pages_1_new'
				});
			</script>
		</div>
		<?php
	}
}
add_action('top_adv_hook', 'ads_slider_top_ad_div');



/*
// повноцінний блок лише на першому слайді і лише перед назвою першої картинки
function insert_ad_block($content) {
    if (is_single(array(53, 1910, 3043, 2291, 3486, 951, 2789, 3884, 2545, 3102, 550, 3161, 2455, 2093, 3698, 2608, 1847, 4134, 2010, 4485, 3828, 4858, 3231, 5480, 5726, 2171, 4247, 1785, 4543, 2080, 3218, 4735, 7157, 4427, 4011, 1467, 4368, 4800, 3953, 3418, 2926, 2983, 5417, 6857, 4191, 3578, 7005, 4618, 7626, 3294, 7479, 7729, 8172, 7993, 7919, 8274, 6117, 8319, 7412, 4984, 5283, 8234, 7536, 7663, 5166, 7339, 7282, 9292, 8730, 477, 8828, 7116, 9362, 8967, 8547, 8479, 8904, 6459, 6367, 9201, 9142,  10060, 8613, 9818, 9591, 10020, 2348, 10434, 10381, 9358, 10571, 9493, 11067, 10875, 4071, 10683, 4678, 2868, 9668, 11195, 10183, 10126, 10522, 5225, 4920, 5053, 7801, 3756, 9909, 11760, 10249, 10646, 9713, 10815, 9551, 5666, 9773, 9948, 10773, 9054, 10927, 10297, 15773, 14258, 16188, 17072, 15718, 16093, 17188, 16388, 15918, 17726, 11145, 17361, 16133, 16329, 15317, 17673, 17917, 18383, 18622, 19489, 17794, 10994, 14871, 17320, 14716, 19450, 17455, 18433, 10973, 15533, 17953, 19232, 19616, 20434, 16654, 20498, 16612, 20374, 19850, 18219, 21722, 21892, 21258, 23662, 22723, 18682, 22324, 17626, 23094, 23365, 22917, 23586, 2679, 372, 5348, 25150, 23532, 23879, 22043, 18302, 23918, 24167, 16822, 25287, 22436, 23431, 17401, 22395, 24560, 23703, 22795, 21846, 20858, 20669, 24680, 27800, 23625, 11236, 26441, 18722))) {
        $page = get_query_var('page');
        if ($page < 2) {
        $ad_block = '
<div id="hadvisecom_slider_pages_1" style="margin-bottom:30px; margin-top: 30px">
<div align="center" data-freestar-ad="__336x280 __728x90" id="hadvisecom_slider_pages_1_1">
<script data-cfasync="false" type="text/javascript">
freestar.config.enabled_slots.push({ placementName: "hadvisecom_slider_pages_1", slotId: "hadvisecom_slider_pages_1_1" });
</script>
</div></div>';

        $paragraphs = explode("</p>", $content);

        for ($i = 0; $i < count($paragraphs); $i++) {
            if (preg_match('/<p.*<strong>\d+\./', $paragraphs[$i])) {
                array_splice($paragraphs, $i, 0, $ad_block);
                break;
            }
        }

        $content = implode("</p>", $paragraphs);
        return $content;
    }
}
    return $content;
}
add_filter('the_content', 'insert_ad_block');
*/


// скрипт для динамічної підгрузки реклами на другий слайд
/*
function ads_loader_1st_slide() {
	if (is_single(array(53, 1910, 3043, 2291, 3486, 951, 2789, 3884, 2545, 3102, 550, 3161, 2455, 2093, 3698, 2608, 1847, 4134, 2010, 4485, 3828, 4858, 3231, 5480, 5726, 2171, 4247, 1785, 4543, 2080, 3218, 4735, 7157, 4427, 4011, 1467, 4368, 4800, 3953, 3418, 2926, 2983, 5417, 6857, 4191, 3578, 7005, 4618, 7626, 3294, 7479, 7729, 8172, 7993, 7919, 8274, 6117, 8319, 7412, 4984, 5283, 8234, 7536, 7663, 5166, 7339, 7282, 9292, 8730, 477, 8828, 7116, 9362, 8967, 8547, 8479, 8904, 6459, 6367, 9201, 9142,  10060, 8613, 9818, 9591, 10020, 2348, 10434, 10381, 9358, 10571, 9493, 11067, 10875, 4071, 10683, 4678, 2868, 9668, 11195, 10183, 10126, 10522, 5225, 4920, 5053, 7801, 3756, 9909, 11760, 10249, 10646, 9713, 10815, 9551, 5666, 9773, 9948, 10773, 9054, 10927, 10297, 15773, 14258, 16188, 17072, 15718, 16093, 17188, 16388, 15918, 17726, 11145, 17361, 16133, 16329, 15317, 17673, 17917, 18383, 18622, 19489, 17794, 10994, 14871, 17320, 14716, 19450, 17455, 18433, 10973, 15533, 17953, 19232, 19616, 20434, 16654, 20498, 16612, 20374, 19850, 18219, 21722, 21892, 21258, 23662, 22723, 18682, 22324, 17626, 23094, 23365, 22917, 23586, 2679, 372, 5348, 25150, 23532, 23879, 22043, 18302, 23918, 24167, 16822, 25287, 22436, 23431, 17401, 22395, 24560, 23703, 22795, 21846, 20858, 20669, 24680, 27800, 23625, 11236, 26441, 18722))) {
        $page = get_query_var('page');
        if ($page < 2) {
?>
<script type="text/javascript" defer="defer" src="https://www.hadviser.com/wp-content/themes/hairadviser/ads-visibility-v4.0.js"></script>
<?php 
	}
  }
};
add_action('wp_head','ads_loader_1st_slide', 12 );
*/
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



// малий блок на тестовій сторінці
function ads_slider_top_div_test()
{
	if (is_single(array(18722))) {
		$page = get_query_var('page');
		if ($page >= 2) {
		?>
			<!-- Tag ID: hadvisecom_slider_pages_1_new -->
			<div class='ad' style='margin-bottom:40px; margin-top:0px;' align='center' data-freestar-ad='__320x100 __728x90' id='hadvisecom_slider_pages_1_new'>
				<script data-cfasync='false' type='text/javascript'>
					freestar.config.enabled_slots.push({
						placementName: 'hadvisecom_slider_pages_1_new',
						slotId: 'hadvisecom_slider_pages_1_new'
					});
				</script>
			</div>
		<?php
		} else {
		?>
			<!-- Tag ID: hadvisecom_slider_pages_1_new -->
			<div class='ad' style='margin-bottom:40px; margin-top:0px;' align='center' data-freestar-ad='__320x100 __728x90' id='hadvisecom_slider_pages_1_new'>
				<script data-cfasync='false' type='text/javascript'>
					freestar.config.enabled_slots.push({
						placementName: 'hadvisecom_slider_pages_1_new',
						slotId: 'hadvisecom_slider_pages_1_new'
					});
				</script>
			</div>
		<?php
		}
	}
}
add_action('top_adv_hook', 'ads_slider_top_div_test');



// нижній фіксований блок над нижніми кнопками слайдеру на тестовій сторінці
function ads_slider_bottom_befor_nav_test($html, $content)
{
	if (is_single(array(18722))) {
		$html .= "<!-- Tag ID: hadvisecom_slider_pages_2 -->
<div class='ad' style='margin-bottom:40px; margin-top:20px;' align='center' data-freestar-ad='__336x280 __728x90' id='hadvisecom_slider_pages_2'>
  <script data-cfasync='false' type='text/javascript'>
    freestar.config.enabled_slots.push({ placementName: 'hadvisecom_slider_pages_2', slotId: 'hadvisecom_slider_pages_2' });
  </script>
</div>";
		return $html;
	} else {
		return $html;
	}
}
add_filter('tps_the_content_after_current_slide', 'ads_slider_bottom_befor_nav_test', 10, 2);



// нижній фіксований мобільний та десктопний блок над нижніми кнопками слайдеру    -18722 (test page), +2679 (test page 2), +372
function ads_slider_mobile_bottom_befor_nav($html, $content)
{
	if (is_single(array(53, 1910, 3043, 2291, 3486, 951, 2789, 3884, 2545, 3102, 550, 3161, 2455, 2093, 3698, 2608, 1847, 4134, 2010, 4485, 3828, 4858, 3231, 5480, 5726, 2171, 4247, 1785, 4543, 2080, 3218, 4735, 7157, 4427, 4011, 1467, 4368, 4800, 3953, 3418, 2926, 2983, 5417, 6857, 4191, 3578, 7005, 4618, 7626, 3294, 7479, 7729, 8172, 7993, 7919, 8274, 6117, 8319, 7412, 4984, 5283, 8234, 7536, 7663, 5166, 7339, 7282, 9292, 8730, 477, 8828, 7116, 9362, 8967, 8547, 8479, 8904, 6459, 6367, 9201, 9142,  10060, 8613, 9818, 9591, 10020, 2348, 10434, 10381, 9358, 10571, 9493, 11067, 10875, 4071, 10683, 4678, 2868, 9668, 11195, 10183, 10126, 10522, 5225, 4920, 5053, 7801, 3756, 9909, 11760, 10249, 10646, 9713, 10815, 9551, 5666, 9773, 9948, 10773, 9054, 10927, 10297, 15773, 14258, 16188, 17072, 15718, 16093, 17188, 16388, 15918, 17726, 11145, 17361, 16133, 16329, 15317, 17673, 17917, 18383, 18622, 19489, 17794, 10994, 14871, 17320, 14716, 19450, 17455, 18433, 10973, 15533, 17953, 19232, 19616, 20434, 16654, 20498, 16612, 20374, 19850, 18219, 21722, 21892, 21258, 23662, 22723, 18682, 22324, 17626, 23094, 23365, 22917, 23586, 2679, 372, 5348, 25150, 23532, 23879, 22043, 18302, 23918, 24167, 16822, 25287, 22436, 23431, 17401, 22395, 24560, 23703, 22795, 21846, 20858, 20669, 24680, 27800, 23625, 11236, 26441, 20797, 24604, 25346, 24738, 24293, 27144, 25927, 24038, 24789, 25786, 18822))) {
		$html .= "<!-- Tag ID: hadvisecom_slider_pages_2 -->
<div class='ad' style='margin-bottom:40px; margin-top:20px;' align='center' data-freestar-ad='__336x280 __728x90' id='hadvisecom_slider_pages_2'>
  <script data-cfasync='false' type='text/javascript'>
    freestar.config.enabled_slots.push({ placementName: 'hadvisecom_slider_pages_2', slotId: 'hadvisecom_slider_pages_2' });
  </script>
</div>";
		return $html;
	} else {
		return $html;
	}
}
add_filter('tps_the_content_after_current_slide', 'ads_slider_mobile_bottom_befor_nav', 10, 2);



/*
// +18722 (test page)
function tps_lazyad_loader() {
    if (is_single(array(53, 1910, 3043, 2291, 3486, 951, 2789, 3884, 2545, 3102, 550, 3161, 2455, 2093, 3698, 2608, 1847, 4134, 2010, 4485, 3828, 4858, 3231, 5480, 5726, 2171, 4247, 1785, 4543, 2080, 3218, 4735, 7157, 4427, 4011, 1467, 4368, 4800, 3953, 3418, 2926, 2983, 5417, 6857, 4191, 3578, 7005, 4618, 7626, 3294, 7479, 7729, 8172, 7993, 7919, 8274, 6117, 8319, 7412, 4984, 5283, 8234, 7536, 7663, 5166, 7339, 7282, 9292, 8730, 477, 8828, 7116, 9362, 8967, 8547, 8479, 8904, 6459, 6367, 9201, 9142,  10060, 8613, 9818, 9591, 10020, 2348, 10434, 10381, 9358, 10571, 9493, 11067, 10875, 4071, 10683, 4678, 2868, 9668, 11195, 10183, 10126, 10522, 5225, 4920, 5053, 7801, 3756, 9909, 11760, 10249, 10646, 9713, 10815, 9551, 5666, 9773, 9948, 10773, 9054, 10927, 10297, 15773, 14258, 16188, 17072, 15718, 16093, 17188, 16388, 15918, 17726, 11145, 17361, 16133, 16329, 15317, 17673, 17917, 18383, 18622, 19489, 17794, 10994, 14871, 17320, 14716, 19450, 17455, 18433, 10973, 15533, 17953, 19232, 19616, 20434, 16654, 20498, 16612, 20374, 19850, 18219, 21722, 21892, 21258, 23662, 22723, 18682, 22324, 17626, 23094, 23365, 22917, 23586, 2679, 372, 5348, 25150, 23532, 23879, 22043, 18302, 23918, 24167, 16822, 18722))) {
  ?>
<script type="text/javascript" defer="defer" src="https://www.hadviser.com/wp-content/themes/hairadviser/js/lazyad-loader-v1.min.js"></script>
<?php 
  }
};
add_action('wp_head', 'tps_lazyad_loader', 8, 2 );
*/


/*
// +18722 (test page) Vidverto Player after slider або Primis відео плеєр
function vidverto_player() {
    if (is_single(array(53, 1910, 3043, 2291, 3486, 951, 2789, 3884, 2545, 3102, 550, 3161, 2455, 2093, 3698, 2608, 1847, 4134, 2010, 4485, 3828, 4858, 3231, 5480, 5726, 2171, 4247, 1785, 4543, 2080, 3218, 4735, 7157, 4427, 4011, 1467, 4368, 4800, 3953, 3418, 2926, 2983, 5417, 6857, 4191, 3578, 7005, 4618, 7626, 3294, 7479, 7729, 8172, 7993, 7919, 8274, 6117, 8319, 7412, 4984, 5283, 8234, 7536, 7663, 5166, 7339, 7282, 9292, 8730, 477, 8828, 7116, 9362, 8967, 8547, 8479, 8904, 6459, 6367, 9201, 9142,  10060, 8613, 9818, 9591, 10020, 2348, 10434, 10381, 9358, 10571, 9493, 11067, 10875, 4071, 10683, 4678, 2868, 9668, 11195, 10183, 10126, 10522, 5225, 4920, 5053, 7801, 3756, 9909, 11760, 10249, 10646, 9713, 10815, 9551, 5666, 9773, 9948, 10773, 9054, 10927, 10297, 15773, 14258, 16188, 17072, 15718, 16093, 17188, 16388, 15918, 17726, 11145, 17361, 16133, 16329, 15317, 17673, 17917, 18383, 18622, 19489, 17794, 10994, 14871, 17320, 14716, 19450, 17455, 18433, 10973, 15533, 17953, 19232, 19616, 20434, 16654, 20498, 16612, 20374, 19850, 18219, 21722, 21892, 21258, 23662, 22723, 18682, 22324, 17626, 23094, 23365, 22917, 23586, 2679, 372, 5348, 25150, 23532, 23879, 22043, 18302, 23918, 24167, 16822, 25287, 22436, 23431, 17401, 22395, 24560, 23703, 22795, 21846, 20858, 20669, 24680, 27800, 23625, 11236, 26441))) {
?>
<div id="FreeStarVideoAdContainer" style="margin-top:50px; margin-bottom:40px;">
<div id="freestar-video-parent">
<div id="freestar-video-child"></div>
</div></div>
<?php 
  }
else if(is_single(array(18722))) {
?>
<div id="FreeStarVideoAdContainer" style="margin-top:50px; margin-bottom:40px;">
<div id="freestar-video-parent">
<div id="freestar-video-child"></div>
</div></div>
<?php 
}
};



// +18722 (test page) Freestar Player на мобільних перед початком статті
function vidverto_player() {
    if (is_single(array(53, 1910, 3043, 2291, 3486, 951, 2789, 3884, 2545, 3102, 550, 3161, 2455, 2093, 3698, 2608, 1847, 4134, 2010, 4485, 3828, 4858, 3231, 5480, 5726, 2171, 4247, 1785, 4543, 2080, 3218, 4735, 7157, 4427, 4011, 1467, 4368, 4800, 3953, 3418, 2926, 2983, 5417, 6857, 4191, 3578, 7005, 4618, 7626, 3294, 7479, 7729, 8172, 7993, 7919, 8274, 6117, 8319, 7412, 4984, 5283, 8234, 7536, 7663, 5166, 7339, 7282, 9292, 8730, 477, 8828, 7116, 9362, 8967, 8547, 8479, 8904, 6459, 6367, 9201, 9142,  10060, 8613, 9818, 9591, 10020, 2348, 10434, 10381, 9358, 10571, 9493, 11067, 10875, 4071, 10683, 4678, 2868, 9668, 11195, 10183, 10126, 10522, 5225, 4920, 5053, 7801, 3756, 9909, 11760, 10249, 10646, 9713, 10815, 9551, 5666, 9773, 9948, 10773, 9054, 10927, 10297, 15773, 14258, 16188, 17072, 15718, 16093, 17188, 16388, 15918, 17726, 11145, 17361, 16133, 16329, 15317, 17673, 17917, 18383, 18622, 19489, 17794, 10994, 14871, 17320, 14716, 19450, 17455, 18433, 10973, 15533, 17953, 19232, 19616, 20434, 16654, 20498, 16612, 20374, 19850, 18219, 21722, 21892, 21258, 23662, 22723, 18682, 22324, 17626, 23094, 23365, 22917, 23586, 2679, 372, 5348, 25150, 23532, 23879, 22043, 18302, 23918, 24167, 16822, 25287, 22436, 23431, 17401, 22395, 24560, 23703, 22795, 21846, 20858, 20669, 24680, 27800, 23625, 11236, 26441))) {
?>
<div id="FreeStarVideoAdContainer" style="margin-bottom: 30px;display: flex;align-items: center;justify-content: center;height: 225px;background-color: #efefef;">
<div id="freestar-video-parent" style="display: inline-block;width: 400px;">
<div id="freestar-video-child"></div>
</div></div>

<?php 
  }
else if(is_single(array(18722))) {
?>
<div></div>

<?php 
}
};



// mgid test (outbrain)
function mgid_test() {
    if (is_single(array(53, 1910, 3043, 2291, 3486, 951, 2789, 3884, 2545, 3102, 550, 3161, 2455, 2093, 3698, 2608, 1847, 4134, 2010, 4485, 3828, 4858, 3231, 5480, 5726, 2171, 4247, 1785, 4543, 2080, 3218, 4735, 7157, 4427, 4011, 1467, 4368, 4800, 3953, 3418, 2926, 2983, 5417, 6857, 4191, 3578, 7005, 4618, 7626, 3294, 7479, 7729, 8172, 7993, 7919, 8274, 6117, 8319, 7412, 4984, 5283, 8234, 7536, 7663, 5166, 7339, 7282, 9292, 8730, 477, 8828, 7116, 9362, 8967, 8547, 8479, 8904, 6459, 6367, 9201, 9142,  10060, 8613, 9818, 9591, 10020, 2348, 10434, 10381, 9358, 10571, 9493, 11067, 10875, 4071, 10683, 4678, 2868, 9668, 11195, 10183, 10126, 10522, 5225, 4920, 5053, 7801, 3756, 9909, 11760, 10249, 10646, 9713, 10815, 9551, 5666, 9773, 9948, 10773, 9054, 10927, 10297, 15773, 14258, 16188, 17072, 15718, 16093, 17188, 16388, 15918, 17726, 11145, 17361, 16133, 16329, 15317, 17673, 17917, 18383, 18622, 19489, 17794, 10994, 14871, 17320, 14716, 19450, 17455, 18433, 10973, 15533, 17953, 19232, 19616, 20434, 16654, 20498, 16612, 20374, 19850, 18219, 21722, 21892, 21258, 23662, 22723, 18682, 22324, 17626, 23094, 23365, 22917, 23586, 2679, 372, 5348, 25150, 23532, 23879, 22043, 18302, 23918, 24167, 16822, 25287, 22436, 23431, 17401, 22395, 24560, 23703, 22795, 21846, 20858, 20669, 24680, 27800, 23625, 11236, 26441, 20797, 24604, 25346, 24738, 24293, 27144, 25927, 24038, 24789, 25786, 18822))) {
?>
<div class="OUTBRAIN" data-widget-id="AR_1" style="margin-top: 20px; margin-bottom: 20px;"></div>
<script type="text/javascript" async="async" src="//widgets.outbrain.com/outbrain.js"></script>
<?php 
  }
else if(is_single(array(18722))) {
?>
<div class="OUTBRAIN" data-widget-id="AR_1" style="margin-top: 20px; margin-bottom: 20px;"></div>
<script type="text/javascript" async="async" src="//widgets.outbrain.com/outbrain.js"></script>
<?php 
} else if(is_single()) {
?>
<div class="OUTBRAIN" data-widget-id="AR_1" style="margin-top: 20px; margin-bottom: 20px;"></div>
<script type="text/javascript" async="async" src="//widgets.outbrain.com/outbrain.js"></script>
<?php 
}
};
*/


// mgid test (outbrain)
function mgid_test()
{
	if (is_single(array(18722))) {
		?>
		<div class="OUTBRAIN" data-widget-id="AR_1" style="margin-top: 20px; margin-bottom: 20px;"></div>
		<script type="text/javascript" async="async" src="//widgets.outbrain.com/outbrain.js"></script>
	<?php
	}
};


// загрузка шрифтів на початку сторінки
function webfont_loader()
{
	?>
	<meta name="robots" content="max-image-preview:large, max-snippet:-1, max-video-preview:-1">
	<link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;500;700&display=swap" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
	<?php
};
add_action('wp_head', 'webfont_loader', 2);



// загрузка Adsense auto ads на початку сторінки
function ads_loader()
{
	if (is_single(array(18722))) {
	?>
		<link rel="preconnect" href="https://a.pub.network/" crossorigin />
		<link rel="preconnect" href="https://b.pub.network/" crossorigin />
		<link rel="preconnect" href="https://c.pub.network/" crossorigin />
		<link rel="preconnect" href="https://d.pub.network/" crossorigin />
		<link rel="preconnect" href="https://c.amazon-adsystem.com" crossorigin />
		<link rel="preconnect" href="https://s.amazon-adsystem.com" crossorigin />
		<link rel="preconnect" href="https://secure.quantserve.com/" crossorigin />
		<link rel="preconnect" href="https://rules.quantcount.com/" crossorigin />
		<link rel="preconnect" href="https://pixel.quantserve.com/" crossorigin />
		<link rel="preconnect" href="https://cmp.quantcast.com/" crossorigin />
		<link rel="preconnect" href="https://btloader.com/" crossorigin />
		<link rel="preconnect" href="https://api.btloader.com/" crossorigin />
		<link rel="preconnect" href="https://confiant-integrations.global.ssl.fastly.net" crossorigin />
		<link rel="stylesheet" href="https://www.hadviser.com/wp-content/themes/hairadviser/cls.css">
		<script data-cfasync="false" type="text/javascript">
			var freestar = freestar || {};
			freestar.queue = freestar.queue || [];
			freestar.config = freestar.config || {};
			freestar.config.enabled_slots = [];
			freestar.initCallback = function() {
				(freestar.config.enabled_slots.length === 0) ? freestar.initCallbackCalled = false: freestar.newAdSlots(freestar.config.enabled_slots)
			}
		</script>
		<script src="https://a.pub.network/hadviser-com/pubfig.min.js" data-cfasync="false" async></script>
	<?php
	} else if (is_single(array(53, 1910, 3043, 2291, 3486, 951, 2679, 2789, 3884, 372, 2545, 3102, 550, 3161, 2455, 2093, 3698, 2608, 1847, 4134, 2010, 4485, 3828, 4858, 3231, 5480, 5726, 2171, 4247, 1785, 4543, 2080, 3218, 4735, 7157, 4427, 4011, 1467, 4368, 4800, 3953, 3418, 2926, 2983, 5417, 6857, 4191, 3578, 7005, 4618, 7626, 3294, 7479, 7729, 8172, 7993, 7919, 8274, 6117, 8319, 7412, 4984, 5283, 8234, 5348, 7536, 7663, 5166, 7339, 7282, 9292, 8730, 477, 8828, 7116, 9362, 8967, 8547, 8479, 8904, 6459, 6367, 9201, 9142,  10060, 8613, 9818, 9591, 10020, 2348, 10434, 10381, 9358, 10571, 9493, 11067, 10875, 4071, 10683, 4678, 2868, 9668, 11195, 10183, 10126, 10522, 5225, 4920, 5053, 7801, 3756, 9909, 11760, 10249, 10646, 9713, 10815, 9551, 5666, 9773, 9948, 10773, 9054, 10927, 10297, 15773, 14258, 16188, 17072, 15718, 16093, 17188, 16388, 15918, 17726, 11145, 17361, 16133, 16329, 15317, 17673, 17917, 18383, 18622, 19489, 17794, 10994, 14871, 17320, 14716, 19450, 17455, 18433, 10973, 15533, 17953, 19232, 19616, 20434, 16654, 20498, 16612, 20374, 19850, 18219, 21722, 21892, 21258, 23662, 22723, 18682, 22324, 17626, 23094, 23365, 22917, 23586, 25150, 23532, 23879, 22043, 18302, 23918, 24167, 16822, 25287, 22436, 23431, 17401, 22395, 24560, 23703, 22795, 21846, 20858, 20669, 24680, 27800, 23625, 11236, 26441, 20797, 24604, 25346, 24738, 24293, 27144, 25927, 24038, 24789, 25786, 18822))) {
	?>
		<link rel="preconnect" href="https://a.pub.network/" crossorigin />
		<link rel="preconnect" href="https://b.pub.network/" crossorigin />
		<link rel="preconnect" href="https://c.pub.network/" crossorigin />
		<link rel="preconnect" href="https://d.pub.network/" crossorigin />
		<link rel="preconnect" href="https://c.amazon-adsystem.com" crossorigin />
		<link rel="preconnect" href="https://s.amazon-adsystem.com" crossorigin />
		<link rel="preconnect" href="https://secure.quantserve.com/" crossorigin />
		<link rel="preconnect" href="https://rules.quantcount.com/" crossorigin />
		<link rel="preconnect" href="https://pixel.quantserve.com/" crossorigin />
		<link rel="preconnect" href="https://cmp.quantcast.com/" crossorigin />
		<link rel="preconnect" href="https://btloader.com/" crossorigin />
		<link rel="preconnect" href="https://api.btloader.com/" crossorigin />
		<link rel="preconnect" href="https://confiant-integrations.global.ssl.fastly.net" crossorigin />
		<link rel="stylesheet" href="https://www.hadviser.com/wp-content/themes/hairadviser/cls.css">
		<script data-cfasync="false" type="text/javascript">
			var freestar = freestar || {};
			freestar.queue = freestar.queue || [];
			freestar.config = freestar.config || {};
			freestar.config.enabled_slots = [];
			freestar.initCallback = function() {
				(freestar.config.enabled_slots.length === 0) ? freestar.initCallbackCalled = false: freestar.newAdSlots(freestar.config.enabled_slots)
			}
		</script>
		<script src="https://a.pub.network/hadviser-com/pubfig.min.js" data-cfasync="false" async></script>
	<?php
	} else {
	?>
		<link rel="preconnect" href="https://a.pub.network/" crossorigin />
		<link rel="preconnect" href="https://b.pub.network/" crossorigin />
		<link rel="preconnect" href="https://c.pub.network/" crossorigin />
		<link rel="preconnect" href="https://d.pub.network/" crossorigin />
		<link rel="preconnect" href="https://c.amazon-adsystem.com" crossorigin />
		<link rel="preconnect" href="https://s.amazon-adsystem.com" crossorigin />
		<link rel="preconnect" href="https://secure.quantserve.com/" crossorigin />
		<link rel="preconnect" href="https://rules.quantcount.com/" crossorigin />
		<link rel="preconnect" href="https://pixel.quantserve.com/" crossorigin />
		<link rel="preconnect" href="https://cmp.quantcast.com/" crossorigin />
		<link rel="preconnect" href="https://btloader.com/" crossorigin />
		<link rel="preconnect" href="https://api.btloader.com/" crossorigin />
		<link rel="preconnect" href="https://confiant-integrations.global.ssl.fastly.net" crossorigin />
		<link rel="stylesheet" href="https://www.hadviser.com/wp-content/themes/hairadviser/cls.css">
		<script data-cfasync="false" type="text/javascript">
			var freestar = freestar || {};
			freestar.queue = freestar.queue || [];
			freestar.config = freestar.config || {};
			freestar.config.enabled_slots = [];
			freestar.initCallback = function() {
				(freestar.config.enabled_slots.length === 0) ? freestar.initCallbackCalled = false: freestar.newAdSlots(freestar.config.enabled_slots)
			}
		</script>
		<script src="https://a.pub.network/hadviser-com/pubfig.min.js" data-cfasync="false" async></script>
	<?php
	}
};
add_action('wp_head', 'ads_loader', 11);




function intro_js_head()
{
	if (is_single(array(53, 1910, 3043, 2291, 3486, 951, 2679, 2789, 3884, 372, 2545, 3102, 550, 3161, 2455, 2093, 3698, 2608, 1847, 4134, 2010, 4485, 3828, 4858, 3231, 5480, 5726, 2171, 4247, 1785, 4543, 2080, 3218, 4735, 7157, 4427, 4011, 1467, 4368, 4800, 3953, 3418, 2926, 2983, 5417, 6857, 4191, 3578, 7005, 4618, 7626, 3294, 7479, 7729, 8172, 7993, 7919, 8274, 6117, 8319, 7412, 4984, 5283, 8234, 5348, 7536, 7663, 5166, 7339, 7282, 9292, 8730, 477, 8828, 7116, 9362, 8967, 8547, 8479, 8904, 6459, 6367, 9201, 9142,  10060, 8613, 9818, 9591, 10020, 2348, 10434, 10381, 9358, 10571, 9493, 11067, 10875, 4071, 10683, 4678, 2868, 9668, 11195, 10183, 10126, 10522, 5225, 4920, 5053, 7801, 3756, 9909, 11760, 10249, 10646, 9713, 10815, 9551, 5666, 9773, 9948, 10773, 9054, 10927, 10297, 15773, 14258, 16188, 17072, 15718, 16093, 17188, 16388, 15918, 17726, 11145, 17361, 16133, 16329, 15317, 18722, 17673, 17917, 18383, 18622, 19489, 17794, 10994, 14871, 17320, 14716, 19450, 17455, 18433, 10973, 15533, 17953, 19232, 19616, 20434, 16654, 20498, 16612, 20374, 19850, 18219, 21722, 21892, 21258, 23662, 22723, 18682, 22324, 17626, 23094, 23365, 22917, 23586, 25150, 23532, 23879, 22043, 18302, 23918, 24167, 16822, 25287, 22436, 23431, 17401, 22395, 24560, 23703, 22795, 21846, 20858, 20669, 24680, 27800, 23625, 11236, 26441, 20797, 24604, 25346, 24738, 24293, 27144, 25927, 24038, 24789, 25786, 18822))) {
	?>

		<link href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/3.4.0/introjs.min.css" rel="stylesheet">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/3.4.0/intro.min.js"></script>
	<?php
	}
}
add_action('wp_footer', 'intro_js_head');



function intro_js_footer()
{
	if (is_single(array(53, 1910, 3043, 2291, 3486, 951, 2679, 2789, 3884, 372, 2545, 3102, 550, 3161, 2455, 2093, 3698, 2608, 1847, 4134, 2010, 4485, 3828, 4858, 3231, 5480, 5726, 2171, 4247, 1785, 4543, 2080, 3218, 4735, 7157, 4427, 4011, 1467, 4368, 4800, 3953, 3418, 2926, 2983, 5417, 6857, 4191, 3578, 7005, 4618, 7626, 3294, 7479, 7729, 8172, 7993, 7919, 8274, 6117, 8319, 7412, 4984, 5283, 8234, 5348, 7536, 7663, 5166, 7339, 7282, 9292, 8730, 477, 8828, 7116, 9362, 8967, 8547, 8479, 8904, 6459, 6367, 9201, 9142,  10060, 8613, 9818, 9591, 10020, 2348, 10434, 10381, 9358, 10571, 9493, 11067, 10875, 4071, 10683, 4678, 2868, 9668, 11195, 10183, 10126, 10522, 5225, 4920, 5053, 7801, 3756, 9909, 11760, 10249, 10646, 9713, 10815, 9551, 5666, 9773, 9948, 10773, 9054, 10927, 10297, 15773, 14258, 16188, 17072, 15718, 16093, 17188, 16388, 15918, 17726, 11145, 17361, 16133, 16329, 15317, 18722, 17673, 17917, 18383, 18622, 19489, 17794, 10994, 14871, 17320, 14716, 19450, 17455, 18433, 10973, 15533, 17953, 19232, 19616, 20434, 16654, 20498, 16612, 20374, 19850, 18219, 21722, 21892, 21258, 23662, 22723, 18682, 22324, 17626, 23094, 23365, 22917, 23586, 25150, 23532, 23879, 22043, 18302, 23918, 24167, 16822, 25287, 22436, 23431, 17401, 22395, 24560, 23703, 22795, 21846, 20858, 20669, 24680, 27800, 23625, 11236, 26441, 20797, 24604, 25346, 24738, 24293, 27144, 25927, 24038, 24789, 25786, 18822))) {
	?>
		<style>
			.theiaPostSlider_nav._lower {
				overflow: visible !important;
			}

			._lower ._buttons ._next {
				animation: shadow-pulse 0.8s infinite;
			}

			@keyframes shadow-pulse {
				0% {
					box-shadow: 0 0 0 0 rgb(42 97 195);
				}

				100% {
					box-shadow: 0 0 0 8px rgba(0, 0, 255, 0);
				}
			}
		</style>
		<style>
			.introjs-tooltip {
				font-size: 25px !important;
				line-height: 35px !important;
				left: 50% !important;
				transform: translateX(-50%);
			}
		</style>
		<script>
			(function() {
				var introShownCount = sessionStorage.getItem("introShownCount") || 0;
				var introDoneClickCount = sessionStorage.getItem("introDoneClickCount") || 0;
				var introNextClickCount = sessionStorage.getItem("introNextClickCount") || 0;

				function updateOverlayBackground(introInstance) {
					const helperLayer = document.querySelector(".introjs-helperLayer");
					if (helperLayer) {
						helperLayer.style.boxShadow = "rgba(33, 33, 33, 0.9) 0px 0px 1px 3px, rgba(33, 33, 33, 0.8) 0px 0px 0px 5000px";
					}
				}

				function showIntro(nextButton) {
					if (!sessionStorage.getItem("introShown")) {
						_paq.push(["trackEvent", "Intro", "Viewed"]);
						const introInstance = introJs().setOptions({
							steps: [{
								element: nextButton,
								intro: "Click 'Next style' to see the next hairstyle.",
								position: "bottom"
							}],
							showBullets: false,
							scrollToElement: false
						});
						introInstance.oncomplete(() => {
							sessionStorage.setItem("introDoneClickCount", ++introDoneClickCount);
							_paq.push(["trackEvent", "Intro", "Click", "Done"]);
						});
						introInstance.start();
						sessionStorage.setItem("introShown", "true");
						sessionStorage.setItem("introShownCount", ++introShownCount);
						updateOverlayBackground(introInstance);
						nextButton.addEventListener("click", () => {
							const overlay = document.querySelector(".introjs-overlay");
							if (overlay && window.getComputedStyle(overlay).getPropertyValue("visibility") === "visible") {
								introInstance.exit();
							}
							if (sessionStorage.getItem("introShown") && !sessionStorage.getItem("introNextClickCount")) {
								sessionStorage.setItem("introNextClickCount", ++introNextClickCount);
								_paq.push(["trackEvent", "Intro", "Click", "Next"]);
							}
						});
					}
				}
				const nextButton = document.querySelector("._lower ._buttons");
				const observer = new IntersectionObserver((entries) => {
					entries.forEach((entry) => {
						const scrolledAtLeast100px = window.scrollY || window.pageYOffset >= 100;
						if (entry.isIntersecting && scrolledAtLeast100px && !sessionStorage.getItem("introShown")) {
							showIntro(nextButton);
							observer.unobserve(nextButton);
						}
					});
				}, {
					threshold: 1.0
				});
				observer.observe(nextButton);
			})();
		</script>
	<?php
	}
}
add_action('wp_footer', 'intro_js_footer');






// -18722 (test page), +2679 (test page 2), +372
function tps_adv_handler()
{
	if (is_single(array(53, 1910, 3043, 2291, 3486, 951, 2789, 3884, 2545, 3102, 550, 3161, 2455, 2093, 3698, 2608, 1847, 4134, 2010, 4485, 3828, 4858, 3231, 5480, 5726, 2171, 4247, 1785, 4543, 2080, 3218, 4735, 7157, 4427, 4011, 1467, 4368, 4800, 3953, 3418, 2926, 2983, 5417, 6857, 4191, 3578, 7005, 4618, 7626, 3294, 7479, 7729, 8172, 7993, 7919, 8274, 6117, 8319, 7412, 4984, 5283, 8234, 5348, 7536, 7663, 5166, 7339, 7282, 9292, 8730, 477, 8828, 7116, 9362, 8967, 8547, 8479, 8904, 6459, 6367, 9201, 9142,  10060, 8613, 9818, 9591, 10020, 2348, 10434, 10381, 9358, 10571, 9493, 11067, 10875, 4071, 10683, 4678, 2868, 9668, 11195, 10183, 10126, 10522, 5225, 4920, 5053, 7801, 3756, 9909, 11760, 10249, 10646, 9713, 10815, 9551, 5666, 9773, 9948, 10773, 9054, 10927, 10297, 15773, 14258, 16188, 17072, 15718, 16093, 17188, 16388, 15918, 17726, 11145, 17361, 16133, 16329, 15317, 17673, 17917, 18383, 18622, 19489, 17794, 10994, 14871, 17320, 14716, 19450, 17455, 18433, 10973, 15533, 17953, 19232, 19616, 20434, 16654, 20498, 16612, 20374, 19850, 18219, 21722, 21892, 21258, 23662, 22723, 18682, 22324, 17626, 23094, 23365, 22917, 23586, 25150, 23532, 23879, 22043, 18302, 23918, 24167, 16822, 2679, 372, 25287, 22436, 23431, 17401, 22395, 24560, 23703, 22795, 21846, 20858, 20669, 24680, 27800, 23625, 11236, 26441, 20797, 24604, 25346, 24738, 24293, 27144, 25927, 24038, 24789, 25786, 18822))) {
	?>
		<script type="text/javascript" defer="defer" src="https://www.hadviser.com/wp-content/themes/hairadviser/js/content-visibility-v1.0.js"></script>
		<style type="text/css">
			.theiaPostSlider_slides .wp-caption.aligncenter {
				position: relative
			}

			.pinterest-container {
				max-width: 100%;
				width: 500px;
				margin: 0 auto;
				position: absolute;
				right: 0;
				top: 0;
				text-align: left
			}

			.pinterest-save {
				z-index: 999;
				margin: 15px;
				font-size: 14px;
				font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
				text-align: center;
				text-decoration: none;
				color: #fff;
				background: #e60023 url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGhlaWdodD0iMzBweCIgd2lkdGg9IjMwcHgiIHZpZXdCb3g9Ii0xIC0xIDMxIDMxIj48Zz48cGF0aCBkPSJNMjkuNDQ5LDE0LjY2MiBDMjkuNDQ5LDIyLjcyMiAyMi44NjgsMjkuMjU2IDE0Ljc1LDI5LjI1NiBDNi42MzIsMjkuMjU2IDAuMDUxLDIyLjcyMiAwLjA1MSwxNC42NjIgQzAuMDUxLDYuNjAxIDYuNjMyLDAuMDY3IDE0Ljc1LDAuMDY3IEMyMi44NjgsMC4wNjcgMjkuNDQ5LDYuNjAxIDI5LjQ0OSwxNC42NjIiIGZpbGw9IiNmZmYiIHN0cm9rZT0iI2ZmZiIgc3Ryb2tlLXdpZHRoPSIxIj48L3BhdGg+PHBhdGggZD0iTTE0LjczMywxLjY4NiBDNy41MTYsMS42ODYgMS42NjUsNy40OTUgMS42NjUsMTQuNjYyIEMxLjY2NSwyMC4xNTkgNS4xMDksMjQuODU0IDkuOTcsMjYuNzQ0IEM5Ljg1NiwyNS43MTggOS43NTMsMjQuMTQzIDEwLjAxNiwyMy4wMjIgQzEwLjI1MywyMi4wMSAxMS41NDgsMTYuNTcyIDExLjU0OCwxNi41NzIgQzExLjU0OCwxNi41NzIgMTEuMTU3LDE1Ljc5NSAxMS4xNTcsMTQuNjQ2IEMxMS4xNTcsMTIuODQyIDEyLjIxMSwxMS40OTUgMTMuNTIyLDExLjQ5NSBDMTQuNjM3LDExLjQ5NSAxNS4xNzUsMTIuMzI2IDE1LjE3NSwxMy4zMjMgQzE1LjE3NSwxNC40MzYgMTQuNDYyLDE2LjEgMTQuMDkzLDE3LjY0MyBDMTMuNzg1LDE4LjkzNSAxNC43NDUsMTkuOTg4IDE2LjAyOCwxOS45ODggQzE4LjM1MSwxOS45ODggMjAuMTM2LDE3LjU1NiAyMC4xMzYsMTQuMDQ2IEMyMC4xMzYsMTAuOTM5IDE3Ljg4OCw4Ljc2NyAxNC42NzgsOC43NjcgQzEwLjk1OSw4Ljc2NyA4Ljc3NywxMS41MzYgOC43NzcsMTQuMzk4IEM4Ljc3NywxNS41MTMgOS4yMSwxNi43MDkgOS43NDksMTcuMzU5IEM5Ljg1NiwxNy40ODggOS44NzIsMTcuNiA5Ljg0LDE3LjczMSBDOS43NDEsMTguMTQxIDkuNTIsMTkuMDIzIDkuNDc3LDE5LjIwMyBDOS40MiwxOS40NCA5LjI4OCwxOS40OTEgOS4wNCwxOS4zNzYgQzcuNDA4LDE4LjYyMiA2LjM4NywxNi4yNTIgNi4zODcsMTQuMzQ5IEM2LjM4NywxMC4yNTYgOS4zODMsNi40OTcgMTUuMDIyLDYuNDk3IEMxOS41NTUsNi40OTcgMjMuMDc4LDkuNzA1IDIzLjA3OCwxMy45OTEgQzIzLjA3OCwxOC40NjMgMjAuMjM5LDIyLjA2MiAxNi4yOTcsMjIuMDYyIEMxNC45NzMsMjIuMDYyIDEzLjcyOCwyMS4zNzkgMTMuMzAyLDIwLjU3MiBDMTMuMzAyLDIwLjU3MiAxMi42NDcsMjMuMDUgMTIuNDg4LDIzLjY1NyBDMTIuMTkzLDI0Ljc4NCAxMS4zOTYsMjYuMTk2IDEwLjg2MywyNy4wNTggQzEyLjA4NiwyNy40MzQgMTMuMzg2LDI3LjYzNyAxNC43MzMsMjcuNjM3IEMyMS45NSwyNy42MzcgMjcuODAxLDIxLjgyOCAyNy44MDEsMTQuNjYyIEMyNy44MDEsNy40OTUgMjEuOTUsMS42ODYgMTQuNzMzLDEuNjg2IiBmaWxsPSIjZTYwMDIzIj48L3BhdGg+PC9nPjwvc3ZnPg==) 10px 50% no-repeat;
				-webkit-font-smoothing: antialiased;
				border-radius: 20px;
				width: auto;
				background-size: 18px 18px;
				text-indent: 36px;
				font-weight: 700;
				padding: 0 12px 0 0;
				cursor: pointer;
				display: inline-block;
				box-sizing: border-box;
				box-shadow: inset 0 0 1px #888;
				vertical-align: baseline;
				opacity: 1;
				transition: none;
				line-height: 40px;
				height: 40px
			}
		</style>
		<style type="text/css">
			@media (min-width: 1120px) {
				.content-vnpage div.wrap {
					display: flex;
				}

				.content-vnpage div.wrap .left-boxcont {
					margin-right: 30px;
				}

				#custom_html-4 {
					position: -webkit-sticky;
					position: sticky;
					top: 0;
				}

				.widget-box {
					margin-bottom: 20px !important;
				}
			}
		</style>
		<style>
			.adaptive-menu>ul>li a {
				padding: 15px 30px !important;
			}

			main.content-vnpage {
				padding-top: 20px !important;
			}

			.brs {
				margin-bottom: 10px !important;
			}

			@media screen and (max-width: 1120px) {
				.social-headers {
					display: none !important;
				}
			}
		
			@media screen and (max-width: 570px) {
				.social-headers {
					display: none !important;
				}

				.slogan-site_head {
					display: inline-block !important;
				}
			}

			#custom_html-6 {
				margin-bottom: 0px;
			}
		</style>
		<script type="text/javascript" defer="defer" src="https://www.hadviser.com/wp-content/themes/hairadviser/js/pin-button-v.3.3.js"></script>
		<script type="text/javascript" defer="defer" src="https://www.hadviser.com/wp-content/themes/hairadviser/js/helper-v.11.14.js"></script>
		<script type="text/javascript" defer="defer" src="https://www.hadviser.com/wp-content/themes/hairadviser/js/img-nopin-v.1.7.js"></script>
	<?php
	} else if (is_single(array(18722))) {
	?>
		<script type="text/javascript" defer="defer" src="https://www.hadviser.com/wp-content/themes/hairadviser/js/content-visibility-v1.0.js"></script>
		<style type="text/css">
			.theiaPostSlider_slides .wp-caption.aligncenter {
				position: relative
			}

			.pinterest-container {
				max-width: 100%;
				width: 500px;
				margin: 0 auto;
				position: absolute;
				right: 0;
				top: 0;
				text-align: left
			}

			.pinterest-save {
				z-index: 999;
				margin: 15px;
				font-size: 14px;
				font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
				text-align: center;
				text-decoration: none;
				color: #fff;
				background: #e60023 url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGhlaWdodD0iMzBweCIgd2lkdGg9IjMwcHgiIHZpZXdCb3g9Ii0xIC0xIDMxIDMxIj48Zz48cGF0aCBkPSJNMjkuNDQ5LDE0LjY2MiBDMjkuNDQ5LDIyLjcyMiAyMi44NjgsMjkuMjU2IDE0Ljc1LDI5LjI1NiBDNi42MzIsMjkuMjU2IDAuMDUxLDIyLjcyMiAwLjA1MSwxNC42NjIgQzAuMDUxLDYuNjAxIDYuNjMyLDAuMDY3IDE0Ljc1LDAuMDY3IEMyMi44NjgsMC4wNjcgMjkuNDQ5LDYuNjAxIDI5LjQ0OSwxNC42NjIiIGZpbGw9IiNmZmYiIHN0cm9rZT0iI2ZmZiIgc3Ryb2tlLXdpZHRoPSIxIj48L3BhdGg+PHBhdGggZD0iTTE0LjczMywxLjY4NiBDNy41MTYsMS42ODYgMS42NjUsNy40OTUgMS42NjUsMTQuNjYyIEMxLjY2NSwyMC4xNTkgNS4xMDksMjQuODU0IDkuOTcsMjYuNzQ0IEM5Ljg1NiwyNS43MTggOS43NTMsMjQuMTQzIDEwLjAxNiwyMy4wMjIgQzEwLjI1MywyMi4wMSAxMS41NDgsMTYuNTcyIDExLjU0OCwxNi41NzIgQzExLjU0OCwxNi41NzIgMTEuMTU3LDE1Ljc5NSAxMS4xNTcsMTQuNjQ2IEMxMS4xNTcsMTIuODQyIDEyLjIxMSwxMS40OTUgMTMuNTIyLDExLjQ5NSBDMTQuNjM3LDExLjQ5NSAxNS4xNzUsMTIuMzI2IDE1LjE3NSwxMy4zMjMgQzE1LjE3NSwxNC40MzYgMTQuNDYyLDE2LjEgMTQuMDkzLDE3LjY0MyBDMTMuNzg1LDE4LjkzNSAxNC43NDUsMTkuOTg4IDE2LjAyOCwxOS45ODggQzE4LjM1MSwxOS45ODggMjAuMTM2LDE3LjU1NiAyMC4xMzYsMTQuMDQ2IEMyMC4xMzYsMTAuOTM5IDE3Ljg4OCw4Ljc2NyAxNC42NzgsOC43NjcgQzEwLjk1OSw4Ljc2NyA4Ljc3NywxMS41MzYgOC43NzcsMTQuMzk4IEM4Ljc3NywxNS41MTMgOS4yMSwxNi43MDkgOS43NDksMTcuMzU5IEM5Ljg1NiwxNy40ODggOS44NzIsMTcuNiA5Ljg0LDE3LjczMSBDOS43NDEsMTguMTQxIDkuNTIsMTkuMDIzIDkuNDc3LDE5LjIwMyBDOS40MiwxOS40NCA5LjI4OCwxOS40OTEgOS4wNCwxOS4zNzYgQzcuNDA4LDE4LjYyMiA2LjM4NywxNi4yNTIgNi4zODcsMTQuMzQ5IEM2LjM4NywxMC4yNTYgOS4zODMsNi40OTcgMTUuMDIyLDYuNDk3IEMxOS41NTUsNi40OTcgMjMuMDc4LDkuNzA1IDIzLjA3OCwxMy45OTEgQzIzLjA3OCwxOC40NjMgMjAuMjM5LDIyLjA2MiAxNi4yOTcsMjIuMDYyIEMxNC45NzMsMjIuMDYyIDEzLjcyOCwyMS4zNzkgMTMuMzAyLDIwLjU3MiBDMTMuMzAyLDIwLjU3MiAxMi42NDcsMjMuMDUgMTIuNDg4LDIzLjY1NyBDMTIuMTkzLDI0Ljc4NCAxMS4zOTYsMjYuMTk2IDEwLjg2MywyNy4wNTggQzEyLjA4NiwyNy40MzQgMTMuMzg2LDI3LjYzNyAxNC43MzMsMjcuNjM3IEMyMS45NSwyNy42MzcgMjcuODAxLDIxLjgyOCAyNy44MDEsMTQuNjYyIEMyNy44MDEsNy40OTUgMjEuOTUsMS42ODYgMTQuNzMzLDEuNjg2IiBmaWxsPSIjZTYwMDIzIj48L3BhdGg+PC9nPjwvc3ZnPg==) 10px 50% no-repeat;
				-webkit-font-smoothing: antialiased;
				border-radius: 20px;
				width: auto;
				background-size: 18px 18px;
				text-indent: 36px;
				font-weight: 700;
				padding: 0 12px 0 0;
				cursor: pointer;
				display: inline-block;
				box-sizing: border-box;
				box-shadow: inset 0 0 1px #888;
				vertical-align: baseline;
				opacity: 1;
				transition: none;
				line-height: 40px;
				height: 40px
			}
		</style>
		<style type="text/css">
			@media (min-width: 1120px) {
				.content-vnpage div.wrap {
					display: flex;
				}

				.content-vnpage div.wrap .left-boxcont {
					margin-right: 30px;
				}

				#custom_html-4 {
					position: -webkit-sticky;
					position: sticky;
					top: 0;
				}

				.widget-box {
					margin-bottom: 20px !important;
				}
			}
		</style>
		<style>
			.adaptive-menu>ul>li a {
				padding: 15px 30px !important;
			}

			main.content-vnpage {
				padding-top: 20px !important;
			}

			.brs {
				margin-bottom: 10px !important;
			}

			@media screen and (max-width: 1120px) {
				.social-headers {
					display: none !important;
				}
			}

			@media screen and (max-width: 570px) {
				.social-headers {
					display: none !important;
				}

				.slogan-site_head {
					display: inline-block !important;
				}
			}

			#custom_html-6 {
				margin-bottom: 0px;
			}
		</style>
		<script type="text/javascript" defer="defer" src="https://www.hadviser.com/wp-content/themes/hairadviser/js/pin-button-v.3.3.js"></script>
		<script type="text/javascript" defer="defer" src="https://www.hadviser.com/wp-content/themes/hairadviser/js/helper-v.11.14.js"></script>
		<script type="text/javascript" defer="defer" src="https://www.hadviser.com/wp-content/themes/hairadviser/js/img-nopin-v.1.7.js"></script>
	<?php
	} else if (is_single()) {
	?>
		<style type="text/css">
			.post .wp-caption.aligncenter {
				position: relative
			}

			.pinterest-container {
				max-width: 100%;
				width: 500px;
				margin: 0 auto;
				position: absolute;
				right: 0;
				top: 0;
				text-align: left
			}

			.pinterest-save {
				z-index: 999;
				margin: 15px;
				font-size: 14px;
				font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
				text-align: center;
				text-decoration: none;
				color: #fff;
				background: #e60023 url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGhlaWdodD0iMzBweCIgd2lkdGg9IjMwcHgiIHZpZXdCb3g9Ii0xIC0xIDMxIDMxIj48Zz48cGF0aCBkPSJNMjkuNDQ5LDE0LjY2MiBDMjkuNDQ5LDIyLjcyMiAyMi44NjgsMjkuMjU2IDE0Ljc1LDI5LjI1NiBDNi42MzIsMjkuMjU2IDAuMDUxLDIyLjcyMiAwLjA1MSwxNC42NjIgQzAuMDUxLDYuNjAxIDYuNjMyLDAuMDY3IDE0Ljc1LDAuMDY3IEMyMi44NjgsMC4wNjcgMjkuNDQ5LDYuNjAxIDI5LjQ0OSwxNC42NjIiIGZpbGw9IiNmZmYiIHN0cm9rZT0iI2ZmZiIgc3Ryb2tlLXdpZHRoPSIxIj48L3BhdGg+PHBhdGggZD0iTTE0LjczMywxLjY4NiBDNy41MTYsMS42ODYgMS42NjUsNy40OTUgMS42NjUsMTQuNjYyIEMxLjY2NSwyMC4xNTkgNS4xMDksMjQuODU0IDkuOTcsMjYuNzQ0IEM5Ljg1NiwyNS43MTggOS43NTMsMjQuMTQzIDEwLjAxNiwyMy4wMjIgQzEwLjI1MywyMi4wMSAxMS41NDgsMTYuNTcyIDExLjU0OCwxNi41NzIgQzExLjU0OCwxNi41NzIgMTEuMTU3LDE1Ljc5NSAxMS4xNTcsMTQuNjQ2IEMxMS4xNTcsMTIuODQyIDEyLjIxMSwxMS40OTUgMTMuNTIyLDExLjQ5NSBDMTQuNjM3LDExLjQ5NSAxNS4xNzUsMTIuMzI2IDE1LjE3NSwxMy4zMjMgQzE1LjE3NSwxNC40MzYgMTQuNDYyLDE2LjEgMTQuMDkzLDE3LjY0MyBDMTMuNzg1LDE4LjkzNSAxNC43NDUsMTkuOTg4IDE2LjAyOCwxOS45ODggQzE4LjM1MSwxOS45ODggMjAuMTM2LDE3LjU1NiAyMC4xMzYsMTQuMDQ2IEMyMC4xMzYsMTAuOTM5IDE3Ljg4OCw4Ljc2NyAxNC42NzgsOC43NjcgQzEwLjk1OSw4Ljc2NyA4Ljc3NywxMS41MzYgOC43NzcsMTQuMzk4IEM4Ljc3NywxNS41MTMgOS4yMSwxNi43MDkgOS43NDksMTcuMzU5IEM5Ljg1NiwxNy40ODggOS44NzIsMTcuNiA5Ljg0LDE3LjczMSBDOS43NDEsMTguMTQxIDkuNTIsMTkuMDIzIDkuNDc3LDE5LjIwMyBDOS40MiwxOS40NCA5LjI4OCwxOS40OTEgOS4wNCwxOS4zNzYgQzcuNDA4LDE4LjYyMiA2LjM4NywxNi4yNTIgNi4zODcsMTQuMzQ5IEM2LjM4NywxMC4yNTYgOS4zODMsNi40OTcgMTUuMDIyLDYuNDk3IEMxOS41NTUsNi40OTcgMjMuMDc4LDkuNzA1IDIzLjA3OCwxMy45OTEgQzIzLjA3OCwxOC40NjMgMjAuMjM5LDIyLjA2MiAxNi4yOTcsMjIuMDYyIEMxNC45NzMsMjIuMDYyIDEzLjcyOCwyMS4zNzkgMTMuMzAyLDIwLjU3MiBDMTMuMzAyLDIwLjU3MiAxMi42NDcsMjMuMDUgMTIuNDg4LDIzLjY1NyBDMTIuMTkzLDI0Ljc4NCAxMS4zOTYsMjYuMTk2IDEwLjg2MywyNy4wNTggQzEyLjA4NiwyNy40MzQgMTMuMzg2LDI3LjYzNyAxNC43MzMsMjcuNjM3IEMyMS45NSwyNy42MzcgMjcuODAxLDIxLjgyOCAyNy44MDEsMTQuNjYyIEMyNy44MDEsNy40OTUgMjEuOTUsMS42ODYgMTQuNzMzLDEuNjg2IiBmaWxsPSIjZTYwMDIzIj48L3BhdGg+PC9nPjwvc3ZnPg==) 10px 50% no-repeat;
				-webkit-font-smoothing: antialiased;
				border-radius: 20px;
				width: auto;
				background-size: 18px 18px;
				text-indent: 36px;
				font-weight: 700;
				padding: 0 12px 0 0;
				cursor: pointer;
				display: inline-block;
				box-sizing: border-box;
				box-shadow: inset 0 0 1px #888;
				vertical-align: baseline;
				opacity: 1;
				transition: none;
				line-height: 40px;
				height: 40px
			}
		</style>
		<style type="text/css">
			@media (min-width: 1120px) {
				.content-vnpage div.wrap {
					display: flex;
				}

				.content-vnpage div.wrap .left-boxcont {
					margin-right: 30px;
				}

				#custom_html-4 {
					position: -webkit-sticky;
					position: sticky;
					top: 0;
				}

				.widget-box {
					margin-bottom: 20px !important;
				}
			}
		</style>
		<style>
			.adaptive-menu>ul>li a {
				padding: 15px 30px !important;
			}

			main.content-vnpage {
				padding-top: 20px !important;
			}

			.brs {
				margin-bottom: 10px !important;
			}

			@media screen and (max-width: 1120px) {
				.social-headers {
					display: none !important;
				}
			}

			@media screen and (max-width: 570px) {
				.social-headers {
					display: none !important;
				}

				.slogan-site_head {
					display: inline-block !important;
				}
			}

			#custom_html-6 {
				margin-bottom: 0px;
			}
		</style>
		<script type="text/javascript" defer="defer" src="https://www.hadviser.com/wp-content/themes/hairadviser/js/save-v.0.0.2.js"></script>
		<script type="text/javascript" defer="defer" src="https://www.hadviser.com/wp-content/themes/hairadviser/js/social-buttons-v1.js"></script>
	<?php
	} else {
	?>
		<style>
			.adaptive-menu>ul>li a {
				padding: 15px 30px !important;
			}

			main.content-vnpage {
				padding-top: 20px !important;
			}

			.brs {
				margin-bottom: 10px !important;
			}

			@media screen and (max-width: 1120px) {
				.social-headers {
					display: none !important;
				}
			}

			@media screen and (max-width: 570px) {
				.social-headers {
					display: none !important;
				}
				
				.slogan-site_head {
					display: inline-block !important;
				}
			}

			#custom_html-6 {
				margin-bottom: 0px;
			}
		</style>
		<style type="text/css">
			@media (min-width: 1120px) {
				.category-default #custom_html-4 .textwidget {
					position: -webkit-sticky;
					position: sticky;
					top: 0;
				}

				.category-default #custom_html-4 {
					height: 4000px;
				}

				.widget-box {
					margin-bottom: 20px !important;
				}
			}
		</style>
	<?php
	}
};
add_action('wp_head', 'tps_adv_handler');






// Remove jetpack devicepx and photon script
function remove_devicepx()
{
	wp_dequeue_script('devicepx');
}
add_action('wp_enqueue_scripts', 'remove_devicepx');

function remove_photon_script()
{
	wp_dequeue_script('jetpack-photon');
}
add_action('wp_enqueue_scripts', 'remove_photon_script', 999);





// +18722 (test page)
/*
function hadviser_test_old_js() {
    if (is_single(array(18722))) {
?>
<script type="text/javascript" defer="defer" src="https://ab-optimizer-dev.s3.eu-central-1.amazonaws.com/metrics-collector.js"></script>
<?php 
  }
};
add_action('wp_head','hadviser_test_old_js');
*/



// new js collector 
function hadviser_test_metrics()
{
	if (is_single(array(10646, 9358, 18383, 17072, 19616, 27800, 53, 4191, 4247, 7157, 19489, 21722, 21892, 14258, 5283, 23586, 7919, 9201, 1910, 3418, 9591, 7282, 9362, 8613, 9948, 9292, 7479))) {
	?>
		<script type="text/javascript" defer="defer" src="https://www.hadviser.com/wp-content/themes/hairadviser/js/metrics-collector-v2.7.js"></script>
		<?php
	}
};
add_action('wp_head', 'hadviser_test_metrics', 9);




add_filter('wpseo_og_og_image_width', '__return_false');
add_filter('wpseo_og_og_image_height', '__return_false');








function hadviser_defer_attribute($tag, $handle)
{

	if (is_single() and 'lazyad-loader' != $handle and 'script' != $handle) {
		return str_replace(' src', ' defer="defer" src', $tag);
	}

	return $tag;
}
add_filter('script_loader_tag', 'hadviser_defer_attribute', 10, 2);




add_filter('wpseo_canonical', 'yoast_seo_canonical_ignore_pagination');
function yoast_seo_canonical_ignore_pagination($canonical_url)
{
	$page = get_query_var('page');
	if (is_single() && $page >= 2) {
		return get_permalink();
	} else {
		return $canonical_url;
	}
}




// Custom body clasess
function body_class_1()
{
	if (is_category()) {
		$cat_id = get_query_var('cat');
		if (get_option("cattpl_" . $cat_id) == 1) {
		?> category-default"<?php
						} else { ?>"<?php }
							} else if (is_single(array(53, 1910, 3043, 2291, 3486, 951, 2679, 2789, 3884, 372, 2545, 3102, 550, 3161, 2455, 2093, 3698, 2608, 1847, 4134, 2010, 4485, 3828, 4858, 3231, 5480, 5726, 2171, 4247, 1785, 4543, 2080, 3218, 4735, 7157, 4427, 4011, 1467, 4368, 4800, 3953, 3418, 2926, 2983, 5417, 6857, 4191, 3578, 7005, 4618, 7626, 3294, 7479, 7729, 8172, 7993, 7919, 8274, 6117, 8319, 7412, 4984, 5283, 8234, 5348, 7536, 7663, 5166, 7339, 7282, 9292, 8730, 477, 8828, 7116, 9362, 8967, 8547, 8479, 8904, 6459, 6367, 9201, 9142,  10060, 8613, 9818, 9591, 10020, 2348, 10434, 10381, 9358, 10571, 9493, 11067, 10875, 4071, 10683, 4678, 2868, 9668, 11195, 10183, 10126, 10522, 5225, 4920, 5053, 7801, 3756, 9909, 11760, 10249, 10646, 9713, 10815, 9551, 5666, 9773, 9948, 10773, 9054, 10927, 10297, 15773, 14258, 16188, 17072, 15718, 16093, 17188, 16388, 15918, 17726, 11145, 17361, 16133, 16329, 15317, 18722, 17673, 17917, 18383, 18622, 19489, 17794, 10994, 14871, 17320, 14716, 19450, 17455, 18433, 10973, 15533, 17953, 19232, 19616, 20434, 16654, 20498, 16612, 20374, 19850, 18219, 21722, 21892, 21258, 23662, 22723, 18682, 22324, 17626, 23094, 23365, 22917, 23586, 25150, 23532, 23879, 22043, 18302, 23918, 24167, 16822, 25287, 22436, 23431, 17401, 22395, 24560, 23703, 22795, 21846, 20858, 20669, 24680, 27800, 23625, 11236, 26441, 20797, 24604, 25346, 24738, 24293, 27144, 25927, 24038, 24789, 25786, 18822))) {
									?> slider-default"<?php
													} else if (is_single()) {
														?> single-default"<?php
																		}
																	};


																	// +18722 (test page)  
																	function extra_content_hook_new($post)
																	{
																		if (is_single(array(53, 1910, 3043, 2291, 3486, 951, 2679, 2789, 3884, 372, 2545, 3102, 550, 3161, 2455, 2093, 3698, 2608, 1847, 4134, 2010, 4485, 3828, 4858, 3231, 5480, 5726, 2171, 4247, 1785, 4543, 2080, 3218, 4735, 7157, 4427, 4011, 1467, 4368, 4800, 3953, 3418, 2926, 2983, 5417, 6857, 4191, 3578, 7005, 4618, 7626, 3294, 7479, 7729, 8172, 7993, 7919, 8274, 6117, 8319, 7412, 4984, 5283, 8234, 5348, 7536, 7663, 5166, 7339, 7282, 9292, 8730, 477, 8828, 7116, 9362, 8967, 8547, 8479, 8904, 6459, 6367, 9201, 9142,  10060, 8613, 9818, 9591, 10020, 2348, 10434, 10381, 9358, 10571, 9493, 11067, 10875, 4071, 10683, 4678, 2868, 9668, 11195, 10183, 10126, 10522, 5225, 4920, 5053, 7801, 3756, 9909, 11760, 10249, 10646, 9713, 10815, 9551, 5666, 9773, 9948, 10773, 9054, 10927, 10297, 15773, 14258, 16188, 17072, 15718, 16093, 17188, 16388, 15918, 17726, 11145, 17361, 16133, 16329, 15317, 18722, 17673, 17917, 18383, 18622, 19489, 17794, 10994, 14871, 17320, 14716, 19450, 17455, 18433, 10973, 15533, 17953, 19232, 19616, 20434, 16654, 20498, 16612, 20374, 19850, 18219, 21722, 21892, 21258, 23662, 22723, 18682, 22324, 17626, 23094, 23365, 22917, 23586, 25150, 23532, 23879, 22043, 18302, 23918, 24167, 16822, 25287, 22436, 23431, 17401, 22395, 24560, 23703, 22795, 21846, 20858, 20669, 24680, 27800, 23625, 11236, 26441, 20797, 24604, 25346, 24738, 24293, 27144, 25927, 24038, 24789, 25786, 18822))) {
																			?>
			<div class="post-content-wrapper">
				<?php $post_custom = $post->post_content;
																			$post_custom_2 = preg_replace('/\[abPress(.*?)\]\r\n/', '', $post_custom);
																			$post_custom_3 = preg_replace('/\[\/abPress(.*?)\]\r\n/', '', $post_custom_2);
																			$post_custom_4 = preg_replace('/<!--nextpage(.*?)?-->\r\n/', '', $post_custom_3);
																			$post_custom_5 = preg_replace('/(.*?)<!--noteaser-->(.*?)\r\n\r\n/', '', $post_custom_4);
																			$post_custom_6 = apply_filters('the_content', $post_custom_5);
																			$post_custom_61 = preg_replace('/<div class=\"ad\"([\w\W]*?)<\/div>\r\n/', '', $post_custom_6);
																			$post_custom_62 = preg_replace('/<div id=\"hadvisecom_slider_pages_1\"([\w\W]*?)<\/div><\/div><\/p>/', '', $post_custom_61);
																			$post_custom_7 = preg_replace('/<!--(.*?)-->\n?/', '', $post_custom_62);
																			echo $post_custom_7;
				?>
			</div>
		<?php
																		}
																	}
																	add_action('post_extra_content', 'extra_content_hook_new');





																	remove_filter('the_content', 'wpautop');

																	add_filter('jetpack_implode_frontend_css', '__return_false', 99);


																	// AMP
																	// Exclude is_amp metabox
																	add_filter('amphtml_exclude_meta', 'amphtml_exclude_meta_custom');
																	function amphtml_exclude_meta_custom($exclude)
																	{
																		// exclude all posts by default
																		if ($exclude == '0') {
																			return false;
																		}
																		return true;
																	}

																	// Exclude is_amp post
																	add_filter('amphtml_is_excluded_post', 'amphtml_is_excluded_post_custom', 10, 2);
																	function amphtml_is_excluded_post_custom($exclude, $post_id)
																	{
																		// exclude existing posts
																		if (get_post_meta($post_id, 'amphtml-exclude', true) === '') {
																			$exclude = true;
																		}
																		return $exclude;
																	}

																	function amphtml_embedded_elements_custom($elements)
																	{
																		$elements[] = array(
																			'slug' => 'amp-pinterest',
																			'src' => 'https://cdn.ampproject.org/v0/amp-pinterest-0.1.js'
																		);
																		return $elements;
																	}

																	add_filter('amphtml_sanitize_image', 'amphtml_sanitize_image_custom', 10, 2);
																	function amphtml_sanitize_image_custom($img, $sanitizer)
																	{
																		// add Pin it button
																		add_filter('amphtml_embedded_elements', 'amphtml_embedded_elements_custom');
																		global $post;
																		$description = $img->alt ? $img->alt : $post->post_title;
																		$img->outertext = $img->outertext
																			. '<amp-pinterest 
		height=28
		width=56
		data-do="buttonPin"
		data-tall="true"
		data-url="' . get_the_permalink($post->ID) . '"
		data-media="' . $img->src . '"
		data-description="' . $description . '">
	</amp-pinterest>';

																		return $img;
																	}
																	// AMP


																	// Add lazy loading to all images in posts
																	function add_lazy_loading_to_all_images($content)
																	{
																		preg_match_all('/<img[^>]+>/i', $content, $matches);
																		$img_tags = $matches[0];
																		foreach ($img_tags as $tag) {
																			$new_tag = str_replace('<img', '<img loading="lazy" decoding="async"', $tag);
																			$content = str_replace($tag, $new_tag, $content);
																		}
																		return $content;
																	}
																	add_filter('the_content', 'add_lazy_loading_to_all_images');



																	// Add ad block after image caption на статтях без слайдерів
																	function img_caption_shortcode_html_2($empty, $attr, $content)
																	{
																		if (is_single(array(53, 1910, 3043, 2291, 3486, 951, 2679, 2789, 3884, 372, 2545, 3102, 550, 3161, 2455, 2093, 3698, 2608, 1847, 4134, 2010, 4485, 3828, 4858, 3231, 5480, 5726, 2171, 4247, 1785, 4543, 2080, 3218, 4735, 7157, 4427, 4011, 1467, 4368, 4800, 3953, 3418, 2926, 2983, 5417, 6857, 4191, 3578, 7005, 4618, 7626, 3294, 7479, 7729, 8172, 7993, 7919, 8274, 6117, 8319, 7412, 4984, 5283, 8234, 5348, 7536, 7663, 5166, 7339, 7282, 9292, 8730, 477, 8828, 7116, 9362, 8967, 8547, 8479, 8904, 6459, 6367, 9201, 9142,  10060, 8613, 9818, 9591, 10020, 2348, 10434, 10381, 9358, 10571, 9493, 11067, 10875, 4071, 10683, 4678, 2868, 9668, 11195, 10183, 10126, 10522, 5225, 4920, 5053, 7801, 3756, 9909, 11760, 10249, 10646, 9713, 10815, 9551, 5666, 9773, 9948, 10773, 9054, 10927, 10297, 15773, 14258, 16188, 17072, 15718, 16093, 17188, 16388, 15918, 17726, 11145, 17361, 16133, 16329, 15317, 18722, 17673, 17917, 18383, 18622, 19489, 17794, 10994, 14871, 17320, 14716, 19450, 17455, 18433, 10973, 15533, 17953, 19232, 19616, 20434, 16654, 20498, 16612, 20374, 19850, 18219, 21722, 21892, 21258, 23662, 22723, 18682, 22324, 17626, 23094, 23365, 22917, 23586, 25150, 23532, 23879, 22043, 18302, 23918, 24167, 16822, 25287, 22436, 23431, 17401, 22395, 24560, 23703, 22795, 21846, 20858, 20669, 24680, 27800, 23625, 11236, 26441, 20797, 24604, 25346, 24738, 24293, 27144, 25927, 24038, 24789, 25786, 18822))) {
																			$attr = shortcode_atts(array(
																				'id'      => '',
																				'align'   => 'alignnone',
																				'width'   => '',
																				'caption' => ''
																			), $attr);
																			if (1 > (int) $attr['width'] || empty($attr['caption'])) {
																				return '';
																			}
																			if ($attr['id']) {
																				$attr['id'] = 'id="' . esc_attr($attr['id']) . '" ';
																			}
																			return '<div ' . $attr['id']
																				. 'class="wp-caption ' . esc_attr($attr['align']) . '" '
																				. 'style="max-width: ' . ((int) $attr['width']) . 'px;">'
																				. do_shortcode($content)
																				. '<div class="wp-caption-text">' . $attr['caption'] . '</div>'
																				. '</div>';
																		} else if (is_single()) {
																			global $caption_position;
																			$caption_position++;
																			if ($caption_position % 2 == 0) {
																				global $ad_block_count;
																				$ad_block_count = isset($ad_block_count) ? $ad_block_count + 1 : 1;

																				$attr = shortcode_atts([
																					'id'      => '',
																					'align'   => 'alignnone',
																					'width'   => '',
																					'caption' => ''
																				], $attr);

																				if (1 > (int) $attr['width'] || empty($attr['caption'])) {
																					return '';
																				}

																				if ($attr['id']) {
																					$attr['id'] = 'id="' . esc_attr($attr['id']) . '" ';
																				}
																				$html = '<div ' . $attr['id']
																					. 'class="wp-caption ' . esc_attr($attr['align']) . '" '
																					. 'style="max-width: ' . (0 + (int) $attr['width']) . 'px;">'
																					. do_shortcode($content)
																					. '<div class="wp-caption-text">' . $attr['caption'] . '</div>'
																					. '</div>';

																				$ad_block_id = 'hadvisecom_classic_article_' . $ad_block_count;

																				$ad = '
<div class="adv-container" id="hadvisecom_classic_article"><div align="center" data-freestar-ad="__360x370 __730x280" id="' . $ad_block_id . '">
<script data-cfasync="false" type="text/javascript">freestar.config.enabled_slots.push({ placementName: "hadvisecom_classic_article", slotId: "' . $ad_block_id . '" });</script></div></div>';
																				return $html . $ad;
																			} else {
																				$attr = shortcode_atts(array(
																					'id'      => '',
																					'align'   => 'alignnone',
																					'width'   => '',
																					'caption' => ''
																				), $attr);
																				if (1 > (int) $attr['width'] || empty($attr['caption'])) {
																					return '';
																				}
																				if ($attr['id']) {
																					$attr['id'] = 'id="' . esc_attr($attr['id']) . '" ';
																				}
																				return '<div ' . $attr['id']
																					. 'class="wp-caption ' . esc_attr($attr['align']) . '" '
																					. 'style="max-width: ' . ((int) $attr['width']) . 'px;">'
																					. do_shortcode($content)
																					. '<div class="wp-caption-text">' . $attr['caption'] . '</div>'
																					. '</div>';
																			}
																		}
																	}
																	add_filter('img_caption_shortcode', 'img_caption_shortcode_html_2', 15, 3);




																	// Рекламний блок через кожних два анонси на сторінках категорій
																	function get_category_ad_block()
																	{
																		static $ad_block_count = 0;
																		$ad_block_count++;
																		$ad_block_id = 'hadvisecom_category_incontent_' . $ad_block_count;
																		$ad = '
    <div id="hadvisecom_category_incontent">
        <div align="center" data-freestar-ad="__336x280 __728x280" id="' . $ad_block_id . '">
            <script data-cfasync="false" type="text/javascript">
                freestar.config.enabled_slots.push({ placementName: "hadvisecom_category_incontent", slotId: "' . $ad_block_id . '" });
            </script>
        </div>
    </div>
    ';
																		return $ad;
																	}



																	// Блокую доступ до сторінки пошуку, редірект на головну
																	function block_direct_search_results_access()
																	{
																		if (is_search()) {
																			wp_redirect(home_url());
																			exit;
																		}
																	}
																	add_action('template_redirect', 'block_direct_search_results_access');


																	// Редірект всіх старих адрес амп сторінок на звичайні адреси
																	function redirect_amp_to_clean_url()
																	{
																		if (preg_match('/\/amp(\/)?$/', $_SERVER['REQUEST_URI'], $matches)) {
																			$clean_url = preg_replace('/\/amp(\/)?$/', '/', $_SERVER['REQUEST_URI']);
																			wp_redirect(home_url($clean_url), 301);
																			exit;
																		}
																	}
																	add_action('template_redirect', 'redirect_amp_to_clean_url');


																	// Видаляю wp-embed.min.js з коду сторінки
																	function my_deregister_scripts()
																	{
																		wp_dequeue_script('wp-embed');
																	}
																	add_action('wp_footer', 'my_deregister_scripts');



																	// Sourcepoint CMP - Resurfacing Link and CSS for the Privacy Button
																	add_filter('wp_nav_menu_items', 'add_privacy_manager_link', 10, 2);
																	function add_privacy_manager_link($items, $args)
																	{
																		if ($args->theme_location == 'footerbig') {
																			$items .= '<li><button id="pmLink">Privacy Manager</button></li>';
																		}
																		return $items;
																	}

																	function privacy_manager_css_footer()
																	{
		?>
		<style>
			#pmLink {
				visibility: hidden;
				text-decoration: none;
				cursor: pointer;
				background: transparent;
				border: none;
				padding: 10px 4px;
				display: block
			}

			#pmLink:hover {
				visibility: visible;
				color: grey
			}

			.site-footer {
				padding-bottom: 120px;
			}
		</style>
		<?php
																	}
																	add_action('wp_footer', 'privacy_manager_css_footer');




																	function gumgum_inimage_test()
																	{
																		if (is_single()) {
		?>
			<script type="text/javascript">
				ggv2id = '3gyrgusm';
			</script>
			<script type="text/javascript" src="https://js.gumgum.com/services.js"></script>
	<?php
																		}
																	}
																	add_action('hook_before_body', 'gumgum_inimage_test');
