<?php

/**
 * @file
 * Bartik's theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template normally located in the
 * modules/system folder.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 * - $hide_site_name: TRUE if the site name has been toggled off on the theme
 *   settings page. If hidden, the "element-invisible" class is added to make
 *   the site name visually hidden, but still accessible.
 * - $hide_site_slogan: TRUE if the site slogan has been toggled off on the
 *   theme settings page. If hidden, the "element-invisible" class is added to
 *   make the site slogan visually hidden, but still accessible.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['header']: Items for the header region.
 * - $page['featured']: Items for the featured region.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['triptych_first']: Items for the first triptych.
 * - $page['triptych_middle']: Items for the middle triptych.
 * - $page['triptych_last']: Items for the last triptych.
 * - $page['footer_firstcolumn']: Items for the first footer column.
 * - $page['footer_secondcolumn']: Items for the second footer column.
 * - $page['footer_thirdcolumn']: Items for the third footer column.
 * - $page['footer_fourthcolumn']: Items for the fourth footer column.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see bartik_process_page()
 */


$nav_menu = array_merge(subcoe_hcde_menu_navigation_links('main-menu'), subcoe_hcde_menu_navigation_links('menu-for-menu'));

//$news_and_events = empty($variables['node']->field_news_and_events) ? "" : $variables['node']->field_news_and_events['und'][0]['value'];

?>
<div id="utility-nav">
    <div class="wheader patchYes colorGold sesqui">
        <div id="autoMargin">
            <div class="wlogoSmall">
                <div class="logoAbsolute">
                    <a id="wlogoLink" href="//www.washington.edu/">University of Washington</a>
                </div>
            </div>
            <div id="weather">
                <a href="//www.atmos.washington.edu/weather/forecast.shtml" target="_blank">
                <img width="32" height="32" src="//www.washington.edu/static/image/weather/11.png" alt="Fog/Mist 39°F" title="Fog/Mist 39°F" class="weather-icon">
                </a>
                <div>
                    <span class="weather-city">
                        <a target="_blank" title="Click for a detailed forecast" href="//www.atmos.washington.edu/weather/forecast.shtml">
                        Seattle 39°F
                        </a>
                    </span>
                </div>
            </div>
            <div id="wtext">
                <ul>
                    <li>
                        <a href="//www.washington.edu/" class="full">UW Home</a>
                        <a href="//www.washington.edu" class="mini">UW</a>
                    </li>
                    <li>
                        <span class="border">
		<a href="//engr.uw.edu" class="full">College of Engineering</a>
        <a href="//engr.uw.edu" class="mini">CoE</a>
                        </span>
                    </li>

                    <li>
                        <span class="border">
                            <a href="//uw.edu/home/peopledir">Directories</a>
                        </span>
                    </li>                    
                    <li>
                        <span class="border">
                            <a href="//uw.edu/maps">Maps</a>&nbsp;&nbsp;&nbsp;&nbsp;
                        </span>
                    </li>
                    <li>
                        <a href="<?php echo $front_page; ?>about/contact.html">Contact Us</a>
                    </li>
                    <li>
                        <span class="border">
                            <a href="<?php echo $front_page; ?>sitemap">Site Map</a>
                        </span>
                    </li>
                    <li>
                        <span class="border">
                            <a href="https://depts.washington.edu/myme2">MyME</a>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- /#uwheader -->
<div id="visual-portal-wrapper">
    <div id="bg">
        <div id="header">
            <div id="logo-light" width="900"></div>
            <span id="coeLogo">
            <a href="<?php echo $front_page; ?>">Department of Mechanical Engineering, University of Washington</a>
            </span>
            <div id="wsearch">
                <form id="google-cse-form" action="/search/google" method="get">
                    <input type="search" id="google-cse-search" title="Search CoE" placeholder="Search" />
                    <input value="Go" class="formbutton" type="submit">
                </form>
            </div>
<!--            <p class="tagline">
                <span class="taglineGold">Innovation.</span> It's the Washington Way.
            </p>
-->
            <div class="clear"></div>

        </div>
        <!-- /#header -->

        <div id="mobilenavsection">

            <h3 id="navigate"></h3>
            <div id="mobilenav" style="display: none;">

                <div id="mobilecrumbs">
                    Home
                </div>

                <?php foreach ($nav_menu as $menu_item): ?>
                    <div class="mobilenavlink">
                        <a href="<?php echo $menu_item['#href']; ?>">
                            <?php echo subcoe_hcde_bbtohtml($menu_item['#title']); ?>
                        </a>
                    </div>
                <?php endforeach; ?>

                <div class="clear"></div>

            </div>
            <!-- /#mobilenav -->

        </div> <!-- /#mobilenavsection -->


        <div id="panel">

            <ul id="navg">
                <?php foreach ((array)$nav_menu as $menu): ?>
                	<?php 
                    $fid = isset($menu['options']['image_fid']) ? $menu['options']['image_fid']['fid'] : 0;
                		$image_file = file_load($fid);
                    $image_url  = $image_file ? file_create_url($image_file->uri) : null;
                    $image_cap = @$menu['options']['image_caption'];
                    $image_alt = @$menu['options']['image_alt'];
                  ?>
                    <li class="top-menu-item <?php echo $menu['#menu-name']; ?>">
                        <span class="top-link">
                            <?php 
                                $menu['#attributes'] = array();
                                if (strlen($menu['#title']) < 12)
                                    $menu['#attributes']['class'][] = 'oneline';
                                echo l($menu['#title'], $menu['#href'], array('attributes' => $menu['#attributes'])); 
                            ?>
                        </span>
                        <?php if (isset($menu['#below'])): ?>
	                        <div class="mainNavSubNav">
	                            <ul class="mainNavLinks">
	                                <?php foreach ((array)$menu['#below'] as $below): ?>
	                                    <li class="child-menu-item">
	                                        <?php $link = l($below['#title'], $below['#href'], array('attributes' => $below['#original_link']['#attributes'])); ?>
	                                        <?php $link = str_replace("[br/]", "<br />", $link); ?>
	                                        <?php $link = str_replace("[em]", "<em>", $link); ?>
	                                        <?php echo str_replace("[/em]", "</em>", $link); ?>
	                                    </li>
	                                <?php endforeach; ?>
	                            </ul>
	                            <div class="mainNavBlurb">
	                                <img src="<?php echo @$image_url; ?>" alt="<?php echo @$image_alt; ?>" title="<?php echo @$image_alt; ?>" class="image image-menu" width="200"><br>
	                                <p><?php echo @$image_cap; ?></p>
	                                <p>&nbsp;</p>                  
	                            </div>
	                            <div class="clear"></div>
	                        </div>
                    	<?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>


            <?php if ($page['content_top']): ?>
                <?php //print_r($page['content_top']); 
                echo render($page['content_top']); 
                //print_r(element_children($page['content_top']));?>
            <?php endif; ?>
			
            <!-- Begin Content -->
            <div id="content">
            
                    <!-- Begin Flex Slider -->
                    <section class="slider">
                    <div class="flexslider">
                    <ul class="slides">
                    <li>
                    <img src="http://www.sccc.premiumdw.com/examples/fsimg/test1.jpg" />
                    <figcaption>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet risus eget tortor bibendum aliquam eget in mi.</figcaption>
                    </li>
                    <li>
                    <img src="http://www.sccc.premiumdw.com/examples/fsimg/test2.jpg" />
                    <figcaption>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet risus eget tortor bibendum aliquam eget in mi.</figcaption>
                    </li>
                    <li>
                    <img src="http://www.sccc.premiumdw.com/examples/fsimg/test3.jpg" />
                    <figcaption>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet risus eget tortor bibendum aliquam eget in mi.</figcaption>
                    </li>
                    <li>
                    <img src="http://www.sccc.premiumdw.com/examples/fsimg/test4.jpg" />
                    <figcaption>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet risus eget tortor bibendum aliquam eget in mi.</figcaption>
                    </li>
                    </ul>
                    </div>
                    </section>
                    <!-- End Flex Slider -->
   
            		<!-- Begin Slider 
                    <ul class="bxslider">
                    <li><img src="http://eranikus-3.engr.washington.edu/sites/eranikus-3.engr.washington.edu/themes/subcoe_hcde/img/slider/2013graduation_splash.jpg" title="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet risus eget tortor bibendum aliquam eget in mi. " /></li>
                    <li><img src="http://eranikus-3.engr.washington.edu/sites/eranikus-3.engr.washington.edu/themes/subcoe_hcde/img/slider/darivanh.jpg" title="Phasellus ultrices rutrum nisl in vestibulum. Ut sodales nisl in felis suscipit in sollicitudin metus varius. Pellentesque porttitor nibh quis nisi aliquam. " /></li>
                    <li><img src="http://eranikus-3.engr.washington.edu/sites/eranikus-3.engr.washington.edu/themes/subcoe_hcde/img/slider/jellyfish.jpg" title="Nulla a enim eu est congue pellentesque sit amet a lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia." /></a></li>
                    </ul>
                     End Slider -->
                    
                <div id="showcase">
                    <?php if ($tabs): ?>
                    
                        <div class="tabs">
                            <?php print render($tabs); ?>
                        </div>
                    
                    <?php endif; ?>
                    <?php print render($page['help']); ?>
                        <?php if ($action_links): ?>
                            <ul class="action-links">
                                <?php print render($action_links); ?>
                            </ul>
                        <?php endif; ?>

                    <?php print render($page['content']); ?>

                    <?php echo render($page['content_bottom']); ?>

                    <?php print $feed_icons; ?>

                    
                </div><!-- /#showcase -->


                <div id="rightcol">

                    <h2>
                        <a href="/news/news.html">ME News &amp; Events</a>
                        <a href="http://pipes.yahoo.com/pipes/pipe.run?_id=218812583ca0b6b6104f6b52e73b84aa&_render=rss">
                            <img src="<?php echo $theme_url; ?>/img/rss.png" height="16" style="position:absolute;right:3px;top:4px;" alt="RSS" title="ME News RSS feed">
                        </a>
                    </h2>

                    <?php echo render($page['right']); ?>
                             

                </div> <!-- /#rightcol -->

                <div class="clear"></div>
            </div> <!-- /#content -->
        </div> <!-- /#panel -->

                    
        <?php include_once "linkfarm.php"; ?>

        <!-- /#obama -->
        <div id="footerMain">
            <div id="footerLeft">
                <ul>
                    <li class="centerText">
                    <a href="/" onclick="pageTracker._trackPageview('/pt/fn/copyright');"><span>&copy;<span>2013</span> UW Department of Human Centered Design &amp; Engineering</span></a>
                    </li>
                </ul>
            </div>
            <div id="footerRight">
                <ul>
                    <li class="centerText">
                    <a href="//www.seattle.gov/" onclick="pageTracker._trackPageview('/pt/fn/seattle');"><span>SEATTLE, WASHINGTON</span></a>
                    </li>
                </ul>
            </div>
            <div id="footerCenter">
                <ul>
                    <li>
                    <a href="/about/contact.html">Contact Us</a>
                    </li>
                    <li class="footerLinkBorder">
                    <a href="https://depts.washington.edu/myme2">MyME</a>
                    </li>
                    <li class="footerLinkBorder">
                    <a href="/login?go=/">Login</a>
                    </li>
                    <li class="footerLinkBorder">
                    <a href="//www.washington.edu/online/privacy" onclick="pageTracker._trackPageview('/pt/fn/privacy');">Privacy</a>
                    </li>
                    <li class="footerLinkBorder">
                    <a href="//www.washington.edu/online/terms" onclick="pageTracker._trackPageview('/pt/fn/terms');">Terms</a>
                    </li>
                </ul>
            </div>
            <!-- /#footerCenter -->
        </div>
        <!-- /#footerMain -->
    </div>
    <!-- /#bg -->
</div>
<!-- /#visual-portal-wrapper -->

<div id="video-viewer-modal" style="display: none;"></div>
<div id="video-viewer-pane" style="display: none;">
    <div id="video-viewer">
        <div id="video-viewer-title"></div>
        <div id="video-viewer-close">Close</div>
        <div id="video-viewer-video"></div>
        <div id="video-viewer-description"></div>
    </div>
</div>

<script>
(function($) 
{
	
	/* Box Slider */
	$('.bxslider').bxSlider({
		mode: 'fade',
		captions: true,
		auto: true,
		autoControls: true,
		speed: 1000,
		pause: 7000
		}); 
		
	/* Flex Slider */
	SyntaxHighlighter.all();
    });
    $(window).load(function(){
      $('.flexslider').flexslider({
        animation: "slide",
        start: function(slider){
          $('body').removeClass('loading');
        }
      });

    $("#weather").weather({
        feed: "https://www.atmos.washington.edu/rss/home.rss" 
    });

    $("#navigate").click(function() {
        $("#mobilenav").slideToggle();
    });

    var midcolRotationImgs = 
    [
        {
            file: 'spr-cherryblossoms-students.jpg',
            title: 'Spring means cherry blossoms on the Quad'
        },
        {
            file: 'spr-sum-fal-students-walking-grassy.jpg',
            title: 'Parrington Lawn on the north side of campus'
        },
        {
            file: 'spr-sum-fal-bikes-rack.jpg',
            title: 'Dedicated paths and marked bike lanes draw bicyclists year-round'
        },
        {
            file: 'spr-sum-fal-class-wetlands-clouds.jpg',
            title: 'Wetlands area on campus becomes an outdoor classroom and lab'
        }
    ];

    var img = midcolRotationImgs[Math.floor(Math.random() * midcolRotationImgs.length)];
    $("#midcol-rotation")
        .attr("src", "<?php echo $files_url; ?>/page-front/midcol-rotation/" + img.file)
        .attr("title", img.title)
        .attr("alt", img.title);

    $(".tweet").tweet({
        username: "uwengineering",
        join_text: "auto",
        avatar_size: 0,
        count: 3,
        auto_join_text_default: "",
        auto_join_text_ed: "",
        auto_join_text_ing: "",
        auto_join_text_reply: "",
        auto_join_text_url: "",         
        loading_text: "loading tweets...",
        template: "{avatar}{text}{join}<span class='tweet_time'>({time})</span>",   // [string or function] template used to construct each tweet <li> - see code for available vars

    });

    $("#google-cse-form").submit(function()
    {
        $(this).attr("action", $(this).attr("action") + "/" + $("#google-cse-search").val());
    });

})(jQuery);
</script>