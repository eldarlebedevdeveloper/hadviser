<?php
//настройки темы
function load_admin_assetswidgets()
{
	wp_register_script('jquery.multi-select.js', get_template_directory_uri() . '/js/jquery.multi-select.js', array('jquery'));
	wp_enqueue_script('jquery.multi-select.js');
	wp_register_script('editor-select.js', get_template_directory_uri() . '/js/editor.js?1.5', array('jquery'));
	wp_enqueue_script('editor-select.js');
	wp_register_style('wpeditor-widget-css', get_template_directory_uri() . '/css/multi-select.css?1.1', array());
	wp_enqueue_style('wpeditor-widget-css');
}
add_action('admin_enqueue_scripts', 'load_admin_assetswidgets');
class SettingsTheme
{
	private $settings = array();
	private $default_settings = array();
	public function __construct()
	{
		$this->loadSettings();
		$this->get_settings();
		$this->resultSettings();
		add_action('admin_menu', array($this, 'setup_theme_admin_menus'));
	}
	private function loadSettings()
	{
		$this->settings = get_option('goplyak_settings');
	}
	public function get_settings()
	{
		if (!isset($_POST['ss_action'])) {
			$_POST['ss_action'] = '';
		}
		if ($_POST['ss_action'] == 'save') {
			$this->settings["pinterest"] = stripslashes($_POST['pinterest']);
			$this->settings["fb"] = stripslashes($_POST['fb']);
			$this->settings["insta"] = stripslashes($_POST['insta']);
			$this->settings["twitter"] = stripslashes($_POST['twitter']);
			$this->settings["footer_desc_1"] = stripslashes($_POST['footer_desc_1']);
			$this->settings["li"] = stripslashes($_POST['li']);
			$this->settings["title_home_1"] = esc_sql($_POST['title_home_1']);
			$this->settings["title_home_2"] = esc_sql($_POST['title_home_2']);
			$this->settings["title_home_3"] = esc_sql($_POST['title_home_3']);
			$this->settings["title_home_4"] = esc_sql($_POST['title_home_4']);
			$this->settings["title_home_5"] = esc_sql($_POST['title_home_5']);
			$this->settings["title_home_5_1"] = esc_sql($_POST['title_home_5_1']);
			$this->settings["title_home_6"] = esc_sql($_POST['title_home_6']);
			$this->settings["home_1_cat"] = esc_sql($_POST['home_1_cat']);
			$this->settings["home_2_cat"] = esc_sql($_POST['home_2_cat']);
			$this->settings["home_3_cat"] = esc_sql($_POST['home_3_cat']);
			$this->settings["home_4_cat"] = esc_sql($_POST['home_4_cat']);
			$this->settings["home_5_cat"] = esc_sql($_POST['home_5_cat']);
			$this->settings["home_5_1_cat"] = esc_sql($_POST['home_5_1_cat']);
			$this->settings["home_6_cat"] = esc_sql($_POST['home_6_cat']);
			update_option('goplyak_settings', $this->settings);
		}
	}
	private function resultSettings()
	{
		if (!isset($_POST['ss_action'])) {
			$_POST['ss_action'] = '';
		}
		if ($_POST['ss_action'] == 'save') {
			return '<div class="update-nag" style="width: 90%;display: block;">Настройки <strong>сохранены</strong>.</div>';
		}
	}
	public function setup_theme_admin_menus()
	{
		add_menu_page("Settings Theme", "Settings Theme", "manage_options", "setting-wp", array($this, "settings_html"), "dashicons-laptop", "6");
	}
	public function settings_html()
	{
?>
		<form action="" method="post" id="themeform">
			<fieldset>
				<input type="hidden" id="ss_action" name="ss_action" value="save">
				<h1 class="nav-tab-wrapper" id="goplyak-tabs">
					<a class="nav-tab nav-tab-active" href="#tab1">Main settings</a>
					<a class="nav-tab" href="#tab3">Main page</a>
				</h1>
				<?php echo $this->resultSettings(); ?>
				<div id="tab1" class="goplyaktab active-tabs">
					<h3>Socials links</h3>
					<hr>
					<table class="form-table">
						<tbody>
							<tr>
								<th><label for="pinterest">Pinterest</label></th>
								<td>
									<input type="text" id="pinterest" name="pinterest" value="<?php echo $this->settings['pinterest']; ?>" class="regular-text">
								</td>
							</tr>
							<tr>
								<th><label for="brs_home">Facebook</label></th>
								<td>
									<input type="text" id="fb" name="fb" value="<?php echo $this->settings['fb']; ?>" class="regular-text">
								</td>
							</tr>
							<tr>
								<th><label for="brs_home">Instagram</label></th>
								<td>
									<input type="text" id="insta" name="insta" value="<?php echo $this->settings['insta']; ?>" class="regular-text">
								</td>
							</tr>
							<tr>
								<th><label for="brs_home">Twitter</label></th>
								<td>
									<input type="text" id="twitter" name="twitter" value="<?php echo $this->settings['twitter']; ?>" class="regular-text">
								</td>
							</tr>
							<tr>
								<th><label for="brs_home">LinkedIn</label></th>
								<td>
									<input type="text" id="linkedin" name="linkedin" value="<?php echo $this->settings['linkedin']; ?>" class="regular-text">
								</td>
							</tr>
							<tr>
								<th><label for="brs_home">Medium</label></th>
								<td>
									<input type="text" id="medium" name="medium" value="<?php echo $this->settings['medium']; ?>" class="regular-text">
								</td>
							</tr>
						</tbody>
					</table>
					<h3>Footer site</h3>
					<hr>
					<table class="form-table">
						<tbody>
							<tr>
								<th><label for="footer_desc_1">Copyright description</label></th>
								<td>
									<textarea class="large-text code" rows="7" id="footer_desc_1" name="footer_desc_1"><?php echo $this->settings['footer_desc_1']; ?></textarea>
								</td>
							</tr>
							<tr>
								<th><label for="footer_desc_2">Statistics counters</label></th>
								<td>
									<textarea class="large-text code" rows="7" id="li" name="li"><?php echo $this->settings['li']; ?></textarea>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div id="tab3" class="goplyaktab">
					<h3>Most popular</h3>
					<hr>
					<table class="form-table">
						<tbody>
							<tr>
								<th><label for="history_title">Title section</label></th>
								<td>
									<input type="text" id="title_home_1" name="title_home_1" value="<?php echo $this->settings['title_home_1']; ?>" class="regular-text">
								</td>
							</tr>
							<tr>
								<th><label for="history_count">Exclude categories</label></th>
								<td>
									<div class="multiSelect">
										<?php
										$categories = get_categories('hide_empty=0');
										$home_1_cat = isset($this->settings['home_1_cat']) ? $this->settings['home_1_cat'] : '';
										echo '<select multiple="multiple" name="home_1_cat[]" id="home_1_cat" class="widefat" size="55">';
										foreach ($categories as $cat) {
											printf(
												'<option value="%s" class="hot-topic" %s>%s</option>',
												$cat->term_id,
												in_array($cat->term_id, $home_1_cat) ? 'selected="selected"' : '',
												$cat->name
											);
										}
										echo '</select>'; ?>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
					<h3>Yours questions</h3>
					<hr>
					<table class="form-table">
						<tbody>
							<tr>
								<th><label for="history_title">Title section</label></th>
								<td>
									<input type="text" id="title_home_2" name="title_home_2" value="<?php echo $this->settings['title_home_2']; ?>" class="regular-text">
								</td>
							</tr>
							<tr>
								<th><label for="history_count">Category</label></th>
								<td>
									<?php wp_dropdown_categories(array('id' => 'home_2_cat', 'name' => 'home_2_cat', 'hierarchical' => 1, 'hide_empty' => 0, 'selected' => $this->settings['home_2_cat'])); ?>
								</td>
							</tr>
						</tbody>
					</table>
					<h3>Random article</h3>
					<hr>
					<table class="form-table">
						<tbody>
							<tr>
								<th><label for="history_count">Exclude categories</label></th>
								<td>
									<div class="multiSelect">
										<?php
										$categories = get_categories('hide_empty=0');
										$home_3_cat = isset($this->settings['home_3_cat']) ? $this->settings['home_3_cat'] : '';
										echo '<select multiple="multiple" name="home_3_cat[]" id="home_3_cat" class="widefat" size="55">';
										foreach ($categories as $cat) {
											printf(
												'<option value="%s" class="hot-topic" %s>%s</option>',
												$cat->term_id,
												in_array($cat->term_id, $home_3_cat) ? 'selected="selected"' : '',
												$cat->name
											);
										}
										echo '</select>'; ?>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
					<h3>Now discuss</h3>
					<hr>
					<table class="form-table">
						<tbody>
							<tr>
								<th><label for="history_title">Title section</label></th>
								<td>
									<input type="text" id="title_home_4" name="title_home_4" value="<?php echo $this->settings['title_home_4']; ?>" class="regular-text">
								</td>
							</tr>
						</tbody>
					</table>
					<h3>Best company</h3>
					<hr>
					<table class="form-table">
						<tbody>
							<tr>
								<th><label for="history_title">Title section</label></th>
								<td>
									<input type="text" id="title_home_5" name="title_home_5" value="<?php echo $this->settings['title_home_5']; ?>" class="regular-text">
								</td>
							</tr>
							<tr>
								<th><label for="history_count">Category</label></th>
								<td>
									<?php wp_dropdown_categories(array('id' => 'home_5_cat', 'name' => 'home_5_cat', 'hierarchical' => 1, 'hide_empty' => 0, 'selected' => $this->settings['home_5_cat'])); ?>
								</td>
							</tr>
						</tbody>
					</table>
					<h3>Salons</h3>
					<hr>
					<table class="form-table">
						<tbody>
							<tr>
								<th><label for="history_title">Title section</label></th>
								<td>
									<input type="text" id="title_home_5_1" name="title_home_5_1" value="<?php echo $this->settings['title_home_5_1']; ?>" class="regular-text">
								</td>
							</tr>
							<tr>
								<th><label for="history_count">Category</label></th>
								<td>
									<?php wp_dropdown_categories(array('id' => 'home_5_cat', 'name' => 'home_5_1_cat', 'hierarchical' => 1, 'hide_empty' => 0, 'selected' => $this->settings['home_5_1_cat'])); ?>
								</td>
							</tr>
						</tbody>
					</table>
					<h3>New articles</h3>
					<hr>
					<table class="form-table">
						<tbody>
							<tr>
								<th><label for="history_title">Title section</label></th>
								<td>
									<input type="text" id="title_home_6" name="title_home_6" value="<?php echo $this->settings['title_home_6']; ?>" class="regular-text">
								</td>
							</tr>
							<tr>
								<th><label for="history_count">Exclude categories</label></th>
								<td>
									<div class="multiSelect">
										<?php
										$categories = get_categories('hide_empty=0');
										$home_6_cat = isset($this->settings['home_6_cat']) ? $this->settings['home_6_cat'] : '';
										echo '<select multiple="multiple" name="home_6_cat[]" id="home_6_cat" class="widefat" size="55">';
										foreach ($categories as $cat) {
											printf(
												'<option value="%s" class="hot-topic" %s>%s</option>',
												$cat->term_id,
												in_array($cat->term_id, $home_6_cat) ? 'selected="selected"' : '',
												$cat->name
											);
										}
										echo '</select>'; ?>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<p class="submit">
					<input type="submit" value="Save settings &raquo;" class="button button-primary" />
				</p>
			</fieldset>
		</form>
<?php  }
}
$cpanel_tlteam = new SettingsTheme();
$goplyak_settings = get_option('goplyak_settings');
function php_execute($html)
{
	if (strpos($html, "<" . "?php") !== false) {
		ob_start();
		eval("?" . ">" . $html);
		$html = ob_get_contents();
		ob_end_clean();
	}
	return $html;
}
function options_theme($namefield)
{
	global $goplyak_settings;
	$options = do_shortcode(php_execute($goplyak_settings[$namefield]));
	return $options;
}


// Allow to adding HTML to Biografic Info in the User 
remove_filter('pre_user_description', 'wp_filter_kses');
add_filter('pre_user_description', 'wp_filter_post_kses');


?>