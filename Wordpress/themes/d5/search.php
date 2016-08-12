<?php get_header(); ?>

<?php if(dopt('d_adalltop_b')!='') echo '<div class="banner">'.dopt('d_adalltop').'</div>'; ?>

<?php if ( have_posts() ) { ?>

<h1 class="base-tit queryinfo">“<?php echo $s; ?>”的搜索结果</h1>
<ul class="excerpt">
	<?php while ( have_posts() ) : the_post();?>
	<li>
		<div class="excerpt-num">
			<span class="num-comm<?php if(get_comments_number()>18){echo ' num-comm-hot';} ?>"><strong><?php comments_number('0', '1', '%'); ?></strong><?php if(get_comments_number()>1){echo 'answers';} else{echo 'answer';} ?></span>
			<span class="num-view"><strong><?php if(function_exists('the_views')) the_views(); ?></strong>views</span>
		</div>
		<h2 class="excerpt-tit"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
		<p class="excerpt-desc"><?php echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 160, '...'); ?></p>
		<div class="excerpt-tag">
			<?php $posttags = get_the_tags();
			if ($posttags) {
				foreach($posttags as $tag) {
					echo '<a class="tags tags-' . $tag->term_id . '" href="'.get_tag_link($tag).'">'. $tag->name .'</a>'; 
				}
			} ?>
		</div>
		<div class="excerpt-time"><?php the_time('m-d');?></div>
	</li>
	<?php endwhile;?>
</ul>
<div class="paging"><?php include('inc/mod-paging.php'); ?></div>

<?php }else{ ?>
<h1 class="base-tit queryinfo">So sorry 没有“<?php echo $s; ?>”的搜索结果</h1>
<?php } ?>

<?php get_sidebar(); get_footer(); ?>