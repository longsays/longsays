<?php  

//widget d_banner

add_action('widgets_init', create_function('', 'return register_widget("d_banner");'));

class d_banner extends WP_Widget {
	function d_banner() {
		global $dname;
        $this->WP_Widget( 'd_banner', '主题 - 侧栏广告', array( 'description' => '显示侧栏广告' ) );
    }
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '0' : apply_filters('widget_name', $instance['title']);
		$url = empty($instance['url']) ? '0' : apply_filters('widget_url', $instance['url']);
		$pic = empty($instance['pic']) ? '0' : apply_filters('widget_pic', $instance['pic']);

		echo '<a href="'.$url.'"><img src="'.$pic.'" alt="'.$title.'"></a>';
		echo $after_widget;
	}
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['url'] = $new_instance['url'];
		$instance['pic'] = $new_instance['pic'];
		return $instance;
	}
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'url' => '' ,'pic' => '' ) );
		$title = $instance['title'];
		$url = $instance['url'];
		$pic = $instance['pic'];

		echo '<p><label>名称：<input placeholder="Name" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.attribute_escape($title).'" class="widefat" /></label></p>';
		echo '<p><label>链接：<input placeholder="http://" id="'.$this->get_field_id('url').'" name="'.$this->get_field_name('url').'" type="text" value="'.attribute_escape($url).'" class="widefat" /></label></p>';
		echo '<p><label>图片（宽度=220px）：<input placeholder="" id="'.$this->get_field_id('pic').'" name="'.$this->get_field_name('pic').'" type="text" value="'.attribute_escape($pic).'" class="widefat" /></label></p>';
		echo '<p style="text-align:center"><a href="'.$url.'"><img src="'.$pic.'" alt="'.$title.'"></a></p>';
		
	}
}

?>