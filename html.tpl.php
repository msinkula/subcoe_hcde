<?php

/**
 * @file
 * Default theme implementation to display the basic html structure of a single
 * Drupal page.
 *
 * Variables:
 * - $css: An array of CSS files for the current page.
 * - $language: (object) The language the site is being displayed in.
 *   $language->language contains its textual representation.
 *   $language->dir contains the language direction. It will either be 'ltr' or 'rtl'.
 * - $rdf_namespaces: All the RDF namespace prefixes used in the HTML document.
 * - $grddl_profile: A GRDDL profile allowing agents to extract the RDF data.
 * - $head_title: A modified version of the page title, for use in the TITLE
 *   tag.
 * - $head_title_array: (array) An associative array containing the string parts
 *   that were used to generate the $head_title variable, already prepared to be
 *   output as TITLE tag. The key/value pairs may contain one or more of the
 *   following, depending on conditions:
 *   - title: The title of the current page, if any.
 *   - name: The name of the site.
 *   - slogan: The slogan of the site, if any, and if there is no title.
 * - $head: Markup for the HEAD section (including meta tags, keyword tags, and
 *   so on).
 * - $styles: Style tags necessary to import all CSS files for the page.
 * - $scripts: Script tags necessary to load the JavaScript files and settings
 *   for the page.
 * - $page_top: Initial markup from any modules that have altered the
 *   page. This variable should always be output first, before all other dynamic
 *   content.
 * - $page: The rendered page content.
 * - $page_bottom: Final closing markup from any modules that have altered the
 *   page. This variable should always be output last, after all other dynamic
 *   content.
 * - $classes String of classes that can be used to style contextually through
 *   CSS.
 *
 * @see template_preprocess()
 * @see template_preprocess_html()
 * @see template_process()
 */

$bg_file = file_load(theme_get_setting('background_image_fid'));
$bg_url  = $bg_file ? file_create_url($bg_file->uri) : null;

?><!DOCTYPE html>
<html lang="en-US">
<head>
  <?php print $head; ?>

  <title><?php print subcoe_hcde_stripbb($head_title); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" />
  
  <!--[if lt IE 10]>
  	<link href="//fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700" rel="stylesheet" type="text/css" />
  	<link href="/<?php echo path_to_theme(); ?>/css/ie-font.css" rel="stylesheet" type="text/css" media="screen" />
  <![endif]-->
  <!--[if !IE]><!-->
  	<link href="//fonts.googleapis.com/css?family=PT+Sans+Narrow:300,700" rel="stylesheet" type="text/css" />
	<link href="/<?php echo path_to_theme(); ?>/css/font.css" rel="stylesheet" type="text/css" media="screen" />
  <!--<![endif]-->

  <?php print $styles; ?>
  <link id="mediaqueries" rel="stylesheet" type="text/css" href="/<?php echo path_to_theme(); ?>/css/respond.css" />
  <style type="text/css">
  <?php if ($bg_url): ?>
  	#visual-portal-wrapper {
  		background: url(<?php echo $bg_url; ?>) center top repeat;
  	}
  	<?php endif; ?>
  </style>
  <!--<link id="mediaqueries" rel="stylesheet" type="text/css" href="/<?php echo path_to_theme(); ?>/css/respond.css" />-->
  <?php print $scripts; ?>

<!-- Begin Flex Slider --> 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="//eranikus-3.engr.washington.edu/sites/eranikus-3.engr.washington.edu/themes/subcoe_hcde/js/jquery.flexslider.js"></script>
<link rel="stylesheet" href="//eranikus-3.engr.washington.edu/sites/eranikus-3.engr.washington.edu/themes/subcoe_hcde/css/flexslider.css" type="text/css" media="screen" />
<!-- End Flex Slider --> 

</head>
<body class="<?php print $classes; ?><?php print ($is_mycoe) ? " mycoe" : ""; ?>" <?php print $attributes;?>>
  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
  </div>
  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php print $page_bottom; ?>
  <script src="//www.washington.edu/static/alert.js" type="text/javascript"></script>
</body>
</html>
