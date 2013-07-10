<div id="footerBG">
    <!-- container div for footer links -->
    <div id="footerMargin">
        <div id="footerSkyline">
            <h2>Explore Engineering</h2>
            <div id="footerShare">
                <!-- AddThis Button BEGIN -->
                <a class="addthis_button" href="//www.addthis.com/bookmark.php?v=250&amp;pubid=xa-4f974be934fe0fb8"><img src="//s7.addthis.com/static/btn/sm-share-en.gif" width="83" height="16" alt="Bookmark and Share" style="border:0"/></a>
                <script type="text/javascript" src="//s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4f974be934fe0fb8"></script>
                <!-- AddThis Button END -->
            </div>
        </div>
        <div id="footerlinks">
            <!-- trying out Obama-style links -->  

            <ul>

		        <?php foreach ((array)$nav_menu as $menu): ?>
		            <li>
	                    <?php
	                        echo l($menu['#title'], $menu['#href'], array()); 
	                    ?>
	                    <ul>
	                        <?php foreach ((array)$menu['#below'] as $below): ?>
	                            <li class="child-menu-item">
	                                <?php $link = l(@$below['options']['short_link_title'] ? $below['options']['short_link_title'] : $below['#title'], $below['#href'], array()); ?>
	                                <?php $link = str_replace("[br/]", "<br />", $link); ?>
	                                <?php $link = str_replace("[em]", "<em>", $link); ?>
	                                <?php echo str_replace("[/em]", "</em>", $link); ?>
	                            </li>
	                        <?php endforeach; ?>
	                    </ul>
		            </li>
		        <?php endforeach; ?> 

                <li style="width:100px;margin-right:0;">
                <ul>
                    <!-- menu grouping -->
                    <li>
                    <!-- menu within grouping -->
                    <span>Connect with Us</span>
                    <ul id="socialmenu">
                        <li><a href="http://www.linkedin.com/groups/UW-Mechanical-Engineering-1806304"><img alt="LinkedIn" title="UW Mechanical Engineering LinkedIn group" src="<?php echo $theme_url; ?>/img/icons/linkedin.png"></a></li>
                        <li><a href="https://www.facebook.com/uwmechanicalengineering?fref=ts"><img alt="Facebook" title="UW Mechanical Engineering on Facebook" src="<?php echo $theme_url; ?>/img/icons/facebook.png"></a></li>
                        <li><a href="http://www.youtube.com/playlist?list=PL9D340B538A6D724B"><img alt="YouTube" title="UW Mechanical Engineering's YouTube playlist" src="<?php echo $theme_url; ?>/img/icons/youtube.png"></a></li>
                        <li><a href="http://pipes.yahoo.com/pipes/pipe.run?_id=218812583ca0b6b6104f6b52e73b84aa&_render=rss"><img alt="RSS" title="UW Mechanical Engineering RSS feeds" src="<?php echo $theme_url; ?>/img/icons/rss.png"></a></li>
<!--                        <li><a href="//twitter.com/uwengineering"><img alt="Twitter" title="UW Engineering on Twitter" src="<?php echo $theme_url; ?>/img/icons/twitter.png"></a></li> -->
<!--                        <li><a href="/emailprefs"><img alt="email signup" title="sign up for UW and College of Engineering e-newsletters and more" src="<?php echo $theme_url; ?>http://www.engr.washington.edu/files/img/icons/gogreen_sq.png"></a></li>  -->
                    </ul>
                    </li>
                    <!-- end menu within grouping -->
                </ul>
                <!-- end menu grouping -->
                </li>
                
            </ul>
        </div>
        <!-- /#footerlinks -->
        <div class="clear">
        </div>
    </div>
    <!-- /#footerMargin -->
</div>  