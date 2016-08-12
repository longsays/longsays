<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title('-', true, 'right'); echo get_option('blogname'); if (is_home ()) echo "-", get_option('blogdescription'); if ($paged > 1) echo '-Page ', $paged; ?></title>
<?php wp_head(); ?>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" media="all" />
</head>
<body <?php body_class(); ?>>
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