<?php
function kama_pagenavi($before = '', $after = '', $echo = true, $args = array(), $wp_query = null)
{
	if (!$wp_query) {
		wp_reset_query();
		global $wp_query;
	}

	// параметры по умолчанию
	$default_args = array(
		'text_num_page'   => '', // Текст перед пагинацией. {current} - текущая; {last} - последняя (пр. 'Страница {current} из {last}' получим: "Страница 4 из 60" )
		'num_pages'       => 10, // сколько ссылок показывать
		'step_link'       => 10, // ссылки с шагом (значение - число, размер шага (пр. 1,2,3...10,20,30). Ставим 0, если такие ссылки не нужны.
		'dotright_text'   => '…', // промежуточный текст "до".
		'dotright_text2'  => '…', // промежуточный текст "после".
		'back_text'       => '«', // текст "перейти на предыдущую страницу". Ставим 0, если эта ссылка не нужна.
		'next_text'       => '»', // текст "перейти на следующую страницу". Ставим 0, если эта ссылка не нужна.
		'first_page_text' => 0, // текст "к первой странице". Ставим 0, если вместо текста нужно показать номер страницы.
		'last_page_text'  => 0, // текст "к последней странице". Ставим 0, если вместо текста нужно показать номер страницы.
	);

	$default_args = apply_filters('kama_pagenavi_args', $default_args); // чтобы можно было установить свои значения по умолчанию

	$args = array_merge($default_args, $args);

	extract($args);

	$posts_per_page = (int) $wp_query->get('posts_per_page');
	$paged          = (int) $wp_query->get('paged');
	$max_page       = $wp_query->max_num_pages;

	//проверка на надобность в навигации
	if ($max_page <= 1)
		return false;

	if (empty($paged) || $paged == 0)
		$paged = 1;

	$pages_to_show = intval($num_pages);
	$pages_to_show_minus_1 = $pages_to_show - 1;

	$half_page_start = floor($pages_to_show_minus_1 / 2); //сколько ссылок до текущей страницы
	$half_page_end = ceil($pages_to_show_minus_1 / 2); //сколько ссылок после текущей страницы

	$start_page = $paged - $half_page_start; //первая страница
	$end_page = $paged + $half_page_end; //последняя страница (условно)

	if ($start_page <= 0)
		$start_page = 1;
	if (($end_page - $start_page) != $pages_to_show_minus_1)
		$end_page = $start_page + $pages_to_show_minus_1;
	if ($end_page > $max_page) {
		$start_page = $max_page - $pages_to_show_minus_1;
		$end_page = (int) $max_page;
	}

	if ($start_page <= 0)
		$start_page = 1;

	//выводим навигацию
	$out = '';

	// создаем базу чтобы вызвать get_pagenum_link один раз
	$link_base = str_replace(99999999, '___', get_pagenum_link(99999999));
	$first_url = get_pagenum_link(1);
	if (false === strpos($first_url, '?'))
		$first_url = user_trailingslashit($first_url);

	$out .= $before . "<div class='nav-pages'>\n";

	if ($text_num_page) {
		$text_num_page = preg_replace('!{current}|{last}!', '%s', $text_num_page);
		$out .= sprintf("<span class='pages'>$text_num_page</span> ", $paged, $max_page);
	}
	// назад
	if ($back_text && $paged != 1)
		$out .= '<a class="prev" href="' . (($paged - 1) == 1 ? $first_url : str_replace('___', ($paged - 1), $link_base)) . '">' . $back_text . '</a> ';
	// в начало
	if ($start_page >= 2 && $pages_to_show < $max_page) {
		$out .= '<a class="first" href="' . $first_url . '">' . ($first_page_text ? $first_page_text : 1) . '</a> ';
		if ($dotright_text && $start_page != 2) $out .= '<span class="extend">' . $dotright_text . '</span> ';
	}
	// пагинация
	for ($i = $start_page; $i <= $end_page; $i++) {
		if ($i == $paged)
			$out .= '<span class="current">' . $i . '</span> ';
		elseif ($i == 1)
			$out .= '<a href="' . $first_url . '">1</a> ';
		else
			$out .= '<a href="' . str_replace('___', $i, $link_base) . '">' . $i . '</a> ';
	}

	//ссылки с шагом
	$dd = 0;
	if ($step_link && $end_page < $max_page) {
		for ($i = $end_page + 1; $i <= $max_page; $i++) {
			if ($i % $step_link == 0 && $i !== $num_pages) {
				if (++$dd == 1)
					$out .= '<span class="extend">' . $dotright_text2 . '</span> ';
				$out .= '<a href="' . str_replace('___', $i, $link_base) . '">' . $i . '</a> ';
			}
		}
	}
	// в конец
	if ($end_page < $max_page) {
		if ($dotright_text && $end_page != ($max_page - 1))
			$out .= '<span class="extend">' . $dotright_text2 . '</span> ';
		$out .= '<a class="last" href="' . str_replace('___', $max_page, $link_base) . '">' . ($last_page_text ? $last_page_text : $max_page) . '</a> ';
	}
	// вперед
	if ($next_text && $paged != $end_page)
		$out .= '<a class="next" href="' . str_replace('___', ($paged + 1), $link_base) . '">' . $next_text . '</a> ';

	$out .= "</div>" . $after . "\n";

	$out = apply_filters('kama_pagenavi', $out);

	if ($echo)
		return print $out;

	return $out;
}
function form_add_why()
{
	$title = $_POST['title'];
	$editor = apply_filters('the_content', $_POST['editor']);
	$my_post = array();
	$my_post['post_title'] = $title;
	$my_post['post_status'] = 'draft';
	$my_post['post_content'] = $editor;
	$my_post['post_author'] = 1;
	$my_post['post_category'] = array(options_theme('home_2_cat'));
	$new_post_id = wp_insert_post($my_post);
	add_post_meta($new_post_id, 'email', $_POST['email']);
	return true;
}
add_action('wp_ajax_send_service', 'form_add_why');
add_action('wp_ajax_nopriv_send_service', 'form_add_why');
add_shortcode('bq_1', 'blockquote_custom_button_1');
function blockquote_custom_button_1($atts, $content = null)
{
	extract(shortcode_atts(array(
		'style' => 'success'
	), $atts));
	return '<blockquote class="blockquote-custom bq-custom-1">' . $content . '</blockquote>';
}
add_shortcode('bq_2', 'blockquote_custom_button_2');
function blockquote_custom_button_2($atts, $content = null)
{
	extract(shortcode_atts(array(
		'style' => 'success'
	), $atts));
	return '<blockquote class="blockquote-custom bq-custom-2">' . $content . '</blockquote>';
}
add_shortcode('bq_3', 'blockquote_custom_button_3');
function blockquote_custom_button_3($atts, $content = null)
{
	extract(shortcode_atts(array(
		'style' => 'success'
	), $atts));
	return '<blockquote class="blockquote-custom bq-custom-3">' . $content . '</blockquote>';
}
add_shortcode('bq_4', 'blockquote_custom_button_4');
function blockquote_custom_button_4($atts, $content = null)
{
	extract(shortcode_atts(array(
		'style' => 'success'
	), $atts));
	return '<blockquote class="blockquote-custom bq-custom-4">' . $content . '</blockquote>';
}
// add_shortcode('bq_5', 'blockquote_custom_button_5');
// function blockquote_custom_button_5($atts, $content = null)
// {
// 	extract(shortcode_atts(array(
// 		'style' => 'success'
// 	), $atts));
// 	return '<blockquote class="blockquote-custom bq-custom-5">' . $content . '</blockquote>';
// }
add_action('admin_footer', 'eg_quicktags');
function eg_quicktags()
{
?>
	<script type="text/javascript" charset="utf-8">
		jQuery(document).ready(function() {
			if (typeof(QTags) !== 'undefined') {
				QTags.addButton('blockquote_custom_1', 'Цитата №1', '[bq_1]', '[/bq_1]');
				QTags.addButton('blockquote_custom_2', 'Цитата №2', '[bq_2]', '[/bq_2]');
				QTags.addButton('blockquote_custom_3', 'Цитата №3', '[bq_3]', '[/bq_3]');
				QTags.addButton('blockquote_custom_4', 'Вопрос', '[bq_4]', '[/bq_4]');
				// QTags.addButton('blockquote_custom_5', 'Описание артиста', '[bq_5]', '[/bq_5]');
			}
		});
	</script>
<?php }
function enqueue_plugin_scripts($plugin_array)
{
	$plugin_array["green_button_plugin"] =  get_template_directory_uri() . "/js/buttons-4.js";
	return $plugin_array;
}
add_filter("mce_external_plugins", "enqueue_plugin_scripts");
function register_buttons_editor($buttons)
{
	//register buttons with their id.
	// array_push($buttons, "blockquote_custom_1", "blockquote_custom_2", "blockquote_custom_3", "blockquote_custom_4", "blockquote_custom_5");
	array_push($buttons, "blockquote_custom_1", "blockquote_custom_2", "blockquote_custom_3", "blockquote_custom_4");
	return $buttons;
}
add_filter("mce_buttons", "register_buttons_editor");
// обертка для Table of Contents Plus
add_filter('the_content', 'toc_plus_wrapper', 1000);
function toc_plus_wrapper($content)
{
	global $post;
	$pattern = '/<div id="toc_container" class="no_bullets"><p class="toc_title">(.*?)<\/p>(.*?)<\/div>/i';
	$replacement = '<div id="toc_container" class="no_bullets contents-wraps"><p class="toc_title h3 contents-title">$1</p>$2</div>';
	$content = preg_replace($pattern, $replacement, $content);
	return $content;
}
function first_post_tag_link()
{
	if ($posttags = get_the_category()) {
		$tag = current($posttags);
		printf(
			'<a href="%1$s">%2$s</a>',
			get_category_link($tag->cat_ID),
			esc_html($tag->cat_name)
		);
	}
}
// отключаем стили toc
add_action('wp_print_styles', 'toc_dequeue_header_styles');
function toc_dequeue_header_styles()
{
	wp_dequeue_style('toc-screen');
}
add_action('wp_footer', 'toc_dequeue_footer_styles');
function toc_dequeue_footer_styles()
{
	wp_dequeue_style('toc-screen');
}
// удаляем лишние отступы у изображений с подписью
add_filter('img_caption_shortcode', 'my_img_caption_shortcode', 10, 3);
function my_img_caption_shortcode($empty, $attr, $content)
{
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
function plural_form($number, $before, $after)
{
	$cases = array(2, 0, 1, 1, 1, 2);
	return $before[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)]] . ' ' . $number . ' ' . $after[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)]];
}
/* Подсчет количества посещений страниц
---------------------------------------------------------- */
add_action('wp_head', 'kama_postviews');
function kama_postviews()
{
	/* ------------ Настройки -------------- */
	$meta_key       = 'views';  // Ключ мета поля, куда будет записываться количество просмотров.
	$who_count      = 1;            // Чьи посещения считать? 0 - Всех. 1 - Только гостей. 2 - Только зарегистрированных пользователей.
	$exclude_bots   = 1;            // Исключить ботов, роботов, пауков и прочую нечесть :)? 0 - нет, пусть тоже считаются. 1 - да, исключить из подсчета.

	global $user_ID, $post;
	if (is_singular()) {
		$id = (int)$post->ID;
		static $post_views = false;
		if ($post_views) return true; // чтобы 1 раз за поток
		$post_views = (int)get_post_meta($id, $meta_key, true);
		$should_count = false;
		switch ((int)$who_count) {
			case 0:
				$should_count = true;
				break;
			case 1:
				if ((int)$user_ID == 0)
					$should_count = true;
				break;
			case 2:
				if ((int)$user_ID > 0)
					$should_count = true;
				break;
		}
		if ((int)$exclude_bots == 1 && $should_count) {
			$useragent = $_SERVER['HTTP_USER_AGENT'];
			$notbot = "Mozilla|Opera"; //Chrome|Safari|Firefox|Netscape - все равны Mozilla
			$bot = "Bot/|robot|Slurp/|yahoo"; //Яндекс иногда как Mozilla представляется
			if (!preg_match("/$notbot/i", $useragent) || preg_match("!$bot!i", $useragent))
				$should_count = false;
		}

		if ($should_count)
			if (!update_post_meta($id, $meta_key, ($post_views + 1))) add_post_meta($id, $meta_key, 1, true);
	}
	return true;
}
$colors_fields = array(
	'1' => 'Красный',
	'2' => 'Оранжевый',
	'3' => 'Синий'
);
$custom_field_metabox = array(
	'id' => 'customfield',
	'title' => __('Setting company', 'webnugget'),
	'page' => array('post'),
	'context' => 'normal',
	'priority' => 'default',
	'fields' => array(
		array(
			'name' => __('Phone:', 'webnugget'),
			'desc' => '',
			'id' => 'phone',
			'class' => 'phone',
			'type' => 'text'
		),
		array(
			'name' => __('Adress:', 'webnugget'),
			'desc' => '',
			'id' => 'adress',
			'class' => 'adress',
			'type' => 'text',
			'rich_editor' => 0,
			'max' => 0
		),
		array(
			'name' => __('Site (url):', 'webnugget'),
			'desc' => '',
			'id' => 'site_link',
			'class' => 'site_link',
			'type' => 'text',
			'rich_editor' => 0,
			'max' => 0
		),
		array(
			'name' => __('Site (domain):', 'webnugget'),
			'desc' => '',
			'id' => 'site_name',
			'class' => 'site_name',
			'type' => 'text',
			'rich_editor' => 0,
			'max' => 0
		),
		array(
			'name' => __('Artist description:', 'webnugget'),
			'desc' => '',
			'id' => 'artist_description',
			'class' => 'artist_description',
			'type' => 'text',
			'rich_editor' => 0,
			'max' => 0
		),
		array(
			'name' => __('Google Map:', 'webnugget'),
			'desc' => '',
			'id' => 'googlemap',
			'class' => 'googlemap',
			'type' => 'textarea',
			'rich_editor' => 0,
			'max' => 0
		)
	)
);
add_action('admin_menu', 'add_custom_field_metabox');
function add_custom_field_metabox()
{
	global $custom_field_metabox;
	foreach ($custom_field_metabox['page'] as $page) {
		add_meta_box($custom_field_metabox['id'], $custom_field_metabox['title'], 'show_custom_field_metabox', $page, 'normal', 'default', $custom_field_metabox);
	}
}
function show_custom_field_metabox()
{
	global $post;
	global $custom_field_metabox;
	global $prefix;
	global $wp_version;
	echo '<input type="hidden" name="custom_field_metabox_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	echo '<table class="form-table">';
	foreach ($custom_field_metabox['fields'] as $field) {
		$meta = get_post_meta($post->ID, $field['id'], true);
		echo '<tr>',
		'<th style="width:20%"><label for="', $field['id'], '">', stripslashes($field['name']), '</label></th>',
		'<td class="field_type_' . str_replace(' ', '_', $field['type']) . '">';
		switch ($field['type']) {
			case 'text':
				echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" /><br/>', '', stripslashes($field['desc']);
				break;

			case 'textarea':
				echo wp_editor($meta, $field['id'], array('textarea_name' => $field['id']));
				break;
		}
		echo    '<td>',
		'</tr>';
	}
	echo '</table>';
}
add_action('save_post', 'custom_field_save');
function custom_field_save($post_id)
{
	global $post;
	global $custom_field_metabox;
	if (!wp_verify_nonce($_POST['custom_field_metabox_nonce'], basename(__FILE__))) {
		return $post_id;
	}
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
	foreach ($custom_field_metabox['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old) {
			if ($field['type'] == 'date') {
				$new = format_date($new);
				update_post_meta($post_id, $field['id'], $new);
			} else {
				if (is_string($new)) {
					$new = $new;
				}
				update_post_meta($post_id, $field['id'], $new);
			}
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	}
}
function dimox_breadcrumbs()
{
	/* === ОПЦИИ === */
	$text['home']     = 'Home'; // текст ссылки "Главная"
	$text['category'] = '%s'; // текст для страницы рубрики
	$text['search']   = 'Search results for "%s"'; // текст для страницы с результатами поиска
	$text['tag']      = 'Posts with tag "%s"'; // текст для страницы тега
	$text['author']   = 'About author:'; // текст для страницы автора
	$text['404']      = 'Error 404'; // текст для страницы 404
	$text['page']     = 'Page %s'; // текст 'Страница N'
	$text['cpage']    = 'Comments page %s'; // текст 'Страница комментариев N'
	$wrap_before    = '<div class="brs" itemscope itemtype="http://schema.org/BreadcrumbList">'; // открывающий тег обертки
	$wrap_after     = '</div>'; // закрывающий тег обертки
	$sep            = '<span class="breadcrumbs__separator"> › </span>'; // разделитель между "крошками"
	$before         = '<span class="breadcrumbs__current">'; // тег перед текущей "крошкой"
	$after          = '</span>'; // тег после текущей "крошки"
	$show_on_home   = 0; // 1 - показывать "хлебные крошки" на главной странице, 0 - не показывать
	$show_home_link = 1; // 1 - показывать ссылку "Главная", 0 - не показывать
	$show_current   = 0; // 1 - показывать название текущей страницы, 0 - не показывать
	$show_last_sep  = 0; // 1 - показывать последний разделитель, когда название текущей страницы не отображается, 0 - не показывать
	/* === КОНЕЦ ОПЦИЙ === */
	global $post;
	$home_url       = home_url('/');
	$link           = '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
	$link          .= '<a class="breadcrumbs__link" href="%1$s" itemprop="item"><span itemprop="name">%2$s</span></a>';
	$link          .= '<meta itemprop="position" content="%3$s" />';
	$link          .= '</span>';
	$parent_id      = ($post) ? $post->post_parent : '';
	$home_link      = sprintf($link, $home_url, $text['home'], 1);
	if (is_home() || is_front_page()) {
		if ($show_on_home) echo $wrap_before . $home_link . $wrap_after;
	} else {
		$position = 0;
		echo $wrap_before;
		if ($show_home_link) {
			$position += 1;
			echo $home_link;
		}
		if (is_category()) {
			$parents = get_ancestors(get_query_var('cat'), 'category');
			foreach (array_reverse($parents) as $cat) {
				$position += 1;
				if ($position > 1) echo $sep;
				echo sprintf($link, get_category_link($cat), get_cat_name($cat), $position);
			}
			if (get_query_var('paged')) {
				$position += 1;
				$cat = get_query_var('cat');
				echo $sep . sprintf($link, get_category_link($cat), get_cat_name($cat), $position);
				echo $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
			} else {
				if ($show_current) {
					if ($position >= 1) echo $sep;
					echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;
				} elseif ($show_last_sep) echo $sep;
			}
		} elseif (is_search()) {
			if (get_query_var('paged')) {
				$position += 1;
				if ($show_home_link) echo $sep;
				echo sprintf($link, $home_url . '?s=' . get_search_query(), sprintf($text['search'], get_search_query()), $position);
				echo $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
			} else {
				if ($show_current) {
					if ($position >= 1) echo $sep;
					echo $before . sprintf($text['search'], get_search_query()) . $after;
				} elseif ($show_last_sep) echo $sep;
			}
		} elseif (is_year()) {
			if ($show_home_link && $show_current) echo $sep;
			if ($show_current) echo $before . get_the_time('Y') . $after;
			elseif ($show_home_link && $show_last_sep) echo $sep;
		} elseif (is_month()) {
			if ($show_home_link) echo $sep;
			$position += 1;
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y'), $position);
			if ($show_current) echo $sep . $before . get_the_time('F') . $after;
			elseif ($show_last_sep) echo $sep;
		} elseif (is_day()) {
			if ($show_home_link) echo $sep;
			$position += 1;
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y'), $position) . $sep;
			$position += 1;
			echo sprintf($link, get_month_link(get_the_time('Y'), get_the_time('m')), get_the_time('F'), $position);
			if ($show_current) echo $sep . $before . get_the_time('d') . $after;
			elseif ($show_last_sep) echo $sep;
		} elseif (is_single() && !is_attachment()) {
			if (get_post_type() != 'post') {
				$position += 1;
				$post_type = get_post_type_object(get_post_type());
				if ($position > 1) echo $sep;
				echo sprintf($link, get_post_type_archive_link($post_type->name), $post_type->labels->name, $position);
				if ($show_current) echo $sep . $before . get_the_title() . $after;
				elseif ($show_last_sep) echo $sep;
			} else {
				$cat = get_the_category();
				$catID = $cat[0]->cat_ID;
				$parents = get_ancestors($catID, 'category');
				$parents = array_reverse($parents);
				$parents[] = $catID;
				foreach ($parents as $cat) {
					$position += 1;
					if ($position > 1) echo $sep;
					echo sprintf($link, get_category_link($cat), get_cat_name($cat), $position);
				}
				if (get_query_var('cpage')) {
					$position += 1;
					echo $sep . sprintf($link, get_permalink(), get_the_title(), $position);
					echo $sep . $before . sprintf($text['cpage'], get_query_var('cpage')) . $after;
				} else {
					if ($show_current) echo $sep . $before . get_the_title() . $after;
					elseif ($show_last_sep) echo $sep;
				}
			}
		} elseif (is_post_type_archive()) {
			$post_type = get_post_type_object(get_post_type());
			if (get_query_var('paged')) {
				$position += 1;
				if ($position > 1) echo $sep;
				echo sprintf($link, get_post_type_archive_link($post_type->name), $post_type->label, $position);
				echo $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
			} else {
				if ($show_home_link && $show_current) echo $sep;
				if ($show_current) echo $before . $post_type->label . $after;
				elseif ($show_home_link && $show_last_sep) echo $sep;
			}
		} elseif (is_attachment()) {
			$parent = get_post($parent_id);
			$cat = get_the_category($parent->ID);
			$catID = $cat[0]->cat_ID;
			$parents = get_ancestors($catID, 'category');
			$parents = array_reverse($parents);
			$parents[] = $catID;
			foreach ($parents as $cat) {
				$position += 1;
				if ($position > 1) echo $sep;
				echo sprintf($link, get_category_link($cat), get_cat_name($cat), $position);
			}
			$position += 1;
			echo $sep . sprintf($link, get_permalink($parent), $parent->post_title, $position);
			if ($show_current) echo $sep . $before . get_the_title() . $after;
			elseif ($show_last_sep) echo $sep;
		} elseif (is_page() && !$parent_id) {
			if ($show_home_link && $show_current) echo $sep;
			if ($show_current) echo $before . get_the_title() . $after;
			elseif ($show_home_link && $show_last_sep) echo $sep;
		} elseif (is_page() && $parent_id) {
			$parents = get_post_ancestors(get_the_ID());
			foreach (array_reverse($parents) as $pageID) {
				$position += 1;
				if ($position > 1) echo $sep;
				echo sprintf($link, get_page_link($pageID), get_the_title($pageID), $position);
			}
			if ($show_current) echo $sep . $before . get_the_title() . $after;
			elseif ($show_last_sep) echo $sep;
		} elseif (is_tag()) {
			if (get_query_var('paged')) {
				$position += 1;
				$tagID = get_query_var('tag_id');
				echo $sep . sprintf($link, get_tag_link($tagID), single_tag_title('', false), $position);
				echo $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
			} else {
				if ($show_home_link && $show_current) echo $sep;
				if ($show_current) echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;
				elseif ($show_home_link && $show_last_sep) echo $sep;
			}
		} elseif (is_author()) {
			$author = get_userdata(get_query_var('author'));
			if (get_query_var('paged')) {
				$position += 1;
				echo $sep . sprintf($link, get_author_posts_url($author->ID), sprintf($text['author'], $author->display_name), $position);
				echo $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
			} else {
				echo $sep . '<span class="w-500 c-black">' . $text['author'] . '</span>';
				if ($show_home_link && $show_current) echo $sep;
				if ($show_current) echo $before . sprintf($text['author'], $author->display_name) . $after;
				elseif ($show_home_link && $show_last_sep) echo $sep;
			}
		} elseif (is_404()) {
			if ($show_home_link && $show_current) echo $sep;
			if ($show_current) echo $before . $text['404'] . $after;
			elseif ($show_last_sep) echo $sep;
		} elseif (has_post_format() && !is_singular()) {
			if ($show_home_link && $show_current) echo $sep;
			echo get_post_format_string(get_post_format());
		}
		echo $wrap_after;
	}
} // end of dimox_breadcrumbs()
//allow html in widget title
add_filter('widget_title', 'do_shortcode');
function lxb_change_widget_title($title)
{
	//convert square brackets to angle brackets
	$title = str_replace('[', '<', $title);
	$title = str_replace(']', '>', $title);

	//strip tags other than the allowed set
	$title = strip_tags($title, '<a><blink><br><span>');
	return $title;
}
function theme_comments($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
?>
	<li id="li-comment-<?php comment_ID(); ?>">
		<!-- <div class="wrapComm" id="comment-<?php // comment_ID(); ?>"> -->
		<div class="comment" id="comment-<?php comment_ID(); ?>">
			<div class="comment__picture">
				<?php echo get_avatar($comment, 60); ?>
			</div>
			<div class="comment__body">
				<div class="comment__user-name">
					<p class="text w-600"><?php comment_author(); ?></p>
				</div>
				<div class="comment__date">
					<h5 class="h5 c-gray"><?php comment_date(); ?></h5>
				</div>
				<div class="comment__text">
					<?php if ($comment->comment_approved == '0') : ?>
						<p class="comment__message text">Your comment has been sent for moderation.</p>
					<?php endif; ?>
					<?php comment_text(); ?>
				</div>
				<div class="comment__navigation">
					<?php printf('<span class="comment__reply replyform comment-reply-link" onclick="return addComment.moveForm(\'comment-%s\', \'%s\', \'respond\', \'%s\')">Reply</span>', $comment->comment_ID, $comment->comment_ID, $comment->comment_post_ID); ?>
				</div>
			</div>
		</div>
		<?php
	}
	function kama_excerpt($args = '')
	{
		global $post;

		$default = array(
			'maxchar'   => 350,   // количество символов.
			'text'      => '',    // какой текст обрезать (по умолчанию post_excerpt, если нет post_content.
			// Если есть тег <!--more-->, то maxchar игнорируется и берется все до <!--more--> вместе с HTML
			'autop'     => true,  // Заменить переносы строк на <p> и <br> или нет
			'save_tags' => '',    // Теги, которые нужно оставить в тексте, например '<strong><b><a>'
			'more_text' => '', // текст ссылки читать дальше
		);

		if (is_array($args)) $_args = $args;
		else                  parse_str($args, $_args);

		$rg = (object) array_merge($default, $_args);
		if (!$rg->text) $rg->text = $post->post_excerpt ?: $post->post_content;
		$rg = apply_filters('kama_excerpt_args', $rg);

		$text = $rg->text;
		$text = preg_replace('~\[/?.*?\](?!\()~', '', $text); // убираем шоткоды, например:[singlepic id=3], markdown +
		$text = trim($text);

		// <!--more-->
		if (strpos($text, '<!--more-->')) {
			preg_match('/(.*)<!--more-->/s', $text, $mm);

			$text = trim($mm[1]);

			$text_append = ' <a href="' . get_permalink($post->ID) . '#more-' . $post->ID . '">' . $rg->more_text . '</a>';
		}
		// text, excerpt, content
		else {
			$text = trim(strip_tags($text, $rg->save_tags));

			// Обрезаем
			if (mb_strlen($text) > $rg->maxchar) {
				$text = mb_substr($text, 0, $rg->maxchar);
				$text = preg_replace('~(.*)\s[^\s]*$~s', '\\1 ...', $text); // убираем последнее слово, оно 99% неполное
			}
		}

		// Сохраняем переносы строк. Упрощенный аналог wpautop()
		if ($rg->autop) {
			$text = preg_replace(
				array("~\r~", "~\n{2,}~", "~\n~",   '~</p><br ?/>~'),
				array('',     '</p><p>',  '<br />', '</p>'),
				$text
			);
		}

		$text = apply_filters('kama_excerpt', $text, $rg);

		if (isset($text_append)) $text .= $text_append;

		return ($rg->autop && $text) ? "<p>$text</p>" : $text;
	}
	function true_load_posts()
	{
		$args = unserialize(stripslashes($_POST['query']));
		$args['paged'] = $_POST['page'] + 1; // следующая страница
		$args['post_type'] = 'post';
		$args['post_status'] = 'publish';

		// обычно лучше использовать WP_Query, но не здесь
		query_posts($args);
		// если посты есть
		if (have_posts()) :

			// запускаем цикл
			while (have_posts()) : the_post();
				$is++; ?>
	<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php endwhile;

		endif;
		die();
	}
	add_action('wp_ajax_loadmore', 'true_load_posts');
	add_action('wp_ajax_nopriv_loadmore', 'true_load_posts');
?>