<!-- Begin Footer Background -->
<div id="footerBG">

    <!-- Begin Footer Contaner -->
    <div id="footerMargin">
    
    	<!-- Begin Footer Link Farm -->
        <div id="footerlinks">  
            <ul id="footercolumns">
            <?php foreach ((array)$nav_menu as $menu): ?>
                <li class="footercolumn">
                <?php echo l($menu['#title'], $menu['#href'], array()); ?>
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
            </ul>
        </div>
        <!-- End Footer Link Farm -->
    
        <!-- Begin Bottom Footer -->
        <div id="footerMain">
            
            <!-- Begin Copyright -->
            <div id="footerLeft">
            <ul>
                <li class="centerText">
                <a href="/" onclick="pageTracker._trackPageview('/pt/fn/copyright');"><span>&copy;<span>2013</span> Department of Human Centered Design &amp; Engineering</span></a>
                </li>
                </ul>
            </div>
            <!-- End Copyright Left -->
        
            <!-- Begin Foooter Right -->
            <div id="footerRight">
                <ul>
                <li class="footerLinkBorder"><a href="/login?go=/">Login</a></li>
                <li class="footerLinkBorder"><a href="//www.washington.edu/online/privacy" onclick="pageTracker._trackPageview('/pt/fn/privacy');">Privacy</a></li>
                <li class="footerLinkBorder"><a href="//www.washington.edu/online/terms" onclick="pageTracker._trackPageview('/pt/fn/terms');">Terms</a></li>
                <li class="footerLinkBorder"><a href="<?php echo $front_page; ?>sitemap">Site Map</a></li>
                </ul>
            </div>
            <!-- End Foooter Right -->
        
        </div>
        <!-- End Bottom Footer -->
    
    </div>
    <!-- End Footer Contaner -->

</div> 
<!-- End Footer Background -->