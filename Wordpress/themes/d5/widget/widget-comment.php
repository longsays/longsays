<?php  

//widget d_comment

add_action('widgets_init', create_function('', 'return register_widget("d_comment");'));

class d_comment extends WP_Widget {
	function d_comment() {
		global $dname;
        $this->WP_Widget( 'd_comment', '主题 - 最新评论', array( 'description' => '显示网友最新评论（头像+名称+评论）' ) );
    }
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$count = empty($instance['count']) ? '5' : apply_filters('widget_count', $instance['count']);

		echo $before_title . '最新评论' . $after_title; 
		echo '<ul>';
		echo mod_newcomments( $count );
		echo '</ul>';
		echo $after_widget;
	}
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['count'] = strip_tags($new_instance['count']);
		return $instance;
	}
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'count' => '' ) );
		$count = strip_tags($instance['count']);

		echo '<p><label>显示数目：<input id="'.$this->get_field_id('count').'" name="'.$this->get_field_name('count').'" type="text" value="'.attribute_escape($count).'" size="6" /></label></p>';
	}
}

function mod_newcomments( $limit ){
	global $wpdb;
	$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved,comment_author_email, comment_type,comment_author_url, 
	SUBSTRING(comment_content,1,42) AS com_excerpt 
	FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' 
	AND comment_type = '' 
	AND post_password = '' 
	ORDER BY comment_date_gmt DESC LIMIT $limit ";
	$comments = $wpdb->get_results($sql);
	foreach ( $comments as $comment ) {
		$output .= "<li><a href=\"" . get_permalink($comment->ID) . "#comment-" . $comment->comment_ID . "\" title=\"" . $comment->post_title . "上的评论\"><em>&gt;</em>". get_avatar( $comment->comment_author_email, $size = '36', $default = get_bloginfo('wpurl').'/avatar/default.png' ) . "<strong>". strip_tags($comment->comment_author) ."：</strong>". strip_tags($comment->com_excerpt) ."</a></li>";
	}
	echo $output;
};

?>