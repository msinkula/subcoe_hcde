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
<!-- Begin Utility Nav -->
<div id="utility-nav">
    <div class="wheader patchYes colorGold sesqui">
        <div id="autoMargin">
            <div class="wlogoSmall">
                <div class="logoAbsolute">
                    <a id="wlogoLink" href="//www.washington.edu/">University of Washington</a>
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
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Utility Navigation -->

<!-- Begin Page Wrapper -->
<div id="visual-portal-wrapper">
    <div id="bg">
    
    	<!-- Begin Header -->
        <div id="header">
            <div id="logo-light" width="900"></div>
            <span id="coeLogo">
            <a href="<?php echo $front_page; ?>">Department of Human Centered Design & Engineering, University of Washington</a>
            </span>
            <div id="wsearch">
                <form id="google-cse-form" action="/search/google" method="get">
                    <input type="search" id="google-cse-search" title="Search HCDE" placeholder="Search" />
                    <input value="Search" class="formbutton" type="submit">
                </form>
            </div>
            <div class="clear"></div> <!-- Old School! -->
        </div>
        <!-- End Header -->

		<!-- Begin Mobile Navigation Section -->
        <div id="mobilenavsection">
            <h3 id="navigate"></h3>
            <div id="mobilenav" style="display: none;">
             <!-- Begin Mike's Mobile Navigation -->  
            <ul id="mobilenav-items">
            	<?php foreach ((array)$nav_menu as $menu): ?>
                <li class="top-menu-item <?php echo $menu['#menu-name']; /* I need to print "current" here */ ?>">
                    <?php 
                        $menu['#attributes'] = array();
                        echo l($menu['#title'], $menu['#href'], array('attributes' => $menu['#attributes'])); 
                    ?>
                </li>
               <?php endforeach; ?>
            </ul>
            <!-- End Mike's Mobile Navigation -->
            </div><!-- /#mobilenav -->
        </div>
		<!-- End Mobile Navigation Section -->

		<!-- Begin Panel Section -->
        <div id="panel">

			<!-- Begin Main Menu -->
            <ul id="navg">
			<?php foreach ((array)$nav_menu as $menu): ?>
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
                        </div>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
            </ul>
            <!-- End Main Menu -->


            <?php if ($page['content_top']): ?>
                <?php //print_r($page['content_top']); 
                echo render($page['content_top']); 
                //print_r(element_children($page['content_top']));?>
            <?php endif; ?>
			
            <!-- Begin Content -->
            <div id="content">
            
                    <!-- Begin Flex Slider Demo -->
                    <div class="flexslider">
                    <ul class="slides">
                    <li>
                    <img src="http://www.sccc.premiumdw.com/examples/fsimg/test1.jpg" />
                    <p class="flex-caption">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet risus eget tortor bibendum aliquam. <a href="#">Learn More &raquo;</a></p>
                    </li>
                    <li>
                    <img src="http://www.sccc.premiumdw.com/examples/fsimg/test2.jpg" />
                    <p class="flex-caption">Donec feugiat iaculis nibh sit amet varius. Sed laoreet justo vitae magna dignissim gravida. <a href="#">Learn More &raquo;</a></p>
                    </li>
                    <li>
                    <img src="http://www.sccc.premiumdw.com/examples/fsimg/test3.jpg" />
                    <p class="flex-caption">Aenean eleifend odio felis. Phasellus odio orci, volutpat cursus gravida rhoncus, placerat at est. <a href="#">Learn More &raquo;</a></p>
                    </li>
                    <li>
                    <img src="http://www.sccc.premiumdw.com/examples/fsimg/test4.jpg" />
                    <p class="flex-caption">Nulla a enim eu est congue pellentesque sit amet a lacus. Vestibulum ante ipsum primis in faucibus orci luctus. <a href="#">Learn More &raquo;</a></p>
                    </li>
                    </ul>
                    </div>
                    <!-- End Flex Slider -->
   
				<!-- Begin Front Page Showcase -->
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
                    <?php /*print $feed_icons;*/ ?>
                </div>
				<!-- End Front Page Showcase -->

				<!-- Begin Front Page News & Events Feed -->
                <div id="rightcol" class="newsevents">
                    
                    <!-- Begin News -->
					<?php if ($page['right_news']): ?>
                    <div id="news">
                    <h2><a href="/news">Latest News &raquo;</a></h2>
                    <?php echo render($page['right_news']); ?>
                    </div>
                    <?php endif; ?>
                    <!-- End News -->
                    
                    <!-- Begin Events -->
                    <div id="events">
                    <h2>
                    <a href="http://depts.washington.edu/hcde/" target="_blank">Current Events from the HCDE Blog &raquo;</a>
                    <a href="http://feeds.feedburner.com/HumanCenteredDesignEngineeringBlog" target="_blank">
                        <img src="/sites/default/files/imgs/rss20.gif" style="position:absolute;right:3px;top:4px;" alt="RSS" title="HCDE Blog RSS"/>
                    </a>
                    </h2>
                    
                    <?php if ($page['right_events']): ?>
                    <div class="content">
                        <?php
                            $events = render($page['right_events']);
                            $events = preg_replace ('/<li/', '<p', $events);
                            $events = preg_replace ('/<\/li>/', ' &raquo;</p>', $events);
                            $events = preg_replace ('/<div class="item-pst">/', '', $events);
                            $events = preg_replace ('/<ul>/', '', $events);
                            $events = preg_replace ('/(<p>)(<)(a)([^>]*>)/', '\\1'.'<!--<strong>&gt;&gt; </strong>-->'.'\\2'.'\\3'.'\\4', $events);
                            $events = preg_replace ('/(<)(p\s\S+)(>)(<)(a)([^>]*>)/', '$1'.'$2'.'$3'.'<!--<strong>&gt;&gt; </strong>-->'.'$4'.'$5'.'$6', $events);
                            $events = preg_replace ('/<\/ul>/', '', $events);
                            print $events;
                        ?>
                    </div>
                    <?php endif; ?>
                    </div>
                    <!-- End Events -->
            
                </div>
                <!-- End Front Page News & Events Feed -->

                <div class="clear">&nbsp;</div>
                
            </div>
            <!-- End Content -->
            
        </div>
        <!-- End Panel Section

        <!-- Begin Footer Links -->
        <?php include_once "linkfarm.php"; ?>
        <!-- End Footer Links -->

    </div>
    <!-- /#bg -->
    
</div>
<!-- End Page Wrapper -->

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

    $("#navigate").click(function() {
        $("#mobilenav").slideToggle();
    });

    $("#weather").weather({
        feed: "https://www.atmos.washington.edu/rss/home.rss" 
    });

    $("#google-cse-form").submit(function(e)
    {
        $(this).attr("action", $(this).attr("action") + "/" + $("#google-cse-search").val());
    });

})(jQuery);
</script>

<!-- Begin Flex Slider -->
<script type="text/javascript">
	$(window).load(function(){
	  $('.flexslider').flexslider({
		animation: "slide",
		start: function(slider){
		  $('body').removeClass('loading');
		}
	  });
	});
</script>
<!-- End Flex Slider -->
