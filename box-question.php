<?php
$goplyak_settings = get_option('goplyak_settings');

if (!is_home()) {

?>
	<div style="height: 350px;">
		<div align="center" style="margin-bottom:20px; position: sticky; top: 0;" data-freestar-ad="__336x280" id="hadvisecom_category_right_rail_1">
			<script data-cfasync="false" type="text/javascript">
				freestar.config.enabled_slots.push({
					placementName: "hadvisecom_category_right_rail_1",
					slotId: "hadvisecom_category_right_rail_1"
				});
			</script>
		</div>
	</div>
<?php

}

?>
<div class="add-questions__box redisign">
	<div class="add-questions__title h3 w-700">Have a question?</div>
	<div class="add-questions__desc h4">Get all of your hair questions answered by our experts! It's FREE!</div>
	<div class="add-questions__button text-small text-uppercase button-white">
		<a href="<?php echo get_category_link(options_theme('home_2_cat')); ?>" class="button text-small">Add question</a>
	</div>
</div>