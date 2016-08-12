<?php 
echo '<h1 class="base-tit queryinfo">';
if (is_category()){ 
	echo '分类“'; echo single_cat_title().'”的内容';
} elseif( is_tag() ){ 
	echo '标签“'; echo single_tag_title().'”的内容';
} elseif( is_day() ){ 
	echo the_time('Y年 F j日').'”的内容';
} elseif( is_month() ){ 
	echo the_time('Y年 F').'”的内容';
} elseif( is_year() ){ 
	echo the_time('Y年').'”的内容';
} elseif( isset($_GET['paged']) && !empty($_GET['paged'])){ 
	echo '您正在浏览的是以前的文章';
}
echo '</h1>';
?>