<?php  

include('widget-banner.php');
include('widget-comment.php');

add_action('widgets_init','unregister_search_widget');
function unregister_search_widget(){
    unregister_widget('WP_Widget_Search');
    unregister_widget('WP_Widget_Recent_Comments');
}

?>