<?phpadd_action( 'category_add_form_fields', 'category_form_custom_field_add', 10 );
add_action( 'category_edit_form_fields', 'category_form_custom_field_edit', 10, 2 );
function category_form_custom_field_add( $taxonomy ) {
?>
<div class="form-field custom-img-tpl">
	<label for="img_upload">Template</label>
	<select id="cattpl" name="cattpl">		<option value="1">Default</option>		<option value="2">Catalog</option>		<option value="3">Questions</option>	</select>
	<p>Загрузите картинку для категории.</p>
</div>
<?php
}
function category_form_custom_field_edit( $tag, $taxonomy ) {
	$cat_id = $tag->term_id;
	$cattpl = get_option("cattpl_$cat_id");
?>
<table class="form-table">
        <tr class="form-field">
            <th scope="row" valign="top"><label for="img_upload">Template</label></th>
            <td class="custom-img-upload">	<select id="cattpl" name="cattpl">		<option value="1"<?php if($cattpl==1){echo ' selected';} ?>>Default</option>		<option value="2"<?php if($cattpl==2){echo ' selected';} ?>>Catalog</option>		<option value="3"<?php if($cattpl==3){echo ' selected';} ?>>Questions</option>	</select>
			</td>
        </tr>        <tr class="form-field">            <th scope="row" valign="top"><label for="img_upload">Users in Questions</label></th>            <td>				<div class="multiSelect">				<?php					$users = get_users(array('number'=> -1));					$c_users = get_option("users_$cat_id");					echo '<select multiple="multiple" name="users[]" id="users" class="widefat" size="55">';					foreach($users as $cat )					{						printf(							'<option value="%s" class="hot-topic" %s>%s</option>',							$cat->ID,							in_array($cat->ID, $c_users) ? 'selected="selected"' : '',							$cat->display_name						);					}					echo '</select>'; ?>				</div>			</td>        </tr>
</table>
<?php
}
function add_category_template($cat_id) {
	if (isset($_POST['cattpl'] )) {
		$cattpl = $_POST['cattpl'];
		add_option("cattpl_$cat_id", $cattpl);
	}	add_option("users_$cat_id", "");}
function edit_category_template($cat_id) {
	if (isset($_POST['cattpl'] )) {
		$cattpl = $_POST['cattpl'];
		update_option("cattpl_$cat_id", $cattpl);
	}	if (isset($_POST['users'] )) {		$users = $_POST['users'];		update_option("users_$cat_id", $users);	}
}
function delete_category_template($cat_id) {
		delete_option("cattpl_$cat_id");		delete_option("users_$cat_id");
}add_action('create_category', 'add_category_template', 1);add_action('edit_category', 'edit_category_template', 1);add_action('delete_category', 'delete_category_template', 1);
?>