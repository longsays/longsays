<?php

$danme = 'D5';

add_action( 'after_setup_theme', 'dtheme_setup' );

include('option/dtheme.php');
include('widget/index.php');

if (function_exists('register_sidebar')){
    register_sidebar(array(
        'name'          => '网站侧栏',
        'id'            => 'widget_sidebar',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-tit">',
        'after_title'   => '</h3>',
    ));
}

function dopt($e){
    return stripslashes(get_option($e));
}

function dtheme_setup(){
	
	//去除头部冗余代码
	remove_action( 'wp_head',   'feed_links_extra', 3 ); 
	remove_action( 'wp_head',   'rsd_link' ); 
	remove_action( 'wp_head',   'wlwmanifest_link' ); 
	remove_action( 'wp_head',   'index_rel_link' ); 
	remove_action( 'wp_head',   'start_post_rel_link', 10, 0 ); 
	remove_action( 'wp_head',   'wp_generator' ); 
	
	add_action('wp_head', 		'dtheme_keywords');			//关键字
	add_action('wp_head', 		'dtheme_description');		//页面描述
	add_action('init', 			'dtheme_gzip');				//Gzip压缩
	add_action('comment_post', 	'comment_mail_notify');		//评论回复邮件通知
	add_action('comment_form', 	'dtheme_add_checkbox');		//自动勾选评论回复邮件通知，不勾选则注释掉
	add_filter('smilies_src',	'dtheme_smilies_src',1,10);	//评论表情改造，如需更换表情，img/smilies/下替换
	add_filter('the_content', 	'dtheme_copyright');		//文章末尾增加版权

    //头像缓存
    if(dopt('d_avatar_b')!=''){
	   add_filter('get_avatar','dtheme_avatar');
    }

    //缩略图设置
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(140, 98, true); 
	
	//移除自动保存和修订版本
	add_action('wp_print_scripts',	'dtheme_disable_autosave' );
	remove_action('pre_post_update','wp_save_post_revision' );
	
	//去除自带js
	wp_deregister_script( 'l10n' );	
	
	//修改默认发信地址
	add_filter('wp_mail_from', 'dtheme_res_from_email');
	add_filter('wp_mail_from_name', 'dtheme_res_from_name');
	
	//定义菜单
	if (function_exists('register_nav_menus')){
		register_nav_menus( array(
    		'nav'     => __('站点导航'),
    		'menu'    => __('顶部菜单')
		) );
	}

}

//关键字
function dtheme_keywords() {
  global $s, $post;
  $keywords = '';
  if ( is_single() ) {
    if ( get_the_tags( $post->ID ) ) {
      foreach ( get_the_tags( $post->ID ) as $tag ) $keywords .= $tag->name . ', ';
    }
    foreach ( get_the_category( $post->ID ) as $category ) $keywords .= $category->cat_name . ', ';
    $keywords = substr_replace( $keywords , '' , -2);
  } elseif ( is_home () )    { $keywords = dopt('d_keywords');
  } elseif ( is_tag() )      { $keywords = single_tag_title('', false);
  } elseif ( is_category() ) { $keywords = single_cat_title('', false);
  } elseif ( is_search() )   { $keywords = esc_html( $s, 1 );
  } else { $keywords = trim( wp_title('', false) );
  }
  if ( $keywords ) {
    echo "<meta name=\"keywords\" content=\"$keywords\" />\n";
  }
}

//网站描述
function dtheme_description() {
  global $s, $post;
  $description = '';
  $blog_name = get_bloginfo('name');
  if ( is_singular() ) {
    if( !empty( $post->post_excerpt ) ) {
      $text = $post->post_excerpt;
    } else {
      $text = $post->post_content;
    }
    $description = trim( str_replace( array( "\r\n", "\r", "\n", "　", " "), " ", str_replace( "\"", "'", strip_tags( $text ) ) ) );
    if ( !( $description ) ) $description = $blog_name . "-" . trim( wp_title('', false) );
  } elseif ( is_home () )    { $description = $blog_name . "-" . get_bloginfo('description') . dopt('d_description'); // 首頁要自己加
  } elseif ( is_tag() )      { $description = $blog_name . "有关 '" . single_tag_title('', false) . "' 的文章";
  } elseif ( is_category() ) { $description = $blog_name . "有关 '" . single_cat_title('', false) . "' 的文章";
  } elseif ( is_archive() )  { $description = $blog_name . "在: '" . trim( wp_title('', false) ) . "' 的文章";
  } elseif ( is_search() )   { $description = $blog_name . ": '" . esc_html( $s, 1 ) . "' 的搜索結果";
  } else { $description = $blog_name . "有关 '" . trim( wp_title('', false) ) . "' 的文章";
  }
  $description = mb_substr( $description, 0, 220, 'utf-8' ) . '..';
  echo "<meta name=\"description\" content=\"$description\" />\n";
}

//缩略图获取
function dm_the_thumbnail() {  
    global $post;  
    if ( has_post_thumbnail() ) {  
        echo '<a href="'.get_permalink().'" class="pic">'; 
    $domsxe = simplexml_load_string(get_the_post_thumbnail());
    $thumbnailsrc = $domsxe->attributes()->src;  
    echo '<img src="'.$thumbnailsrc.'" alt="'.trim(strip_tags( $post->post_title )).'" />';
        echo '</a>';  
    } else {
        $content = $post->post_content;  
        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);  
        $n = count($strResult[1]);  
        if($n > 0){
            echo '<a href="'.get_permalink().'" class="pic"><img src="http://image.du0.org/cache.php?src='.$strResult[1][0].'&amp;w=140&amp;h=98&amp;zc=0&amp;f=1" alt="'.trim(strip_tags( $post->post_title )).'" /></a>';  
        }else {
            echo '<a href="'.get_permalink().'" class="pic"><img src="http://longsays.b0.upaiyun.com/img/thumbnail.png" alt="'.trim(strip_tags( $post->post_title )).'" /></a>';  
        }  
    }  
}

//修改评论表情调用路径
function dtheme_smilies_src ($img_src, $img, $siteurl){
    return get_bloginfo('template_directory').'/img/smilies/'.$img;
}

//移除自动保存
function dtheme_disable_autosave() {
	wp_deregister_script('autosave');
}

//评论表情
function dtheme_smilies(){
    $a = array( 'mrgreen','razz','sad','smile','oops','grin','eek','???','cool','lol','mad','twisted','roll','wink','idea','arrow','neutral','cry','?','evil','shock','!' );
    $b = array( 'mrgreen','razz','sad','smile','redface','biggrin','surprised','confused','cool','lol','mad','twisted','rolleyes','wink','idea','arrow','neutral','cry','question','evil','eek','exclaim' );
    for( $i=0;$i<22;$i++ ){
        echo '<a title="'.$a[$i].'" href="javascript:grin('."':".$a[$i].":'".')"><img src="'.get_bloginfo('template_directory').'/img/smilies/icon_'.$b[$i].'.gif" /></a>';
    }
}

//垃圾评论拦截
class anti_spam {
  function anti_spam() {
    if ( !current_user_can('level_0') ) {
      add_action('template_redirect', array($this, 'w_tb'), 1);
      add_action('init', array($this, 'gate'), 1);
      add_action('preprocess_comment', array($this, 'sink'), 1);
    }
  }
  function w_tb() {
    if ( is_singular() ) {
      ob_start(create_function('$input','return preg_replace("#textarea(.*?)name=([\"\'])comment([\"\'])(.+)/textarea>#",
      "textarea$1name=$2w$3$4/textarea><textarea name=\"comment\" cols=\"100%\" rows=\"4\" style=\"display:none\"></textarea>",$input);') );
    }
  }
  function gate() {
    if ( !empty($_POST['w']) && empty($_POST['comment']) ) {
      $_POST['comment'] = $_POST['w'];
    } else {
      $request = $_SERVER['REQUEST_URI'];
      $spamcom = isset($_POST['comment'])        ? $_POST['comment']                : null;
      $_POST['spam_confirmed'] = "$spamcom";
    }
  }

  function sink( $comment ) {
  $email = $comment['comment_author_email'];
  $g = 'http://www.gravatar.com/avatar/'. md5( strtolower( $email ) ). '?d=404';
  $headers = @get_headers( $g );
    if ( !preg_match("|200|", $headers[0]) ) {
      add_filter('pre_comment_approved', create_function('', 'return "0";'));
    }
    if ( !empty($_POST['spam_confirmed']) ) {
      if ( in_array( $comment['comment_type'], array('pingback', 'trackback') ) ) return $comment; 
      die();
      add_filter('pre_comment_approved', create_function('', 'return "spam";'));
      $comment['comment_content'] = $_POST['spam_confirmed'];
    }
    return $comment;
  }
}
$anti_spam = new anti_spam();

//Gzip压缩
function dtheme_gzip() {
  if ( strstr($_SERVER['REQUEST_URI'], '/js/tinymce') )
    return false;
  if ( ( ini_get('zlib.output_compression') == 'On' || ini_get('zlib.output_compression_level') > 0 ) || ini_get('output_handler') == 'ob_gzhandler' )
    return false;
  if (extension_loaded('zlib') && !ob_start('ob_gzhandler'))
    ob_start();
}

//取消原有jQuery
if ( !is_admin() ) { // 后台不用
  if ( $localhost == 0 ) { // 本地调试不用
    function my_init_method() {
      wp_deregister_script( 'jquery' ); // 取消原有的 jquery 定义
    }    
  add_action('init', 'my_init_method'); // 加入功能, 前台使用 wp_enqueue_script( '名称' ) 加載
  }
}

//修改默认发信地址
function dtheme_res_from_email($email) {
    $wp_from_email = get_option('admin_email');
    return $wp_from_email;
}
function dtheme_res_from_name($email){
    $wp_from_name = get_option('blogname');
    return $wp_from_name;
}

//评论回应邮件通知
function comment_mail_notify($comment_id) {
  $admin_notify = '1'; 
  $admin_email = get_bloginfo ('admin_email'); 
  $comment = get_comment($comment_id);
  $comment_author_email = trim($comment->comment_author_email);
  $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
  global $wpdb;
  if ($wpdb->query("Describe {$wpdb->comments} comment_mail_notify") == '')
    $wpdb->query("ALTER TABLE {$wpdb->comments} ADD COLUMN comment_mail_notify TINYINT NOT NULL DEFAULT 0;");
  if (($comment_author_email != $admin_email && isset($_POST['comment_mail_notify'])) || ($comment_author_email == $admin_email && $admin_notify == '1'))
    $wpdb->query("UPDATE {$wpdb->comments} SET comment_mail_notify='1' WHERE comment_ID='$comment_id'");
  $notify = $parent_id ? get_comment($parent_id)->comment_mail_notify : '0';
  $spam_confirmed = $comment->comment_approved;
  if ($parent_id != '' && $spam_confirmed != 'spam' && $notify == '1') {
    $wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])); 
    $to = trim(get_comment($parent_id)->comment_author_email);
    $subject = 'Hi，您在 [' . get_option("blogname") . '] 的留言有人回复啦！';
    $message = '
    <div style="color:#333;font:100 14px/24px microsoft yahei;">
      <p>' . trim(get_comment($parent_id)->comment_author) . ', 您好!</p>
      <p>您曾在《' . get_the_title($comment->comment_post_ID) . '》的留言:<br /> &nbsp;&nbsp;&nbsp;&nbsp; '
       . trim(get_comment($parent_id)->comment_content) . '</p>
      <p>' . trim($comment->comment_author) . ' 给您的回应:<br /> &nbsp;&nbsp;&nbsp;&nbsp; '
       . trim($comment->comment_content) . '<br /></p>
      <p>点击 <a href="' . htmlspecialchars(get_comment_link($parent_id)) . '">查看回应完整內容</a></p>
      <p>欢迎再次光临 <a href="' . get_option('home') . '">' . get_option('blogname') . '</a></p>
      <p style="color:#999">(此邮件由系统自动发出，请勿回复.)</p>
    </div>';
    $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
    $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
    wp_mail( $to, $subject, $message, $headers );
    //echo 'mail to ', $to, '<br/> ' , $subject, $message; // for testing
  }
}

//自动勾选 
function dtheme_add_checkbox() {
  echo '<label for="comment_mail_notify" class="comment_mail"><input type="checkbox" name="comment_mail_notify" id="comment_mail_notify" value="comment_mail_notify" checked="checked"/>有人回复时邮件通知我</label>';
}

//文章（包括feed）末尾加版权说明
function dtheme_copyright($content) {
	if( is_single() ){
		$content.= '<p>转载请注明：<a href="'.get_bloginfo('url').'">'.get_bloginfo('name').'</a> &raquo; <a href="'.get_permalink().'">'.get_the_title().'</a></p>';
	}
	return $content;
}

//时间显示方式‘xx以前’
function time_ago( $type = 'commennt', $day = 14 ) {
	$d = $type == 'post' ? 'get_post_time' : 'get_comment_time';
	if (time() - $d('U') > 60*60*24*$day) return;
	echo ' (', human_time_diff($d('U'), strtotime(current_time('mysql', 0))), '前)';
}

//评论头像缓存
function dtheme_avatar($avatar) {
	$tmp = strpos($avatar, 'http');
	$g = substr($avatar, $tmp, strpos($avatar, "'", $tmp) - $tmp);
	$tmp = strpos($g, 'avatar/') + 7;
	$f = substr($g, $tmp, strpos($g, "?", $tmp) - $tmp);
	$w = get_bloginfo('wpurl');
	$e = ABSPATH .'avatar/'. $f ;
	$t = 1209600; //14天过期
	if ( !is_file($e) || (time() - filemtime($e)) > $t ) { 
		copy(htmlspecialchars_decode($g), $e);
	} else  $avatar = strtr($avatar, array($g => $w.'/avatar/'.$f));
	if (filesize($e) < 500) copy(get_bloginfo('template_directory').'/img/love.jpg', $e);
	return $avatar;
}

//评论者近期评论数目
function WelcomeCommentAuthorBack($email = ''){
  if(empty($email)){
    return;
  }
  global $wpdb;

  $past_30days = gmdate('Y-m-d H:i:s',((time()-(24*60*60*90))+(get_option('gmt_offset')*3600)));
  $sql = "SELECT count(comment_author_email) AS times FROM $wpdb->comments
          WHERE comment_approved = '1'
          AND comment_author_email = '$email'
          AND comment_date >= '$past_30days'";
  $times = $wpdb->get_results($sql);
  $times = ($times[0]->times) ? $times[0]->times : 0;
  $message = $times ? sprintf(__('Hi，一个月内您评论了<strong>%1$s</strong>次，继续加油哦！' ), $times) : '您很久都没有留言了，给力点！！！';

  return $message;
}

//评论样式
function dtheme_comment_list($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
    global $commentcount,$wpdb, $post;
    if(!$commentcount) { //初始化楼层计数器
		$comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_post_ID = $post->ID AND comment_type = '' AND comment_approved = '1' AND !comment_parent");
		$cnt = count($comments);//获取主评论总数量
		$page = get_query_var('cpage');//获取当前评论列表页码
		$cpp=get_option('comments_per_page');//获取每页评论显示数量
		if (ceil($cnt / $cpp) == 1 || ($page > 1 && $page  == ceil($cnt / $cpp))) {
			$commentcount = $cnt + 1;//如果评论只有1页或者是最后一页，初始值为主评论总数
		} else {
			$commentcount = $cpp * $page + 1;
		}
    }

	echo '<li '; comment_class(); echo ' id="comment-'.get_comment_ID().'">';
	//楼层
	if(!$parent_id = $comment->comment_parent) {
		echo '<div class="c-floor"><a href="#comment-'.get_comment_ID().'">'; printf('#%1$s', --$commentcount); echo '</a></div>';
	}
	//头像
	echo '<div class="c-avatar">';
	if (($comment->comment_author_email) == get_bloginfo ('admin_email')){
		echo '<img src="'.get_bloginfo('template_directory').'/img/admin.png" class="avatar" />';
	} else {
		echo get_avatar( $comment->comment_author_email, $size = '36' ,$default = get_bloginfo('wpurl') . '/avatar/default.png'); 
	}
	echo '</div>';
	//内容
	echo '<div class="c-main" id="div-comment-'.get_comment_ID().'">';
		echo comment_text();
		if ($comment->comment_approved == '0'){
			echo '<span class="c-approved">您的评论正在排队审核中，请稍后！</span><br />';
		}
		//信息
		echo '<div class="c-meta">';
			 echo '<span class="c-author"><a href="http://www.longsays.com/wp-content/?'; echo comment_author_url(); echo '" target="_blank" rel="external nofollow" class="url">'; echo comment_author(); echo '</a></span>'; echo get_comment_time('m-d H:i '); echo time_ago(); 
			if ($comment->comment_approved !== '0'){ 
				echo comment_reply_link( array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); 
				echo edit_comment_link(__('(编辑)'),' - ','');
			} 
		echo '</div>';
	echo '</div>';
}

function autoicon($text) {
$return = str_replace('<a href=', '<a class="external" href=', $text);
$return = str_replace('<a class="external" href="http://www.longsays.com', '<a href="http://www.longsays.com', $return);
$return = str_replace('<a class="external" href="#', '<a href="#', $return);
return $return;
}
add_filter('the_content', 'autoicon');   //应用于文章区域
add_filter('comment_text', 'autoicon');   //应用于评论区域

//日志
make_log_file();
function make_log_file(){
        //log文件名
	$filename = 'mylogs.txt'; 
        //去除rc-ajax评论以及cron机制访问记录
	if(strstr($_SERVER["REQUEST_URI"],"rc-ajax")== false 
		&& strstr($_SERVER["REQUEST_URI"],"wp-cron.php")== false ) {
		$word .= date('mdHis',$_SERVER['REQUEST_TIME'] + 3600*8) . " ";
                //访问页面
		$word .= $_SERVER["REQUEST_URI"] ." ";
                //协议
		$word .= $_SERVER['SERVER_PROTOCOL'] ." ";
                //方法,POST OR GET
		$word .= $_SERVER['REQUEST_METHOD'] . " ";
		//$word .= $_SERVER['HTTP_ACCEPT'] . " ";
                //获得浏览器信息
		$word .= getbrowser(). " ";
                //传递参数
		$word .= "[". $_SERVER['QUERY_STRING'] . "] ";
                //跳转地址
		$word .= $_SERVER['HTTP_REFERER'] . " ";
                //获取IP
		$word .= getIP() . " ";
		$word .= "\n";
		$fh = fopen($filename, "a");
		fwrite($fh, $word);    
		fclose($fh);
	}
}
//获取IP地址，网上现成代码
function getIP() //get ip address
    {
        if (getenv('HTTP_CLIENT_IP')) 
        {
            $ip = getenv('HTTP_CLIENT_IP');
        } 
        else if (getenv('HTTP_X_FORWARDED_FOR')) 
        {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } 
        else if (getenv('REMOTE_ADDR')) 
        {
            $ip = getenv('REMOTE_ADDR');
        } 
        else 
        {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
//获取浏览器信息，移动端，平板电脑数据还未加上。
 function getbrowser()
    {
        $Agent = $_SERVER['HTTP_USER_AGENT'];
        $browser = '';
        $browserver = '';

        if(ereg('Mozilla', $Agent) && ereg('Chrome', $Agent))
        {
            $temp = explode('(', $Agent);
            $Part = $temp[2];
            $temp = explode('/', $Part);
            $browserver = $temp[1];
            $temp = explode(' ', $browserver);
            $browserver = $temp[0];
            $browserver = $browserver;
            $browser = 'Chrome';
        }
		if(ereg('Mozilla', $Agent) && ereg('Firefox', $Agent))
        {
            $temp = explode('(', $Agent);
            $Part = $temp[1];
            $temp = explode('/', $Part);
            $browserver = $temp[2];
            $temp = explode(' ', $browserver);
            $browserver = $temp[0];
            $browserver = $browserver;
            $browser = 'Firefox';
        }
        if(ereg('Mozilla', $Agent) && ereg('Opera', $Agent)) 
        {
            $temp = explode('(', $Agent);
            $Part = $temp[1];
            $temp = explode(')', $Part);
            $browserver = $temp[1];
            $temp = explode(' ', $browserver);
            $browserver = $temp[2];
            $browserver = $browserver;
            $browser = 'Opera';
        }
        if(ereg('Mozilla', $Agent) && ereg('MSIE', $Agent))
        {
            $temp = explode('(', $Agent);
            $Part = $temp[1];
            $temp = explode(';', $Part);
            $Part = $temp[1];
            $temp = explode(' ', $Part);
            $browserver = $temp[2];
            $browserver = $browserver;
            $browser = 'Internet Explorer';
        }
        if($browser != '')
        {
            $browseinfo = $browser.' '.$browserver;
        } 
        else
        {
            $browseinfo = $_SERVER['HTTP_USER_AGENT'];
        }
        return $browseinfo;
    }

	
//蜘蛛分析
function get_spider_log($atts) {
	extract(shortcode_atts(array(
    'text' => 'yes'),$atts));
	$fh = fopen(site_url() ."/mylogs.txt", "r");
	$contents = "";
	    while(!feof($fh)){
        $contents .= fread($fh, 8080);
    }
    fclose($fh);
	$str = "";
	$showtime=date("md");
	if($text == "yes") {
		$str.= "当天蜘蛛爬行记录：";	
		$str.= "<div style='background-color:#33A1C9;color:white;text-align:center;'>以下为国内常用蜘蛛。</div>";
	}
	$mytmp = array();
	//google
	$google = 0;
	if($text == "yes")
		$str.= "<a href=http://www.google.com/bot.html target=_blank>Google Spider</a>: ";
	$mytmp = show_spider_result($showtime,$contents,"Googlebot\/",$text);
	$google += $mytmp[0];
	$str.= $mytmp[1];
	$mytmp = show_spider_result($showtime,$contents,"Googlebot-Image\/",$text);
	$google += $mytmp[0];
	$str.= $mytmp[1];
	$mytmp = show_spider_result($showtime,$contents,"Googlebot-Mobile\/",$text);
	$google += $mytmp[0];
	$str.= $mytmp[1];
	$mytmp = show_spider_result($showtime,$contents,"Feedfetcher-Google",$text);
	$google += $mytmp[0];
	$str.= $mytmp[1];

	// baidu
	$baidu = 0;
	if($text == "yes")
		$str.= "<br><a href=http://www.baidu.com/search/spider.html target=_blank>Baidu Spider</a>: ";
	$mytmp = show_spider_result($showtime,$contents,"Baiduspider\/",$text);
	$baidu += $mytmp[0];
	$str.= $mytmp[1];
	$mytmp = show_spider_result($showtime,$contents,"Baiduspider-image",$text);
	$baidu += $mytmp[0];
	$str.= $mytmp[1];

	//bing
	$bing = 0;
	if($text == "yes")
		$str.= "<br><a href=http://www.bing.com/bingbot.htm target=_blank>bingbot Spider</a>: ";
	$mytmp = show_spider_result($showtime,$contents,"bingbot\/",$text);
	$bing += $mytmp[0];
	$str.= $mytmp[1];
	$mytmp = show_spider_result($showtime,$contents,"msnbot-media\/",$text);
	$bing += $mytmp[0];
	$str.= $mytmp[1];

	//sogou
	$sogou = 0;
	if($text == "yes")
		$str.= "<br><a href=http://www.sogou.com/docs/help/webmasters.htm#07 target=_blank>Sogou Spider</a>: ";
	$mytmp = show_spider_result($showtime,$contents,"Sogou web spider\/",$text);
	$sogou += $mytmp[0];
	$str.= $mytmp[1];

	//soso
	$soso = 0;
	if($text == "yes")
		$str.= "<br><a href=http://help.soso.com/webspider.htm target=_blank>Soso Spider</a>: ";
	$mytmp = show_spider_result($showtime,$contents,"Sosospider\/",$text);
	$soso += $mytmp[0];
	$str.= $mytmp[1];

	if($text == "yes")
		$str.= "<div style='background-color:#FA8072;color:white;text-align:center;'>以下为垃圾蜘蛛，可屏蔽抓取。</div>";
	//jike
	$else = 0;
	if($text == "yes")
		$str.= "<a href=http://shoulu.jike.com/spider.html target=_blank>Jike Spider</a>: ";
	$mytmp = show_spider_result($showtime,$contents,"JikeSpider",$text);
	$else += $mytmp[0];
	$str.= $mytmp[1];

	//easou
	if($text == "yes")
		$str.= "<br><a href=http://www.easou.com/search/spider.html target=_blank>Easou Spider</a>: ";
	$mytmp = show_spider_result($showtime,$contents,"EasouSpider",$text);
	$else += $mytmp[0];
	$str.= $mytmp[1];

	//yisou
	if($text == "yes")
		$str.= "<br>YisouSpider：";
	$mytmp = show_spider_result($showtime,$contents,"YisouSpider",$text);
	$else += $mytmp[0];
	$str.= $mytmp[1];

	if($text == "yes")
		$str.= "<br><a href=http://yandex.com/bots target=_blank>YandexBot Spider</a>: ";
	$mytmp = show_spider_result($showtime,$contents,"YandexBot\/",$text);
	$else += $mytmp[0];
	$str.= $mytmp[1];

	if($text == "yes")
		$str.= "<br><a href=http://go.mail.ru/help/robots target=_blank>Mail.RU Spider</a>: ";
	$mytmp = show_spider_result($showtime,$contents,"Mail.RU_Bot\/",$text);
	$else += $mytmp[0];
	$str.= $mytmp[1];

	if($text == "yes")
		$str.= "<br><a href=http://www.acoon.de/robot.asp target=_blank>AcoonBot Spider</a>: ";
	$mytmp = show_spider_result($showtime,$contents,"AcoonBot\/",$text);
	$else += $mytmp[0];
	$str.= $mytmp[1];

	if($text == "yes")
		$str.= "<br><a href=http://www.exabot.com/go/robot target=_blank>Exabot Spider</a>: ";
	$mytmp = show_spider_result($showtime,$contents,"Exabot\/",$text);
	$else += $mytmp[0];
	$str.= $mytmp[1];

	if($text == "yes")
		$str.= "<br><a href=http://www.seoprofiler.com/bot target=_blank>spbot Spider</a>: ";
	$mytmp = show_spider_result($showtime,$contents,"spbot\/",$text);
	$else += $mytmp[0];
	$str.= $mytmp[1];
	
	$str.= draw_canvas($google,$baidu,$bing,$sogou,$soso,$else);
	return $str;
}
function show_spider_result($time,$contents,$str,$text){
	$count = array();
	$count[0] = preg_match_all("/".$time."\d*\s\/\S*\s.*".$str."/",$contents,$mymatches);
	if($text == "yes") {
		$str = preg_replace("{\\\/}","",$str);
		$count[1].= "<br> 蜘蛛类型=>".$str.": 爬行次数=".$count[0];
		if($count[0] >0) {
			$tmp = substr($mymatches[0][$count[0]-1],4,6);
			$tmp = substr($tmp,0,2) .":" . substr($tmp,2,2) .":" .substr($tmp,4,2) ;
			$count[1].= " 最后爬行时间：". $tmp;
		}
	}
	return $count;
}
function draw_canvas($google,$baidu,$bing,$sogou,$soso,$else){
	$tmp = $google + $baidu + $bing + $sogou + $soso + $else;
	if($tmp == 0) {
		return "<br><br>数据不足，无法生成分析图。<br><br>";
	}
	$google2 = $google*100/$tmp;
	$baidu2 = $baidu*100/$tmp;
	$bing2 = $bing*100/$tmp;
	$sogou2 = $sogou*100/$tmp;
	$soso2 = $soso*100/$tmp;
	$else2 = $else*100/$tmp;
	$str.= "<br><div style='border-top: 1px solid #e6e6e6;'><br>
	<div style='float:left;width:150px;border-width:1px;border-style:groove;padding:15px;'><b>蜘蛛爬行分析图：</b><br>";
	$str.= "日期：" . date("Y-m-d");
	$str.= "<br>蜘蛛一共爬行". $tmp . "次：<br>";
	$str.= "<li><span style='color:#33A1C9;'>google:". $google ."次(". intval($google2) ."%)</span></li>";
	$str.= "<li><span style='color:#0033ff;'>baidu:". $baidu ."次(". intval($baidu2) ."%)</span></li>";
	$str.= "<li><span style='color:#872657;'>bing:". $bing ."次(". intval($bing2) ."%)</span></li>";
	$str.= "<li><span style='color:#FF9912;'>sogou:". $sogou ."次(". intval($sogou2) ."%)</span></li>";
	$str.= "<li><span style='color:#FF6347;'>soso:". $soso ."次(". intval($soso2) ."%)</span></li>";
	$str.= "<li><span style='color:#55aa00;'>else:". $else ."次(". (100 - intval($google2) - intval($baidu2) - intval($bing2) - intval($sogou2) - intval($soso2)) ."%)</span></li></div>";
	$str.=	"<img src = 'http://chart.apis.google.com/chart?cht=p3&chco=33A1C9,0033ff,872657,FF9912,FF6347,55aa00&chd=t:".$google2 .",".$baidu2.",".$bing2.",".$sogou2.",".$soso2.",".$else2."&chs=400x200&chl=google|baidu|bing|sogou|soso|else' /></div><br>";
	return $str;
}
add_shortcode('spiderlogs','get_spider_log');
	
	
?>