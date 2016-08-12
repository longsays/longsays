<?php 
/*
 * template name: 标签页
*/
get_header();
?>
<style type="text/css">
/* tag-clouds */
.tag-clouds li{float:left;width:25%;margin-bottom:12px;padding-bottom:2px;height:76px;border-bottom:1px dotted #ddd;}
.tag-clouds li .tags{background-color:#E0EAF1;border-bottom:1px solid #7F9FB6;border-right:1px solid #97b1c4;color:#3A55AA;padding:2px 5px;margin-right:4px;display:inline-block;border-radius:2px}
.tag-clouds li .tags:hover{background-color:#4982aa;color:#fff;border-bottom-color:#325975;border-right-color:#477291}
.tag-clouds strong{color:#666;margin-left:2px;}
.tag-clouds p{overflow:hidden;height:18px;padding:8px 20px 0 0;}
.tag-clouds em{color:#bbb;display:block;font-style:normal}
</style>
<div class="main">
	<h1 class="main-tit">标签云<strong>All Tags</strong><em>（共计<?php echo $count_tags = wp_count_terms('post_tag'); ?>个标签）</em></h1>
	<div class="share-ico"><?php include('inc/mod-share.php'); ?></div>
	<ul class="tag-clouds">
		<?php $tags_list = get_tags('orderby=count&order=DESC');
		if ($tags_list) { 
			foreach($tags_list as $tag) {
				echo '<li><a class="tags tags-'. $tag->term_id .'" href="'.get_tag_link($tag).'">'. $tag->name .'</a><strong>x '. $tag->count .'</strong><p class="tag-posts">'; 
				$posts = get_posts( "tag_id=". $tag->term_id ."&numberposts=1" );
				if( $posts ){
					foreach( $posts as $post ) {
						setup_postdata( $post );
						echo '<a href="'.get_permalink().'">'.get_the_title().'</a></p><em>'.get_the_time('Y-m-d').'</em>';
					}
				}
				echo '</li>';
			} 
		} 
		?>
	</ul>
</div>
</div>
<?php get_footer(); ?>