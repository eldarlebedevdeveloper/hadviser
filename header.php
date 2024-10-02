<!DOCTYPE html>
<!--[if IE 7 ]><html class="ie7"> <![endif]-->
<!--[if IE 8 ]><html class="ie8"> <![endif]-->
<!--[if IE 9 ]><html class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html> <!--<![endif]-->
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php wp_head(); ?>
<script type="text/javascript">
  var _paq = window._paq = window._paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var matomoUrl="//stats.hadviser.com/";
    var cdnUrl="//www.hadviser.com/";
    _paq.push(['setTrackerUrl', matomoUrl+'matomo.php']);
    _paq.push(['setSiteId', '1']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.src=cdnUrl+'matomo.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-132279247-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-132279247-1');
</script>
<?php
if(!is_single(18722)){
  echo '<script src="https://cdn.p-n.io/pushly-sdk.min.js?domain_key=SYOFTPBIOs7A1JVtaAEgXpCxRfiKjoFwVLar" async></script>
<script>
  window.PushlySDK = window.PushlySDK || [];
  function pushly() { window.PushlySDK.push(arguments) }
  pushly("load", {
    domainKey: "SYOFTPBIOs7A1JVtaAEgXpCxRfiKjoFwVLar",
  });
</script>';
} else {
  echo '<script src="https://cdn.p-n.io/pushly-sdk.min.js?domain_key=SYOFTPBIOs7A1JVtaAEgXpCxRfiKjoFwVLar" async></script>
<script>
  window.PushlySDK = window.PushlySDK || [];
  function pushly() { window.PushlySDK.push(arguments) }
  pushly("load", {
    domainKey: "SYOFTPBIOs7A1JVtaAEgXpCxRfiKjoFwVLar",
  });
</script>';
}
?>

<link rel="shortcut icon" type="image/ico" href="<?php bloginfo('template_directory'); ?>/i/favicon.ico">
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/style.css?<?=time()?>" />

<!-- Swiper slider -->
<!-- <link rel="stylesheet" href="<?php // bloginfo('template_directory'); ?>/assets/libs/swiper-bundle.min.css"/>
<script src="<?php //bloginfo('template_directory'); ?>/assets/libs/swiper-bundle.min.js"></script> -->
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
/>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


 
</head>
<body<?php if(!is_front_page()){ ?> class="vn-page<?php } ?><?php if(function_exists("body_class_1")){body_class_1();}?>>
<?php do_action('hook_before_body'); ?>

<!-- <div align="center" data-freestar-ad="__320x50" id="hadvisecom_pushdown-pushdown-cls"></div> -->

<header class="header">
  <div class="container header__container">
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
    <div class="logo">
      <a href="/" class="logo__link">
        <img src="<?php echo get_template_directory_uri(); ?>/i/images/logo.svg" alt="">
      </a>
    </div>
    <?php echo get_search_form(); ?>
    <div class="header__search-form-toggle">
        <img class="header__search-form-open" src="<?php echo get_template_directory_uri(); ?>/i/icons/search-form-open.svg" alt="">
        <img class="header__search-form-close none" src="<?php echo get_template_directory_uri(); ?>/i/icons/mobile-menu-close.svg" alt="">
    </div>
    <div class="header__mobile-menu-toggle">
        <img class="header__mobile-menu-open" src="<?php echo get_template_directory_uri(); ?>/i/icons/mobile-menu-open.svg" alt="" >
        <img class="header__mobile-menu-close none" src="<?php echo get_template_directory_uri(); ?>/i/icons/mobile-menu-close.svg" alt="">
    </div>
  </div>
	<nav class="header__navigation navigation-menu">  
		<div class="container">
			<?php wp_nav_menu(array('menu_class' => 'navigation-menu__items','theme_location' => 'topmenu' )); ?>
		
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
  
	</nav>
</header>