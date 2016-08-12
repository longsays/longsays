<h3 class="base-tit">相关文章</h3>
<ul class="post-related">
<?php  
$exclude_id = $post->ID; 
$posttags = get_the_tags(); 
$i = 0;
$limit = 6 ;
if ( $posttags ) { 
	$tags = ''; foreach ( $posttags as $tag ) $tags .= $tag->name . ',';
	$args = array(
		'post_status' => 'publish',
		'tag_slug__in' => explode(',', $tags), 
		'post__not_in' => explode(',', $exclude_id), 
		'caller_get_posts' => 1, 
		'orderby' => 'comment_date', 
		'posts_per_page' => $limit
	);
	query_posts($args); 
	while( have_posts() ) { the_post();
		echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a>&nbsp;<strong>'.get_comments_number('', '1', '%').'条评论</strong> &nbsp;&nbsp; '; if(function_exists('the_views')) the_views().'次浏览'; echo ' &nbsp;&nbsp; '; the_time('Y-m-d'); echo ' </li>';
		$exclude_id .= ',' . $post->ID; $i ++;
	};
	wp_reset_query();
}
if ( $i < $limit ) { 
	$cats = ''; foreach ( get_the_category() as $cat ) $cats .= $cat->cat_ID . ',';
	$args = array(
		'category__in' => explode(',', $cats), 
		'post__not_in' => explode(',', $exclude_id),
		'caller_get_posts' => 1,
		'orderby' => 'comment_date',
		'posts_per_page' => $limit - $i
	);
	query_posts($args);
	while( have_posts() ) { the_post();
		echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a>&nbsp;<strong>'.get_comments_number('', '1', '%').'条评论</strong> &nbsp;&nbsp; '; if(function_exists('the_views')) the_views().'次浏览'; echo ' &nbsp;&nbsp; '; the_time('Y-m-d'); echo ' </li>';
		$i ++;
	};
	wp_reset_query();
}
if ( $i  == 0 ){
	echo '<li>Ca.暂无相关文章</li>';
}
?>
</ul>