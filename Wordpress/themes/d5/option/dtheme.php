<?php

$themename = $danme.'主题';

$options = array (

	//基本设置
	array( "name" => "基本设置","type" => "section","desc" => "主题的基本设置，包括模块是否开启等"),

	array( "name" => "升级/维护提醒","type" => "tit" ),	
	array( "id" => "d_onlytip_b","type" => "checkbox" ),
	array( "id" => "d_onlytip","type" => "text","std" => "友情提示：本站升级维护中，如给您带来不便，还望谅解！" ),
	
	array( "name" => "网站描述","type" => "tit"),
	array( "id" => "d_description","type" => "text","std" => "输入你的网站描述，一般不超过200个字符"),
	
	array( "name" => "网站关键字","type" => "tit"),	
	array( "id" => "d_keywords","type" => "text","std" => "输入你的网站关键字，一般不超过100个字符。 关键字之间用 ',' 隔开"),
	
	array( "name" => "RSS订阅地址","type" => "tit"),
	array( "id" => "d_rss","type" => "text","class" => "d_inp_short","std" => "www.daqianduan.com/feed"),

	array( "name" => "腾讯微博","type" => "tit"),
	array( "id" => "d_tqq","type" => "text","class" => "d_inp_short","std" => "t.qq.com/daqianduan"),

	array( "name" => "新浪微博","type" => "tit"),
	array( "id" => "d_weibo","type" => "text","class" => "d_inp_short","std" => "weibo.com/daqianduan"),
	
	array( "name" => "流量统计代码","type" => "tit"),
	array( "id" => "d_track_b","type" => "checkbox" ),
	array( "id" => "d_track","type" => "textarea","std" => "百度统计、CNZZ、51啦、量子统计等等"),

	array( "name" => "文章缩略图","type" => "tit"),	
	array( "id" => "d_thumbnail_b","type" => "checkbox" ),

	array( "name" => "评论头像缓存","type" => "tit"),	
	array( "id" => "d_avatar_b","type" => "checkbox" ),

	array( "type" => "endtag"),

	//广告系统
	array( "name" => "广告系统","type" => "section","desc" => "站点的广告展示，包括图片广告、Google广告、百度联盟、淘宝联盟等，将代码贴入即可"),	
	
	array( "name" => "全站-内容上","type" => "tit"),
	array( "id" => "d_adalltop_b","type" => "checkbox" ),
	array( "id" => "d_adalltop","type" => "textarea"),

	array( "name" => "文章页-正文末01","type" => "tit"),
	array( "id" => "d_adpost_b","type" => "checkbox" ),
	array( "id" => "d_adpost","type" => "textarea"),

	array( "name" => "文章页-正文末02","type" => "tit"),
	array( "id" => "d_adpost02_b","type" => "checkbox" ),
	array( "id" => "d_adpost02","type" => "textarea"),

	array( "type" => "endtag"),

);

function mytheme_add_admin() {
	global $themename, $options;
	if ( $_GET['page'] == basename(__FILE__) ) {
		if ( 'save' == $_REQUEST['action'] ) {
			foreach ($options as $value) {
				update_option( $value['id'], $_REQUEST[ $value['id'] ] ); 
			}
			header("Location: admin.php?page=dtheme.php&saved=true");
			die;
		}
		else if( 'reset' == $_REQUEST['action'] ) {
			foreach ($options as $value) {delete_option( $value['id'] ); }
			header("Location: admin.php?page=dtheme.php&reset=true");
			die;
		}
	}
	add_theme_page($themename."设置", $themename."设置", 'edit_themes', basename(__FILE__), 'mytheme_admin');
}

function mytheme_admin() {
	global $themename, $options;
	$i=0;
	if ( $_REQUEST['saved'] ) echo '<div class="d_message">'.$themename.'修改已保存</div>';
	if ( $_REQUEST['reset'] ) echo '<div class="d_message">'.$themename.'已恢复设置</div>';
?>

<div class="wrap d_wrap">
	<link rel="stylesheet" href="<?php bloginfo('template_url') ?>/option/dtheme.css"/>
	<h2><?php echo $themename; ?>设置
		<span class="d_themedesc">当前版本：D5 0.2 &nbsp;&nbsp; 设计师：<a href="http://www.daqianduan.com/" target="_blank">浩子</a> &nbsp;&nbsp; <a href="http://www.daqianduan.com/d5/" target="_blank"><?php echo $themename; ?>更新说明及问题提交</a></span>
	</h2>
	
	<form method="post">
		<div class="d_tab"><a class="d_tab_on">基本设置</a><a>广告系统</a></div>
		<?php foreach ($options as $value) { switch ( $value['type'] ) { case "": ?>
			<?php break; case "tit": ?>
			
			</li><li class="d_li">
			<h4><?php echo $value['name']; ?>：</h4>
			
			<?php break; case 'text': ?>
			<?php if ( $value['desc'] != "") { ?><label class="d_the_desc"><?php echo $value['desc']; ?></label><?php } ?><input class="d_inp <?php echo $value['class']; ?>" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id'])  ); } else { echo $value['std']; } ?>" />
			
			<?php break; case 'textarea': ?>
			<textarea class="d_tarea" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id']) ); } else { echo $value['std']; } ?></textarea>
			
			<?php break; case 'select': ?>
			<?php if ( $value['desc'] != "") { ?><span class="d_the_desc" id="<?php echo $value['id']; ?>_desc"><?php echo $value['desc']; ?></span><?php } ?><select class="d_sel" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
				<?php foreach ($value['options'] as $option) { ?>
				<option <?php if (get_settings( $value['id'] ) == $option) { echo 'selected="selected" class="d_sel_opt"'; } ?>><?php echo $option; ?></option>
				<?php } ?>
			</select>
			
			<?php break; case "checkbox": ?>
			<?php if(get_settings($value['id']) != ""){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
			<label class="d_check"><input type="checkbox" id="<?php echo $value['id']; ?>" name="<?php echo $value['id']; ?>" <?php echo $checked; ?> />开启</label>
			
			<?php break; case "section": $i++; ?>
			<div class="d_mainbox" id="d_mainbox_<?php echo $i; ?>">
				<div class="d_desc"><input class="button-primary" name="save<?php echo $i; ?>" type="submit" value="保存设置" /><?php echo $value['desc']; ?></div>
				<ul class="d_inner">
					<li class="d_li">
				
			<?php break; case "endtag": ?>
			</li></ul>
			<div class="d_desc d_desc_b"><input class="button-primary" name="save<?php echo $i; ?>" type="submit" value="保存设置" /></div>
			</div>
			
		<?php break; }} ?>
				
		<input type="hidden" name="action" value="save" />
		
		<div class="d_popup d_export">
			<h3><input class="button-primary" type="button" value="关闭" /><?php echo $themename; ?>设置-导出：</h3>
			<h4>妥善保管好您导出的数据，否则您就要一条条的添加！</h4>
			<p><textarea onmouseover="this.focus();this.select();" disabled="true" name="" id="" cols="30" rows="10"></textarea></p>
		</div>
		<div class="d_popup d_import">
			<h3><input class="button-primary" type="button" value="立即导入" /><?php echo $themename; ?>设置-导入：</h3>
			<h4>贴入您之前保存的导出数据，点击“立即导入”，确定导入成功后再保存！</h4>
			<p><textarea onmouseover="this.focus();this.select();" name="" id="" cols="30" rows="10"></textarea></p>
		</div>
	</form>
<script src="<?php bloginfo('template_url') ?>/js/jquery.min.js"></script>
<script src="<?php bloginfo('template_url') ?>/option/dtheme.js"></script>
</div>
<?php } ?>
<?php add_action('admin_menu', 'mytheme_add_admin');?>