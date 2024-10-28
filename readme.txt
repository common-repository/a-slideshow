=== (a) Slideshow  ====
Contributors: AntonShevchuk
Donate link: http://donate.hohli.com/
Tags: slideshow, presentation, ajax, plugin, widget
Requires at least: 2.5.0
Tested up to: 2.7
Stable tag: 0.8.2

Slideshow for your blog
Based on [(a)Slideshow jQuery Plugin](http://slideshow.hohli.com)

== Description ==
This plugin and widget allows you to create dynamic, controllable slideshows or presentations for your website.

Simply define a block of HTML to be a slideshow or presentation. You can use any tags like &lt;p&gt;, &lt;img&gt;, &lt;div&gt; etc.

Based on [(a)Slideshow jQuery Plugin](http://slideshow.hohli.com)

== Installation ==

1. Upload `a-slideshow` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

Now you can create slideshow from any HTML tags (switch to HTML editor) and write example:

    [aslideshow]
        <p><label>Caption of slide one</label>Text for slide one ... </p>
        <p><label>Caption of slide two</label>Text for slide two ... </p>
        <p>Text for slide three ... w/out caption</p>                
        <img src="/wp-content/uploads/yyyy/mm/image01.jpg" alt="Slide four - is image"/>
        <a href="/wp-content/uploads/yyyy/mm/image02.jpg" title="Slide five"/>It's link to image, image load dynamically</a>                
    [/aslideshow]
    
**NOTICE**: You can use *slideshow* button (on quicktags bar)
    
You can change settings for all slideshow - go to **Settings** -> **(a) Slideshow**

**NOTICE**: Widget use a global settings of plugin (if it exist)

You can change setting for any slideshow (different from global settings), use next syntax:

    [aslideshow %options%]
        <img src="/wp-content/uploads/yyyy/mm/image01.jpg" alt="Caption 1"/>
        <img src="/wp-content/uploads/yyyy/mm/image02.jpg" alt="Caption 2"/>
        <img src="/wp-content/uploads/yyyy/mm/image03.jpg" alt="Caption 3"/>
    [/aslideshow]

Where %options% - is settings for (a)Slideshow jQuery Plugin - example:
            
    [aslideshow effect="random" play=true playframe=false controls_play=true]
        <img src="/wp-content/uploads/yyyy/mm/image01.jpg" alt="Caption 1"/>
        <img src="/wp-content/uploads/yyyy/mm/image02.jpg" alt="Caption 2"/>
        <img src="/wp-content/uploads/yyyy/mm/image03.jpg" alt="Caption 3"/>
    [/aslideshow]
    
== Frequently Asked Questions ==

= How start autoplay? =
Use next options: [aslideshow play=1 playframe=0]

= Where I can see all effects? =
On [(a)Slideshow jQuery Plugin](http://slideshow.hohli.com/docs/demo07.html) Homepage

== Screenshots ==

1. Default settings
2. 12 visual effects for transition

== Version history ==


= Version 0.8.2 =
* slideshow Id now is valid XHTML 
* update a-Slideshow jQuery plugin to 0.8.2 version

= Version 0.8.0 =
* update a-Slideshow jQuery plugin to 0.8.0 version

= Version 0.5.0 =
* new syntax of using plugin
* new version of a-Slideshow jQuery plugin

= Version 0.4.0 =
* new version of a-Slideshow jQuery plugin
* add widget

= Version 0.2.1 =
* Update (a) Slideshow jQuery Plugin to version 0.5.4
* Update jQuery to version 1.3.1 (requried for correct working fullscreen with Opera)

= Version 0.2 =
* Fixes an issue where javascript is not registered
* Changes in readme.txt

= Version 0.1 =
* Initial release version
