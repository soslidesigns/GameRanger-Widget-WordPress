<?php
/*
  Plugin Name: GameRanger Widget
  Description: This widget allows people to add you and displays your GameRanger status if your online or not. 
  Author: So Sli Designs
  Version: 1.0
  Author URI: http://www.soslidesigns.com
 */

class gr_widget extends WP_Widget {

    function gr_widget(){ 
        $this->WP_Widget( false, "GameRanger Widget", array( 'description' => 'This widget displays your GameRanger status and allows people to add you!' ) );
    }

    function widget($args, $instance) {
        global $wpdb;
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        if (!empty($id)) {
			$userinfo = (isset($instance['userinfo'])) ? $instance['userinfo'] : '';
			$gamelist = isset($instance['gamelist']) ? '<strong><div align=left>Available Games:</div></strong> <br />' . $instance['gamelist'] : '';
			$showinfo = !empty($instance['showinfo']) && $instance['showinfo'] == '1' ? '' : 'www.soslidesigns.com';
            $widget = "<a href='gr://info/$userinfo'><img src='http://www.gameranger.com/indicator/$userinfo' title='Online Status!' /></a><br /><div style='text-align:right;'><strong>[</strong> <a href='gr://info/$userinfo' title='Click Me To Show Info and Add to Friends!'>My Info</a> <strong>]</strong><br />$gamelist<br /><a href='http://$showinfo' target='_blank'>$showinfo</a></div>";
            echo $before_widget;
            echo $before_title . $title . $after_title;
            echo $widget;
            echo $after_widget;
        }
    }

    function update($new_instance, $old_instance) {
        //save widget settings
        $instance = array();
        $instance['title'] = strip_tags($new_instance['title']);
		$instance['userinfo'] = strip_tags($new_instance['userinfo']);
		$instance['gamelist'] = wp_filter_post_kses($new_instance['gamelist']);
        $instance['showinfo'] = isset($new_instance['showinfo']) && $new_instance['showinfo'] == 0 ? 0 : 1;
		
        return $instance;
    }

    function form($instance) {
        $title = (isset($instance['title'])) ? $instance['title'] : '';
		$userinfo = (isset($instance['userinfo'])) ? $instance['userinfo'] : '';
		$gamelist = format_to_edit($instance['gamelist']);
        $showinfo = !empty($instance['showinfo']) ? 1 : 0;
				
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><strong>Title:</strong> </label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>		
        <p>
            <label for="<?php echo $this->get_field_id('userinfo'); ?>"><strong>Account ID:</strong> </label> 
            <input class="widefat" id="<?php echo $this->get_field_id('userinfo'); ?>" name="<?php echo $this->get_field_name('userinfo'); ?>" type="text" value="<?php echo esc_attr($userinfo); ?>" />
			<br />
				<?php echo '<img src="' . plugins_url( 'images/help-1.jpg' , __FILE__ ) . '" > '; ?>
			<br />
			This is what your user info looks like in <a href="http://www.gameranger.com" target="_blank">GameRanger</a>.
			<br />
			<font size="-6" color="#CC0000"><strong>*You need GameRanger installed and enabled to be able to click on links!</strong></font>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('gamelist'); ?>">Available Games </label> 
			<textarea class="widefat monospace" rows="16" cols="20" id="<?php echo $this->get_field_id('gamelist'); ?>" name="<?php echo $this->get_field_name('gamelist'); ?>"><?php echo $gamelist; ?></textarea>
			<br />
			<font size="-6" color="#CC0000"><strong>*Above you can enter your list of available games you have for game ranger.
			<br />
			*HTML is enabled!
			</strong></font>
        </p>						
        <p>
       	<label for="<?php echo $this->get_field_id('showinfo'); ?>"><strong>Show Made By URL:</strong> </label>
            <input  id="<?php echo $this->get_field_id('showinfo'); ?>" name="<?php echo $this->get_field_name('showinfo'); ?>" type="checkbox" value="0" <?php echo esc_attr($showinfo) == "0" ? 'checked' : ''; ?> />
        </p>	
        <?php
    }

}

//Register the widget

add_action( 'widgets_init', 'register_gr_widget' );

function register_gr_widget() { register_widget( 'gr_widget' ); }

apply_filters('plugins_url', $url, $path, $plugin);

?>
