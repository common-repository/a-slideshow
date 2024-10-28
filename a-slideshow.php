<?php
/*
Plugin Name: (a)Slideshow
Plugin URI: http://slideshow.hohli.com
Description: Slideshow for your blog. <strong>Warning!</strong> Using a new syntax, see settings page
Version: 0.8.2
Author: Anton Shevchuk
Author URI: http://anton.shevchuk.name
*/

/*  Copyright 2008  Anton Shevchuk  (email : AntonShevchuk@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * @package WordPress
 * @subpackage (a)Slideshow
 */

/** Instance of plugin */
$aSlideShow = new aSlideShow();

/** Register plugin actions */

/** Regular pages */
add_action('wp_head', array (&$aSlideShow, 'addCSS'), 1);
add_action('wp_head', array (&$aSlideShow, 'addJs'),  1);

add_action('wp_footer', array (&$aSlideShow, 'addReady'),  1);

/** Admin pages */

/** Filters */
//add_filter('the_content', array(&$aSlideShow, 'replace'), 1000);

/** Short Codes */
add_shortcode('aslideshow', array (&$aSlideShow, 'shortcode'));

if (is_admin()) {    
    add_filter('print_scripts_array', array(&$aSlideShow, 'addToolbar')); 
    add_action('admin_menu',          array(&$aSlideShow, 'adminMenu'));
    add_filter('plugin_action_links', array(&$aSlideShow, 'actionLinks'), 10, 2 );
}
/**
 * Class aSlideShow
 *
 * class_definition
 *
 * @access   public
 * @category aSlideShow
 * @package  aSlideShow
 * 
 * @access   public
 * @author   dark
 * @version  $Id: a-slideshow.php Wed Dec 17 16:36:07 EET 2008 dark$
 */
class aSlideShow 
{
    var $pluginLocation = 'a-slideshow';
    
    var $pluginUrl;
    var $pluginPath;
    
    var $slideshow = array();
    
    /**
     * aSlideShow
     *
     * @access  public
     * @return  void
     */
    function aSlideShow() 
    {
        $this->__construct();
    }
    
    /**
     * Constructor
     * 
     * @return void
     */
    function __construct()
    {
        $this->pluginLocation = substr(dirname(__FILE__), strlen(WP_PLUGIN_DIR) + 1);

        $this->pluginUrl      = WP_PLUGIN_URL . '/' . $this->pluginLocation;
        $this->pluginPath     = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . $this->pluginLocation;
        
        
        load_plugin_textdomain('a-slideshow', false, $this->pluginLocation .'/lang');
    }

    /**
     * _params
     *
     * check params
     *
     * @access  public
     * @param   array  $params  
     * @return  array  $params
     */
    function _params($params) 
    {
    	foreach ((array)$params as $key => $value) {
    	    // switch statement for true   
    	    switch (true) {    	        
    	    	case (substr($key, 0, 9) == 'controls_'):
    	    	    $subkey = substr($key, 9);
    	    	    $params['controls'][$subkey] = ($value=='true'|$value=='1')?1:0;
    	    	    unset($params[$key]);
    	    	    break;
    	    	case is_numeric($value):
    	    		$params[$key] = (int)$value;
    	    		break;    	    
    	    	case ('true' == $value):
    	    		$params[$key] = true;
    	    		break;    	    
    	    	case ('false' == $value):
    	    		$params[$key] = false;
    	    		break;
    	    	default:
    	    		break;
    	    }
    	}
    	return $params;
    }

    /**
     * addCss
     *
     * @access  public
     * @return  rettype  return
     */
    function addCss() 
    {
    	$options = get_option('a_slideshow_custom');
		if ($options && isset($options['theme'])) {
			$theme = $options['theme'];
		} else {
			$theme = 'simple';
		}
        wp_enqueue_style('a-slideshow', $this->pluginUrl . '/lib/jquery.aslideshow/'.$theme.'/styles.css');
    }
    
    /**
     * addJs
     *
     * @access  public
     * @return  rettype  return
     */
    function addJs() 
    {
        wp_enqueue_script( 'a-slideshow', $this->pluginUrl . '/lib/jquery.aslideshow.pack.js', array('jquery'));
    }
        
    /**
     * shortcode
     *
     * calback for [aslideshow] shortcodes
     *
     * @access  public
     * @param   array   $atts
     * @param   string  $content
     * @param   string  $tag  shortcode tag
     * @return  string  $content
     */
    function shortcode($atts, $content = null, $tag) 
    {
        $id = uniqid();
        
        $this->slideshow[$id] = $atts;
                               
    	return '<div id="aslideshow-'.$id.'">'.$content.'</div>';
    }
    
    /**
     * addReady
     *
     * @access  public
     * @return  rettype  return
     */
    function addReady() 
    {
        if (sizeof($this->slideshow) == 0) return true;
        
        include_once 'a-slideshow-compatibility.php';
        $options = get_option('a_slideshow_options');
        
        if ($options) {
            $default = json_encode($options);            
        } else {
            $default = '{}';
        }
        
        echo '<script type="text/javascript">
              //<![CDATA[
              var settings = '.$default.';
              jQuery.noConflict();
              jQuery(document).ready(function(){'."\n";
        
        // foreach loop for $this->slideshow array
        foreach ($this->slideshow as $id => $params) {
            if (!empty($params)) {
               $params = $this->_params($params);
        	   echo 'jQuery("#aslideshow-'.$id.'").slideshow(jQuery.extend({},settings,'.json_encode($params).'));'."\n";
            } else {
               echo 'jQuery("#aslideshow-'.$id.'").slideshow(settings);'."\n";
            }
        }
    
        echo '});
              //]]>
             </script>';
    }
    
    
    /**
     * addToolbar
     *
     * @access  public
     * @return  rettype  return
     */
    function addToolbar($array) 
    {
        wp_register_script( 'a-slideshow-toolbar', $this->pluginUrl . '/a-slideshow.js');
        
        if (in_array('quicktags', $array)) {
            array_push($array, 'a-slideshow-toolbar');
        }
        
        return $array;
    }
    
    
    /**
     * adminMenu
     *
     * settings
     *
     * @access  public
     * @return  rettype  return
     */
    function adminMenu() 
    {
    	if (function_exists('add_options_page')) {
    		add_options_page(__('(a)SlideShow', 'a-slideshow'), __('(a)SlideShow', 'a-slideshow'), 'manage_options', $this->pluginLocation.'/a-slideshow-options.php') ;
    	}
    }
    
    
    
    /**
     * actionLinks
     *
     * settings
     *
     * @access  public
     * @return  rettype  return
     */
    function actionLinks($links, $file) 
    {
		if ( $file == plugin_basename(__FILE__) )
		    array_push($links, '<a href="' . admin_url( 'options-general.php?page=a-slideshow/a-slideshow-options.php' ) . '">' . __('Settings', 'a-slideshow') . '</a>');

		return $links;
    }
}