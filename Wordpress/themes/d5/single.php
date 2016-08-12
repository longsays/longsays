<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>
<div class="meta">
	<h1 class="meta-tit"><?php the_title(); ?><span><?php comments_popup_link('抢沙发', '1条评论', '%条评论'); ?></span></h1>
	<div class="share-ico"><?php include('inc/mod-share.php'); ?></div>
	<p class="meta-info"><?php the_date_xml(); ?> &nbsp;&nbsp; 分类：<?php the_category('、'); ?> &nbsp;&nbsp; <?php if(function_exists('the_views')) the_views().'人浏览'; ?> &nbsp;&nbsp; <?php edit_post_link('[编辑]'); ?></p>
</div>
<div class="entry">
	<?php the_content(); ?>
</div>
<div class="excerpt-tag">
	继续查看有关 <?php echo the_tags('',''); ?> 的文章
</div>
<div class="share-txt"><?php include('inc/mod-share.php'); ?></div>
<?php if(dopt('d_adpost_b')!='') echo '<div class="banner">'.dopt('d_adpost').'</div>'; ?>
<?php if(dopt('d_adpost02_b')!='') echo '<div class="banner">'.dopt('d_adpost02').'</div>'; ?>
<?php include('inc/mod-post-related.php'); ?>
<?php comments_template('', true); endwhile;  ?>

<?php get_sidebar(); get_footer(); ?>