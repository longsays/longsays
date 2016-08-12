<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8" />
<meta http-equiv="x-dns-prefetch-control" content="on" />
<link rel="dns-prefetch" href="//cdn.longsays.com" />
<link rel="dns-prefetch" href="//longsays.b0.upaiyun.com" />
<link rel="dns-prefetch" href="//s06.flagcounter.com" />
<link rel="dns-prefetch" href="//static.googleadsserving.cn" />
<link rel="dns-prefetch" href="//lu.sogou.com" />
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Cache-Control" content="no-transform " />
<link rel="author" href="https://plus.google.com/108270394069994455147?rel=author" />
<title><?php wp_title('-', true, 'right'); echo get_option('blogname'); if (is_home ()) echo "-", get_option('blogdescription'); if ($paged > 1) echo '-Page ', $paged; ?></title>
<link rel="stylesheet" href="http://longsays.b0.upaiyun.com/css/style.css" media="all" />
<link rel="stylesheet" href="http://longsays.b0.upaiyun.com/css/love.sas.sky.css" type='text/css' />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="harmony">
<div class="topbar">
	<div class="inner">
		<?php if( is_home() ) echo '<h1 class="logo"><a'; else echo '<a class="logo"'; ?> href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?> - <?php bloginfo('description'); ?>"><?php bloginfo('name'); ?></a><?php if( is_home() ) echo '</h1>'; echo "\n"; ?>
		<ul class="nav">
			<?php echo str_replace("</ul></div>", "", ereg_replace("<div[^>]*><ul[^>]*>", "", wp_nav_menu(array('theme_location' => 'nav', 'echo' => false)) )); ?>
		</ul>
		<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" >
			<input type="text" x-webkit-speech onfocus="if (this.value == '回车搜索 直接有效') {this.value = '';}" onblur="if (this.value == '') {this.value = '回车搜索 直接有效';}" value="回车搜索 直接有效" name="s" class="search-input" />
		</form>
		<ul class="nav topmenu">
			<?php echo str_replace("</ul></div>", "", ereg_replace("<div[^>]*><ul[^>]*>", "", wp_nav_menu(array('theme_location' => 'menu', 'echo' => false)) )); ?>
		</ul>
	</div>
</div>
<div class="wrapper">
	<div class="content">