<?php /* * template name: 存档页*/get_header();?>
<style type="text/css">
/* archives */
.archives td{padding: 6px 10px 8px;border-bottom: solid 1px #eee}
.archives table{padding:10px 0 20px}
.meta-tit{border-bottom: solid 1px #e6e6e6;padding: 0 0 10px;margin-bottom: 20px}
</style>
<div class="main">	<h1 class="main-tit">存档页<strong>All Posts</strong><em>（共计<?php $count_posts = wp_count_posts(); echo $published_posts = $count_posts->publish;?>篇文章）</em></h1>
	<div class="share-ico"><?php include('inc/mod-share.php'); ?></div>
<div class="archives">
	<?php    $previous_year = $year = 0;    $previous_month = $month = 0;    $ul_open = false;    $myposts = get_posts('numberposts=-1&orderby=post_date&order=DESC');    foreach($myposts as $post) :        setup_postdata($post);        $year = mysql2date('Y', $post->post_date);        $month = mysql2date('n', $post->post_date);        $day = mysql2date('j', $post->post_date);        if($year != $previous_year || $month != $previous_month) :            if($ul_open == true) :                 echo '</table>';            endif;            echo '<h3>'; echo the_time('F Y'); echo '</h3>';            echo '<table>';            $ul_open = true;        endif;        $previous_year = $year; $previous_month = $month;    ?>
        <tr>
            <td width="30" style="text-align:right;"><?php the_time('j'); ?>日</td>
            <td width="400"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td>
            <td width="100"><a class="comm" href="<?php comments_link(); ?>" title="查看 <?php the_title(); ?> 的评论"><?php comments_number('0', '1', '%'); ?>人评论</a></td>
            <td width="100"><span class="view"><?php if(function_exists('the_views')) the_views(); ?>次浏览</span></td>
        </tr>
    <?php endforeach; ?>
    </table>
</div>
</div>
<?php get_sidebar(); get_footer(); ?>