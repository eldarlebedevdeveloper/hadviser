<span class="arrowTop"></span>

<footer class="footer">
	<div class="footer__container container"> 
		<div class="footer__content">
			<div class="logo">  
				<a href="/" class="logo__link">
					<img src="<?php echo get_template_directory_uri(); ?>/i/images/logo.svg" alt="">
				</a>
			</div>
			<p class="footer__description text">Hair Advice at Your Fingertips!</p>
			<div class="social-icons">
				<?php if(options_theme('pinterest')){ ?>
				<a href="<?php echo options_theme('pinterest'); ?>" class="social-icons__item" target="_blank">
					<img src="<?php echo get_template_directory_uri() ?>/i/icons/header-social-pinterest.svg" alt="">
				</a> 
				<?php } ?>
				<?php if(options_theme('fb')){ ?>
				<a href="<?php echo options_theme('fb'); ?>" class="social-icons__item" target="_blank">
					<img src="<?php echo get_template_directory_uri() ?>/i/icons/header-social-facebook.svg" alt="">
				</a>
				<?php } ?>
				<?php if(options_theme('insta')){ ?>
				<a href="<?php echo options_theme('insta'); ?>" class="social-icons__item" target="_blank">
					<img src="<?php echo get_template_directory_uri() ?>/i/icons/header-social-instagram.svg" alt="">
				</a>
				<?php } ?>
			</div> 
		</div> 
		<nav class="footer__navigation">
			<?php wp_nav_menu( array('menu_class' => 'footer__navigation-items','theme_location' => 'footerbig' ) ); ?>
		</nav>
		<div class="footer__rights">
			<p class="text">© Copyright 2024 All Rights Reserved</p>
		</div>
	</div>
</footer>


<?php echo options_theme('li'); ?>
<div class="popUp-box form-result">
	<div class="wrapbody-popup">
		<span class="close-popUp"></span>
		<div class="text-reluts post">
			<p>Thanks!</p>
		</div>
	</div>
	<div class="bg-fix"></div>
</div>
<!--[if IE]>
<script src="<?php bloginfo('template_directory'); ?>/js/html5shiv.js"></script>
<![endif]-->
<script defer="defer" src="<?php bloginfo('template_directory'); ?>/js/jquery.slicknav.min.js"></script>
	<script>
	var ajaxUrl = '<?php echo site_url() ?>/wp-admin/admin-ajax.php';
	var id_post = '<?php global $post; echo $post->ID;?>';
	</script>
<script defer="defer" src="<?php bloginfo('template_directory'); ?>/js/scripts.js?<?=time()?>"></script>
<?php wp_footer(); ?>
</body>
</html>