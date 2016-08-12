<?php 
/*
 * template name: 读者墙
*/
get_header();
function readers_wall( $outer='.',$timer='30',$limit='50' ){
	global $wpdb;
	$counts = $wpdb->get_results("select count(comment_author) as cnt, comment_author, comment_author_url, comment_author_email from (select * from $wpdb->comments left outer join $wpdb->posts on ($wpdb->posts.id=$wpdb->comments.comment_post_id) where comment_date > date_sub( now(), interval $timer month ) and user_id='0' and comment_author != '".$outer."' and post_password='' and comment_approved='1' and comment_type='') as tempcmt group by comment_author order by cnt desc limit $limit");
	foreach ($counts as $count) {
		$avatar_url = get_bloginfo('wpurl') . '/avatar/' . md5(strtolower($count->comment_author_email));
		$c_url = $count->comment_author_url;
		if ($c_url == '') $c_url = '';
		$page .= '<li><img src="' . $avatar_url . '" /><a target="_blank" href="'. $c_url . '">' . $count->comment_author . '</a><br /><strong>'. $count->cnt . '+</strong></li>';
	}
	echo $page;
};
?>
<style>
.readers{overflow:hidden;}
.readers li{float:left;width:20%;overflow:hidden;height:36px;margin-bottom:10px;line-height:18px;border-bottom:1px dotted #ddd;padding-bottom:10px;}
.readers img{float:left;border-radius:2px;margin-right:8px;width:36px;height:36px;}
.readers a{color:#666;}
.readers a:hover{color:#333;}
.readers strong{color:#380;font-weight:normal;}
</style>
<div class="main">
	<h1 class="main-tit">读者墙<strong>Readers</strong><em>（取前50位）</em></h1>
	<div class="share-ico"><?php include('inc/mod-share.php'); ?></div>
	<?php while (have_posts()) : the_post(); ?>
	<div class="entry">
		<?php the_content(); ?>
	</div>
	<ul class="readers">
		<?php readers_wall(); ?>
	</ul>
	<?php comments_template('', true); endwhile;  ?>
</div>
</div>

<?php get_footer(); ?>