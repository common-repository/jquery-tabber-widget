<?php
/* Plugin Name: jQuery Tabber Widget
Plugin URI: http://www.wpbeginner.com
Description: A simple widget to add recent, popular, and random posts in a jquery tabber. This plugin is based on Jeff Star's sidebar tabber code. It also needs Hector Cabrera's <a href="http://wordpress.org/extend/plugins/wordpress-popular-posts/">WordPress Popular Posts</a> plugin installed and activated.
Version: 1.0.2
Author: Noumaan Yaqoob
Author URI: http://sabza.org
*/
class TabberWidget extends WP_Widget {
          function TabberWidget() {
                    $widget_ops = array(
                    'classname' => 'TabberWidget',
                    'description' => 'Tabs to display random popular recent posts'
          );
          $this->WP_Widget(
                    'TabberWidget',
                    'Tabber Widget',
                    $widget_ops
          );
}
          function widget($args, $instance) { // widget sidebar output

function tabber() { 
// This is a new comment
//enqueueing scripts and stylesheet
//adding plugin's stylesheet
wp_register_style('tabber-style', plugins_url('tabber-style.css', __FILE__));
wp_register_script('tabber-widget-js', plugins_url('tabber.js', __FILE__), array('jquery'));
wp_enqueue_style('tabber-style');
wp_enqueue_script('tabber-widget-js');


?>


<ul class="tabs">
	<li class="active"><a href="#tab1">Recent</a></li>
	<li><a href="#tab2">Popular</a></li>
	<li><a href="#tab3">Random</a></li>
</ul>
<div class="tab_container">
	<div id="tab1" class="tab_content">
		<ul>
			
<?php
	$args = array( 'numberposts' => '5', 'post_type' => 'post', 'post_status' => 'publish' );
	$recent_posts = wp_get_recent_posts( $args );
	foreach( $recent_posts as $recent ){
		echo '<li><a href="' . get_permalink($recent["ID"]) . '" title="Look '.esc_attr($recent["post_title"]).'" >' .   $recent["post_title"].'</a> </li> ';
	}
?>
		</ul>
	</div>
	<div id="tab2" class="tab_content" style="display:none;">
		<ul>
<?php if (function_exists('wpp_get_mostpopular')) wpp_get_mostpopular("range=weekly&order_by=avg&stats_comments=0&limit=5"); ?>

		</ul>
	</div>
	<div id="tab3" class="tab_content" style="display:none;">
		<ul>
<?php
global $post;
$posts = get_posts('orderby=rand&numberposts=5');
foreach($posts as $post) { ?>

<li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
</li>

<?php } ?>
		</ul>
	</div>
</div>
<div class="tab-clear"></div>
<?php

}

                    extract($args, EXTR_SKIP);
                    echo $before_widget; // pre-widget code from theme

$tabs = tabber(); 

echo $tabs;

                    echo $after_widget; // post-widget code from theme
          }
}
add_action(
          'widgets_init',
          create_function('','return register_widget("TabberWidget");')
);
?>