<?php ini_set('display_errors', false); ?>
<?php get_header(); ?>

<?php if(dopt('d_adalltop_b')!='') echo '<div class="banner">'.dopt('d_adalltop').'</div>'; ?>

<?php if( is_home() ){ ?>
	
	<?php if( dopt('d_onlytip_b')!='' ) echo '<div class="thetip">'.dopt('d_onlytip').'</div>'; ?>
	
	<div class="share-txt share-home">我喜欢，<?php include('inc/mod-share.php'); ?></div>
	<div class="excerpt-tab">
		<a <?php if ( isset($_GET['order']) && ($_GET['order']=='date') ) echo 'class="cur"'; ?> href="<?php bloginfo('url'); ?>?order=date">最新发布</a>
		<a <?php if ( isset($_GET['order']) && ($_GET['order']=='comment') ) echo 'class="cur"'; ?> href="<?php bloginfo('url'); ?>?order=comment">评论最多</a>
		<a <?php if ( isset($_GET['order']) && ($_GET['order']=='rand') ) echo 'class="cur"'; ?> href="<?php bloginfo('url'); ?>?order=rand">随机文章</a>
		<a <?php if ( isset($_GET['order']) && ($_GET['order']=='title') ) echo 'class="cur"'; ?> href="<?php bloginfo('url'); ?>?order=title">标题排列</a>
	</div>
<?php }else{
	include('inc/mod-queryinfo.php');
}
?>

<ul class="excerpt<?php if (dopt('d_thumbnail_b')!='') echo ' thumb'; ?>">
	<?php 
	if ( isset($_GET['order']) ){
	    switch ($_GET['order']){
	    	case 'date' : $orderby = 'date'; break;
	        case 'comment' : $orderby = 'comment_count'; break;
	        case 'rand' : $orderby = 'rand'; break;
	        case 'title' : $orderby = 'title'; break;
	        default : $orderby = 'date';
	    }
	    global $wp_query;
	    $args= array('orderby' => $orderby, 'order' => 'DESC');
	    $arms = array_merge($args, $wp_query->query);
	    query_posts($arms);
	}
	while ( have_posts() ) : the_post();
	?>
		<li>
			<?php if (dopt('d_thumbnail_b')!='') {
				dm_the_thumbnail(); 
			}else{ 
			?>
				<div class="excerpt-num">
					<span class="num-comm<?php if(get_comments_number()>18){echo ' num-comm-hot';} ?>"><strong><?php comments_number('0', '1', '%'); ?></strong><?php if(get_comments_number()>1){echo 'answers';} else{echo 'answer';} ?></span>
					<span class="num-view"><strong><?php if(function_exists('the_views')) the_views(); ?></strong>views</span>
				</div>
			<?php } ?>
			<h2 class="excerpt-tit">
				<?php if( is_sticky() ) echo '<strong>[置顶]</strong>'; ?><a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
			</h2>
			<p class="excerpt-desc">
				<?php echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 160, '...'); ?>
			</p>
			<div class="excerpt-tag">
				<?php echo the_tags('',''); ?>
				<?php if (dopt('d_thumbnail_b')!='') {
					echo '<span>';
					echo comments_number(' ', '1评论', '%评论').' &nbsp; '; 
					if(function_exists('the_views')) echo the_views().'次访问';
					echo '</span>';
				} ?>
			</div>
			<div class="excerpt-time">
				<?php the_time('m-d');?>
			</div>
		</li>
	<?php endwhile; ?>
</ul>

<script type="text/javascript"><!--
google_ad_client = "ca-pub-4162962838193717";
/* 龙语视觉-A2 */
google_ad_slot = "3338933567";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>

<div class="paging"><?php include('inc/mod-paging.php'); ?></div>

<?php get_sidebar(); get_footer(); ?>