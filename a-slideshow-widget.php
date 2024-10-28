<?php
/*
Plugin Name: (a)Slideshow Widget
Plugin URI: http://slideshow.hohli.com
Description: SlideShow
Version: 0.8.2
Author: Anton Shevchuk
Author URI: http://anton.shevchuk.name
*/

/**
 * @package WordPress
 * @subpackage (a)Slideshow
 */

/**
 * widget_slideshow_init
 *
 * init widget
 */
function widget_slideshow_init() {
    if (!function_exists('register_sidebar_widget')) {
        return;
    }


    ### Function: (a) Slideshow
    function widget_slideshow($args) {
        extract($args);
        $options = get_option('a_slideshow_widget');

        if (!is_array($options)) {
            $options = array(
                'options' => '',
                'content' => '',
                'title'   => ''
            );
        }

        $options['options'] = stripslashes($options['options']);
        $options['content'] = stripslashes($options['content']);
        $options['title']   = stripslashes($options['title']);

        if (strlen($options['content']) > 0) {
            wp_enqueue_script( 'a-slideshow', get_option('siteurl') . '/wp-content/plugins/a-slideshow/lib/jquery.aslideshow.pack.js', array('jquery'));
            wp_print_scripts('a-slideshow');

            wp_enqueue_style('a-slideshow', get_option('siteurl') . '/wp-content/plugins/a-slideshow/lib/jquery.aslideshow/simple/styles.css');
            wp_print_styles('a-slideshow');

            include_once 'a-slideshow-compatibility.php';
            $default = json_encode(get_option('a_slideshow_options'));

            echo $before_widget;
            if (!empty($options['title']))
                echo $before_title . $options['title'] . $after_title;
            echo '<div id="slideshowidget">'.$options['content'].'</div>';
            echo $after_widget;

            echo '<script type="text/javascript">
                //<![CDATA[
                var settings = '.$default.';
                jQuery.noConflict();

                jQuery(document).ready(function(){';

            if (!empty($options)) {
                echo 'jQuery("#slideshowidget").slideshow(jQuery.extend({},settings,{'.$options['options'].'}));'."\n";
            } else {
                echo 'jQuery("#slideshowidget").slideshow(settings);'."\n";
            }

            echo '});
              //]]>
             </script>';
        }
    }

    ### Function: (a) Slideshow Options
    function widget_slideshow_options() {

        $options = get_option('a_slideshow_widget');

        if (!is_array($options)) {
            $options = array(
                'options' => '',
                'content' => '',
                'title'   => ''
            );
        }
        if (isset($_POST['slideshow-submit']) && $_POST['slideshow-submit']) {
            $options['title']   = strip_tags($_POST['slideshow-title']);
            $options['options'] = strip_tags($_POST['slideshow-options']);
            $options['content'] = $_POST['slideshow-content'];
            update_option('a_slideshow_widget', $options);
        }
        echo '<p style="text-align: left;"><label for="slideshow-title">';
        _e('Title', 'a-slideshow');
        echo ': </label><br/><input type="text" id="slideshow-title" name="slideshow-title" value="'.htmlspecialchars(stripslashes($options['title'])).'" class="widefat"/></p>'."\n";

        echo '<p style="text-align: left;"><label for="slideshow-options">';
        _e('Options (<a href="http://slideshow.hohli.com">examples</a>, separate parameters with commas)', 'a-slideshow');
        echo ': </label><br/><input type="text" id="slideshow-options" name="slideshow-options" value="'.htmlspecialchars(stripslashes($options['options'])).'" class="widefat"/></p>'."\n";


        echo '<p style="text-align: left;"><label for="slideshow-content">';
        _e('Content (HTML)', 'a-slideshow');
        echo ': </label><br/><textarea id="slideshow-content" name="slideshow-content" style="width:600px;height:400px;" class="widefat">'.htmlspecialchars(stripslashes($options['content'])).'</textarea></p>'."\n";

        echo '<input type="hidden" id="slideshow-submit" name="slideshow-submit" value="1" />'."\n";

    }

    // Register Widgets
    register_sidebar_widget(array('(a) Slideshow', 'a-slideshow'), 'widget_slideshow');
    register_widget_control(array('(a) Slideshow', 'a-slideshow'), 'widget_slideshow_options', 600, 200);
}

add_action('plugins_loaded', 'widget_slideshow_init');