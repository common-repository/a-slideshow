<?php
/**
 * @package WordPress
 * @subpackage (a) Slideshow
 */

$default = array(        
    'width'=>320,    // width in px
    'height'=>240,     // height in px
    'history'=>false,  // change/check location hash 
    'index'=>0,        // start from frame number N 
    'time'=>3000,      // time out beetwen slides
    'title'=>true,     // show title
    'titleshow'=>false,// show title always
    'panel'=>true,     // show controls panel
    'play'=>false,     // play slideshow
    'effect'=>'fade',  // aviable fade, scrollUp/Down/Left/Right, zoom, zoomFade, growX, growY
    'effecttime'=>1000,// aviable fast,slow,normal and any valid fx speed value
    'filter'=>true,    // remove <br/>, empty <div>, <p> and other stuff
    'nextclick'=>false,      // bind content click next slide
    'playclick'=>false,      // bind content click play/stop
    'playhover'=>false,      // bind content hover play/stop
    'playhoverr'=>false,     // bind content hover stop/play (reverse of playhover)
    'playframe'=>true,       // show frame "Play Now!" 
    'imgresize'=>false,      // resize image to slideshow window
    'imgzoom'=>true,      // resize image to slideshow window
    'imgcenter'=>true,       // set image to center
    'imgajax'=>true,         // load images from links
    'imglink'=>true,         // go to external link by click
    'linkajax'=>false,       // load html from links
    'help'=>'Plugin homepage: <a href="http://slideshow.hohli.com">(a)Slideshow</a><br/>'."\n".
            'Author homepage: <a href="http://anton.shevchuk.name">Anton Shevchuk</a>',

    'controls'=> array(         // show/hide controls elements
        'hide'=>true,    // show controls bar on mouse hover   
        'first'=>true,   // goto first frame
        'prev'=>true,    // goto previouse frame (if it first go to last)
        'play'=>true,    // play slideshow
        'next'=>true,    // goto next frame (if it last go to first)
        'last'=>true,    // goto last frame
        'help'=>true,    // show help message
        'counter'=>true  // show slide counter
    )
);

$default_custom = array(
	'theme' => 'simple'
);

// Update Options
if(!empty($_POST['Submit'])) {
    
	$a_slideshow = $_POST['a_slideshow'];
	$a_slideshow_custom = $_POST['a_slideshow_custom'];

	// change text to bool or integer
	foreach ($a_slideshow as $key => $value) {
        if     ($value == 'on')     $a_slideshow[$key] = true;
        elseif ($value == 'off')    $a_slideshow[$key] = false;
        elseif (is_numeric($value)) $a_slideshow[$key] = (int)$value;
    }
    
    if (isset($a_slideshow['controls']) && !empty($a_slideshow['controls']))
    foreach ($a_slideshow['controls'] as $key => $value) {
        if     ($value == 'on')  $a_slideshow['controls'][$key] = true;
        elseif ($value == 'off') $a_slideshow['controls'][$key] = false;
    }
    
    include_once 'a-slideshow-compatibility.php';
        
    // we need "false" value 
	$arr_false = array_keys(array_diff_key($default, $a_slideshow));
	$arr_false = array_fill_keys($arr_false, false);
	$a_slideshow = array_merge($a_slideshow, $arr_false);
	
	if (!isset($a_slideshow['controls']) or empty($a_slideshow['controls'])) $a_slideshow['controls'] = array();
	$arr_false = array_keys(array_diff_key($default['controls'], $a_slideshow['controls']));
	$arr_false = array_fill_keys($arr_false, false);
	$a_slideshow['controls'] = array_merge($a_slideshow['controls'], $arr_false);
	
	$a_slideshow_custom = array_merge($default_custom, $a_slideshow_custom);
	
	// show text message
	if (update_option('a_slideshow_options', $a_slideshow) or
		update_option('a_slideshow_custom', $a_slideshow_custom)) {
	    $text = '<font color="green">'.__('Settings Updated', 'a-slideshow').'</font>';
	} else {
	    $text = '<font color="red">'.__('No Option Updated', 'a-slideshow').'</font>';
	}
} else {
    
    $a_slideshow = get_option('a_slideshow_options');
    
    if (empty($a_slideshow)) $a_slideshow = $default;
}
?>

<div class="wrap"> 
    <div id="icon-upload" class="icon32"><br /></div>

	<h2><?php _e('(a)SlideShow Options', 'a-slideshow'); ?></h2>
	<?php if(!empty($text)) { echo '<!-- Last Action --><div id="message" class="updated fade"><p>'.$text.'</p></div>'; } ?>
    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
    <input type="hidden" name="a_slideshow[index]" value="0"/>

    <p>
        <?php _e('This is plugin based on <a href="http://slideshow.hohli.com">(a)Slideshow jQuery plugin</a>.', 'a-slideshow') ?>
        <br/>
        <br/>
        <?php _e('You can change setting for any slideshow (different from <a href="#global">global settings</a>), use next syntax:', 'a-slideshow') ?>        
        <pre><i>
            [aslideshow %options%]
                &lt;img src="/wp-content/uploads/yyyy/mm/image01.jpg" alt="Caption 1"/&gt;
                &lt;img src="/wp-content/uploads/yyyy/mm/image02.jpg" alt="Caption 2"/&gt;
                &lt;img src="/wp-content/uploads/yyyy/mm/image03.jpg" alt="Caption 3"/&gt;
            [/aslideshow]
            </i>
        </pre>        
        <?php _e('Where %options% - is settings for (a)Slideshow jQuery Plugin - example:', 'a-slideshow') ?>
        <pre>
            <i>
            [aslideshow effect="random" play=true playframe=false controls_play=true]
                &lt;img src="/wp-content/uploads/yyyy/mm/image01.jpg" alt="Caption 1"/&gt;
                &lt;img src="/wp-content/uploads/yyyy/mm/image02.jpg" alt="Caption 2"/&gt;
                &lt;img src="/wp-content/uploads/yyyy/mm/image03.jpg" alt="Caption 3"/&gt;
            [/aslideshow]
            </i>              
        </pre>        
        <?php _e('See more examples on <a href="http://slideshow.hohli.com">projects homepage</a>.', 'a-slideshow') ?>
        <br/>
        <br/>
    </p>
    <a name="global"></a>
	<table class="form-table">
	    <caption><b><?php _e('Global Settings', 'a-slideshow') ?></b></caption>
    	<tr>
    		<th scope="row" valign="top"><?php _e('Theme', 'a-slideshow'); ?></th>
    		<td>
    			<select name="a_slideshow_custom[theme]">
    			     <option value="simple" <?php if ($a_slideshow_custom['theme'] == 'simple') echo 'selected="selected"'?>>Simple</option>
    			     <option value="shadow" <?php if ($a_slideshow_custom['theme'] == 'shadow') echo 'selected="selected"'?>>Shadow</option>
    			</select>
    		</td>
    	</tr>
    	<tr>
    		<th scope="row" valign="top"><?php _e('Width', 'a-slideshow'); ?> <small><i>(<?php _e('in px', 'a-slideshow'); ?>)</i></small></th>
    		<td>
    			<input type="text" name="a_slideshow[width]" value="<?php echo stripslashes($a_slideshow['width']); ?>" size="20" />
    		</td>
    	</tr>
    	<tr>
    		<th scope="row" valign="top"><?php _e('Height', 'a-slideshow'); ?> <small><i>(<?php _e('in px', 'a-slideshow'); ?>)</i></small></th>
    		<td>
    			<input type="text" name="a_slideshow[height]" value="<?php echo stripslashes($a_slideshow['height']); ?>" size="20" />
    		</td>
    	</tr>
    	<tr>
    		<th scope="row" valign="top"><?php _e('Time', 'a-slideshow'); ?> <small><i>(<?php _e('in ms', 'a-slideshow'); ?>)</i></small></th>
    		<td>
    			<input type="text" name="a_slideshow[time]" value="<?php echo stripslashes($a_slideshow['time']); ?>" size="20" />
    		</td>
    	</tr>
        <tr>
            <th scope="row" valign="top"><?php _e('History', 'a-slideshow'); ?> <small><i>(<?php _e('check location hash', 'a-slideshow'); ?>)</i></small></th>
            <td>
                <input type="checkbox" name="a_slideshow[history]" <?php if ($a_slideshow['history']) echo 'checked="checked"'; ?>/>
            </td>
        </tr>
    	<tr>
    		<th scope="row" valign="top"><?php _e('Title', 'a-slideshow'); ?> <small><i>(<?php _e('show title bar', 'a-slideshow'); ?>)</i></small></th>
    		<td>
    			<input type="checkbox" name="a_slideshow[title]" <?php if ($a_slideshow['title']) echo 'checked="checked"'; ?>/>
    		</td>
    	</tr>
    	<tr>
    		<th scope="row" valign="top"><?php _e('Title always show', 'a-slideshow'); ?> <small><i>(<?php _e('show or use autohide', 'a-slideshow'); ?>)</i></small></th>
    		<td>
    			<input type="checkbox" name="a_slideshow[titleshow]" <?php if ($a_slideshow['titleshow']) echo 'checked="checked"'; ?>/>
    		</td>
    	</tr>
    	<tr>
    		<th scope="row" valign="top"><?php _e('Panel', 'a-slideshow'); ?> <small><i>(<?php _e('show control bar', 'a-slideshow'); ?>)</i></small></th>
    		<td>
    			<input type="checkbox" id="a_slideshow_panel" name="a_slideshow[panel]" <?php if ($a_slideshow['panel']) echo 'checked="checked"'; ?>/>
    			<script type="text/javascript">
    			    jQuery('#a_slideshow_panel').click(
    			         function() {
    			             if (jQuery(this).attr("checked")) {
    			                 jQuery('#a_slideshow_panel_controls').css('color', '#000');
    			                 jQuery('#a_slideshow_panel_controls input').removeAttr('disabled');
    			             } else {
    			                 jQuery('#a_slideshow_panel_controls').css('color', '#999');
                                 jQuery('#a_slideshow_panel_controls input').attr("disabled", "disabled");
    			             }
    			         }
    			    );
    			</script>
    		</td>
    	</tr>
    	<tr>
    	   <th scope="row">
    	       <?php _e('Panel Buttons', 'a-slideshow'); ?>
    	   </th>
    	   <td>
    	       <table width="320px" id="a_slideshow_panel_controls" style="<?php if (!$a_slideshow['panel']) echo 'color:#999'; ?>">
    			   <tr>
    			       <td>
    			         <label for="a_slideshow_controls_hide">
    			             <input type="checkbox" name="a_slideshow[controls][hide]" id="a_slideshow_controls_hide" <?php if ($a_slideshow['controls']['hide']) echo 'checked="checked"'; if (!$a_slideshow['panel']) echo 'disabled="disabled"'; ?>/>
    			             <?php _e('Auto Hide', 'a-slideshow'); ?>
    			         </label>
    			       </td>
    			       <td>
    			         <label for="a_slideshow_controls_play">
    			             <input type="checkbox" name="a_slideshow[controls][play]" id="a_slideshow_controls_hide" <?php if ($a_slideshow['controls']['play']) echo 'checked="checked"'; if (!$a_slideshow['panel']) echo 'disabled="disabled"'; ?>/>
    			             <?php _e('Play Button', 'a-slideshow'); ?>
    			         </label>
    			       </td>
    			   </tr>
    			   <tr>
    			       <td>
    			         <label for="a_slideshow_controls_first">
    			             <input type="checkbox" name="a_slideshow[controls][first]" id="a_slideshow_controls_first" <?php if ($a_slideshow['controls']['first']) echo 'checked="checked"'; if (!$a_slideshow['panel']) echo 'disabled="disabled"'; ?>/>
    			             <?php _e('Go to First Slide', 'a-slideshow'); ?>
    			         </label>
    			       </td>
    			       <td>
    			         <label for="a_slideshow_controls_last">
    			             <input type="checkbox" name="a_slideshow[controls][last]" id="a_slideshow_controls_last" <?php if ($a_slideshow['controls']['last']) echo 'checked="checked"'; if (!$a_slideshow['panel']) echo 'disabled="disabled"'; ?>/>
    			             <?php _e('Go to Last Slide', 'a-slideshow'); ?>
    			         </label>
    			       </td>
    			   </tr>
    			   <tr>
    			       <td>
    			         <label for="a_slideshow_controls_prev">
    			             <input type="checkbox" name="a_slideshow[controls][prev]" id="a_slideshow_controls_prev" <?php if ($a_slideshow['controls']['prev']) echo 'checked="checked"'; if (!$a_slideshow['panel']) echo 'disabled="disabled"'; ?>/>
    			             <?php _e('Go to Prev Slide', 'a-slideshow'); ?>
    			         </label>
    			       </td>
    			       <td>
    			         <label for="a_slideshow_controls_next">
    			             <input type="checkbox" name="a_slideshow[controls][next]" id="a_slideshow_controls_next" <?php if ($a_slideshow['controls']['next']) echo 'checked="checked"'; if (!$a_slideshow['panel']) echo 'disabled="disabled"'; ?>/>
    			             <?php _e('Go to Next Slide', 'a-slideshow'); ?>
    			         </label>
    			       </td>
    			   </tr>
    			   <tr>
    			       <td>
    			         <label for="a_slideshow_controls_help">
    			             <input type="checkbox" name="a_slideshow[controls][help]" id="a_slideshow_controls_help" <?php if ($a_slideshow['controls']['help']) echo 'checked="checked"'; if (!$a_slideshow['panel']) echo 'disabled="disabled"'; ?>/>
    			             <?php _e('Show Help', 'a-slideshow'); ?>
    			         </label>
    			       </td>
    			       <td>
    			         <label for="a_slideshow_controls_counter">
    			             <input type="checkbox" name="a_slideshow[controls][counter]" id="a_slideshow_controls_counter" <?php if ($a_slideshow['controls']['counter']) echo 'checked="checked"'; if (!$a_slideshow['panel']) echo 'disabled="disabled"'; ?>/>
    			             <?php _e('Show Counter', 'a-slideshow'); ?>
    			         </label>
    			       </td>
    			   </tr>
    			</table>
    	   </td>
    	</tr>
    	<tr>
    		<th scope="row" valign="top"><?php _e('Play', 'a-slideshow'); ?> <small><i>(<?php _e('autoplay', 'a-slideshow'); ?>)</i></small></th>
    		<td>
    			<input type="checkbox" name="a_slideshow[play]" <?php if ($a_slideshow['play']) echo 'checked="checked"'; ?>/>
    		</td>
    	</tr>
    	<tr>
    		<th scope="row" valign="top"><?php _e('Effect', 'a-slideshow'); ?> <small><i>(<?php _e('between slides', 'a-slideshow'); ?>)</i></small></th>
    		<td>
    			<select name="a_slideshow[effect]">
    			     <option value="fade" <?php if ($a_slideshow['effect'] == 'fade') echo 'selected="selected"'?>>Fade</option>
    			     <option value="scrollUp" <?php if ($a_slideshow['effect'] == 'scrollUp') echo 'selected="selected"'?>>Scroll Up</option>
    			     <option value="scrollDown" <?php if ($a_slideshow['effect'] == 'scrollDown') echo 'selected="selected"'?>>Scroll Down</option>
    			     <option value="scrollLeft" <?php if ($a_slideshow['effect'] == 'scrollLeft') echo 'selected="selected"'?>>Scroll Left</option>
    			     <option value="scrollRight" <?php if ($a_slideshow['effect'] == 'scrollRight') echo 'selected="selected"'?>>Scroll Right</option>
    			     <option value="growX" <?php if ($a_slideshow['effect'] == 'growX') echo 'selected="selected"'?>>Grow by Horisontal</option>
    			     <option value="growY" <?php if ($a_slideshow['effect'] == 'growY') echo 'selected="selected"'?>>Grow by Vertical</option>
    			     <option value="zoom" <?php if ($a_slideshow['effect'] == 'zoom') echo 'selected="selected"'?>>Zoom</option>
    			     <option value="zoomFade" <?php if ($a_slideshow['effect'] == 'zoomFade') echo 'selected="selected"'?>>Zoom with Fade</option>
    			     <option value="zoomTL" <?php if ($a_slideshow['effect'] == 'zoomTL') echo 'selected="selected"'?>>Zoom to Top-Left</option>
    			     <option value="zoomBR" <?php if ($a_slideshow['effect'] == 'zoomBR') echo 'selected="selected"'?>>Zoom to Bottom-Right</option>
    			     <option value="random" <?php if ($a_slideshow['effect'] == 'random') echo 'selected="selected"'?>>Random</option>
    			</select>
    		</td>
    	</tr>
    	<tr>
    		<th scope="row" valign="top"><?php _e('Effect Time', 'a-slideshow'); ?> <small><i>(<?php _e('in ms', 'a-slideshow'); ?>)</i></small></th>
    		<td>
    			<input type="text" name="a_slideshow[effecttime]" value="<?php echo stripslashes($a_slideshow['effecttime']); ?>" size="20" />
    		</td>
    	</tr>
    	<tr>
    		<th scope="row" valign="top"><?php _e('Filter', 'a-slideshow'); ?> <small><i>(<?php _e('remove &lt;br/&gt;, empty &lt;div&gt;, &lt;p&gt; and other stuff', 'a-slideshow'); ?>)</i></small></th>
    		<td>
    			<input type="checkbox" name="a_slideshow[filter]" <?php if ($a_slideshow['filter']) echo 'checked="checked"'; ?>/>
    		</td>
    	</tr>
    	<tr>
    		<th scope="row" valign="top"><?php _e('Next on click', 'a-slideshow'); ?></th>
    		<td>
    			<input type="checkbox" name="a_slideshow[nextclick]" <?php if ($a_slideshow['nextclick']) echo 'checked="checked"'; ?>/>
    		</td>
    	</tr>
    	<tr>
    		<th scope="row" valign="top"><?php _e('Play/stop on click', 'a-slideshow'); ?></th>
    		<td>
    			<input type="checkbox" name="a_slideshow[playclick]" <?php if ($a_slideshow['playclick']) echo 'checked="checked"'; ?>/>
    		</td>
    	</tr>
    	<tr>
    		<th scope="row" valign="top"><?php _e('Play/stop on hover', 'a-slideshow'); ?></th>
    		<td>
    			<input type="checkbox" name="a_slideshow[playhover]" <?php if ($a_slideshow['playhover']) echo 'checked="checked"'; ?>/>
    		</td>
    	</tr>
    	<tr>
    		<th scope="row" valign="top"><?php _e('Play/stop on hover', 'a-slideshow'); ?> <small><i>(<?php _e('reverse', 'a-slideshow'); ?>)</i></small></th>
    		<td>
    			<input type="checkbox" name="a_slideshow[playhoverr]" <?php if ($a_slideshow['playhoverr']) echo 'checked="checked"'; ?>/>
    		</td>
    	</tr>
    	<tr>
    		<th scope="row" valign="top"><?php _e('Play frame', 'a-slideshow'); ?> <small><i>(<?php _e('frame with big button', 'a-slideshow'); ?>)</i></small></th>
    		<td>
    			<input type="checkbox" name="a_slideshow[playframe]" <?php if ($a_slideshow['playframe']) echo 'checked="checked"'; ?>/>
    		</td>
    	</tr>
    	<tr>
    		<th scope="row" valign="top"><?php _e('Resize Images', 'a-slideshow'); ?> <small><i>(<?php _e('to slideshow size', 'a-slideshow'); ?>)</i></small></th>
    		<td>
    			<input type="checkbox" name="a_slideshow[imgresize]" <?php if ($a_slideshow['imgresize']) echo 'checked="checked"'; ?>/>
    		</td>
    	</tr>
        <tr>
    		<th scope="row" valign="top"><?php _e('Image Zoom', 'a-slideshow'); ?> <small><i>(<?php _e('zoom to smaller side and crop other', 'a-slideshow'); ?>)</i></small></th>
    		<td>
    			<input type="checkbox" name="a_slideshow[imgzoom]" <?php if ($a_slideshow['imgzoom']) echo 'checked="checked"'; ?>/>
    		</td>
    	</tr>
        <tr>
    		<th scope="row" valign="top"><?php _e('Image to center', 'a-slideshow'); ?></th>
    		<td>
    			<input type="checkbox" name="a_slideshow[imgcenter]" <?php if ($a_slideshow['imgcenter']) echo 'checked="checked"'; ?>/>
    		</td>
    	</tr>
    	<tr>
    		<th scope="row" valign="top"><?php _e('Load Images', 'a-slideshow'); ?> <small><i>(<?php _e('from links &lt;a&gt;', 'a-slideshow'); ?>)</i></small></th>
    		<td>
    			<input type="checkbox" name="a_slideshow[imgajax]" <?php if ($a_slideshow['imgajax']) echo 'checked="checked"'; ?>/>
    		</td>
    	</tr>
    	<tr>
    		<th scope="row" valign="top"><?php _e('Load HTML', 'a-slideshow'); ?> <small><i>(<?php _e('from links &lt;a&gt;', 'a-slideshow'); ?>)</i></small></th>
    		<td>
    			<input type="checkbox" name="a_slideshow[linkajax]" <?php if ($a_slideshow['linkajax']) echo 'checked="checked"'; ?>/>
    		</td>
    	</tr>
    	
    	<tr>
    		<th scope="row" valign="top"><?php _e('Help Message', 'a-slideshow'); ?> <small><i>(<?php _e('any text or HTML', 'a-slideshow'); ?>)</i></small></th>
    		<td>
    		    <textarea name="a_slideshow[help]" cols="96" rows="4"><?php echo stripslashes($a_slideshow['help']); ?></textarea>
    		</td>
    	</tr>
	</table>
	<p class="submit">
    	<input type="submit" name="Submit" class="button-primary" value="<?php _e('Save Changes', 'a-slideshow'); ?>" />
    </p>
    </form>

</div>