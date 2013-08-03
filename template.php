<?php

function subcoe_hcde_get_stylesheets_from_import($filename)
{
    $contents = file_get_contents($filename);
    $lines = explode("\n", $contents);
    return preg_filter('/.*url\((.*)\);.*/', '$1', $lines);
}

function subcoe_hcde_preprocess_html(&$vars)
{

  // denied page set title
  $nodes = @$vars['page']['content']['system_main']['nodes'];
  if (isset($nodes[31]) && $vars['user']->uid != 0)
  {

    $vars['head_title_array']['title'] = 'Access Denied';
    $vars['head_title'] = $vars['head_title_array']['title'] . " | " . $vars['head_title_array']['name'];

  }

  $uri = request_path();
  if (substr($uri, 0, 5) == "mycoe")
  {
      $vars['is_mycoe'] = true;
      drupal_add_css(path_to_theme() . '/css/mycoe.css');
  }
  else
  {
      $vars['is_mycoe'] = false;
  }

}

function subcoe_hcde_bbtohtml($text)
{
  $text = str_replace("[em]", "<em>", $text);
  $text = str_replace("[/em]", "</em>", $text);
  $text = str_replace("[br/]", " ", $text);
  return $text;
}

function subcoe_hcde_stripbb($text)
{
  $text = str_replace("[em]", "", $text);
  $text = str_replace("[/em]", "", $text);
  $text = str_replace("[br/]", "", $text);
  return $text;
}

function subcoe_hcde_preprocess_page(&$vars)
{
  global $user;

  $vars['files_url'] = "/" . variable_get('file_' . file_default_scheme() . '_path', conf_path() . '/files');
  $vars['theme_url'] = "/" . path_to_theme();
	
  if (isset($vars['node']))
    $vars['theme_hook_suggestions'][] = 'page__' . $vars['node']->type;

  if ($vars['is_front'] || (isset($vars['node']) && $vars['node']->type == "frontpage"))
  {
      // need to hook into page--front.tpl.php in case front page is not being viewed
      // on actual front page
      $vars['theme_hook_suggestions'][] = 'page__front';

      foreach (subcoe_hcde_get_stylesheets_from_import(path_to_theme() . '/imports-page-front.css') as $css)
        drupal_add_css(path_to_theme() . "/" . $css);

      drupal_add_js(path_to_theme() . '/js/jquery.tweet.js');
  }
  else
  {
      foreach (subcoe_hcde_get_stylesheets_from_import(path_to_theme() . '/imports-page.css') as $css)
        drupal_add_css(path_to_theme() . "/" . $css);
  }

  // hide parts of the menu that non site-admins shouldn't be bothered with
  if (isset($vars['user']) && !in_array("Site Admin", $vars['user']->roles))
  {
      drupal_add_css(path_to_theme() . '/css/hide-admin-menus.css');
  }

  $vars['styles'] = drupal_get_css();
  $vars['scripts'] = drupal_get_js();

  // remove the tabs if the user does not have update privileges
  // they can still access the pages, but it's not obvious how
  // thanks a lot, revisions module /s
  if (isset($vars['node']) && !node_access('update', $vars['node'], $user))
    $vars['tabs'] = null;

}

function subcoe_hcde_menu_navigation_links($menu_name) {
     // Don't even bother querying the menu table if no menu is specified.
     if (empty($menu_name)) {
          return array();
     }

     // Get the menu hierarchy for the current page.
     //$tree = menu_build_tree($menu_name, array('min_depth' => 1));
     
     // $tree = menu_tree_page_data($menu_name, 2); // DOES NOT WORK. WHY NOT? NFC.
     $tree = menu_tree_all_data($menu_name, null, 2);

     // create two levels of links  
     $menu = subcoe_hcde_tree_links($tree, 2);

     foreach ((array)$menu as $key => $item)
     {
        $menu[$key]['#menu-name'] = $menu_name;
		
     }

     return $menu;
 }
 
function subcoe_hcde_local_menu_navigation_links() {
     
     // figure out the current page menu
     $menu_item = menu_get_item();

     // construct path
     $href = $menu_item['href'];
     $path = $menu_item['path'];

     $special_path = false;

     $result = db_query("SELECT mlid, menu_name, plid FROM {menu_links} WHERE link_path = :menu_item ORDER BY plid ASC", array(':menu_item' => $href))->fetchObject();

  if (!is_object($result))
  {
    if (substr($path, -1) == '%') 
    {
      $path = substr($path, 0, -2);
      $special_path = true;
    }

    $result = db_query("SELECT mlid, menu_name, plid FROM {menu_links} WHERE link_path = :menu_item ORDER BY plid ASC", array(':menu_item' => $path))->fetchObject();

  }

     if (is_object($result)) {
          $link = menu_link_load($result->mlid);

          // something is terribly wrong with menu_link_get_preferred
          // and as of yet i am not sure what, so just reset the
          // damn thing
          drupal_static("menu_link_get_preferred", NULL, TRUE);

          // get the menu tree
          if ($special_path)
            menu_tree_set_path($link['menu_name'], $link['link_path']);
          
          menu_set_active_menu_names(array($link['menu_name']));
          $tree = menu_tree_page_data($link['menu_name']);
          
          // build a menu link array
          $menu = subcoe_hcde_tree_links($tree, -1);
          
          // only the leading first menu item
          $item = reset($menu);
          for ($i = 0; $i < count($menu); $i++) {
               if ($item['#original_link']['in_active_trail'] == 1) {
                    $head = $item;
                    unset($head['#below']);
                    if (isset($item['#below']) && is_array($item['#below']))
                      return array_merge(array($head), $item['#below']);
                    else
                      return array($head);
               }
               $item = next($menu);
          }
          return $menu;
     }
     return array();
}
 
function subcoe_hcde_main_menu($menu) { /* Mike says, "This looks like the old drop-down menu." */
      
     
     $html  = "<ul class=\"mainNavLinks\">";
     
     $i = 1;
     foreach ((array)$menu as $name => $menu_item) {
          $html .= "<li class=\"$name";
          if ($i == 1)
               $html .= " first";
          else if ($i == count($menu))
               $html .= " last";
          if (isset($menu_item['#below']))
               $html .= " haschildren";
          $html .= "\">\n";
          
          // create the menu link
          $html .= l($menu_item['#title'], $menu_item['#href'], array('#attributes' => $menu_item['#original_link']['#attributes']));
          
          if (isset($menu_item['#below']))
               $html .= subcoe_hcde_main_menu($menu_item['#below'], "sublinks");
          
          $html .= "</li>\n";
          $i++;
     }
     
     $html .= "</ul>";
     
     return $html;
}

// negative depths are full-trees
function subcoe_hcde_tree_links($tree, $depth = 0) {
     if ($depth == 0) {
          return array();
     } else {
          $menu = array();
          foreach ($tree as $item) {
               if (!isset($item['link']['hidden']) || !$item['link']['hidden']) {
                    $name = "menu-".$item['link']['mlid'];
                    $menu[$name] = array(
                          "#href" => $item['link']['link_path'],
                          "#title" => $item['link']['link_title'],
                          "#original_link" => array(
                              "#attributes" => array(), 
                              "in_active_trail" => $item['link']['in_active_trail']
                          )
                    );
                    if (isset($item['link']['options']['attributes'])) {
                         $menu[$name]['#original_link']['#attributes'] = $item['link']['options']['attributes'];
                    }
                    if (isset($item['below']) && $item['below'] && $depth != 1) {
                         $menu[$name]['#below'] = subcoe_hcde_tree_links($item['below'], $depth - 1);
                    }
                    $menu[$name]['options'] = $item['link']['options'];
               }
          }
          return $menu;
     }
}

function subcoe_hcde_menu_link($variables) {
     $menu_item = $variables['element'];

     $menu_item['#title'] = subcoe_hcde_bbtohtml($menu_item['#title']);

     $html = "<li";
     /*
     if ($menu_item['#original_link']['in_active_trail'])
          $html .= " id=\"in_active_trail\"";
     else
          $html .= " id=\"not-active\"";
     */
     $html .= " class=\"";
     if ($menu_item['#original_link']['in_active_trail']) {
          $html .= " currentnav"; /* Mike found that this line writes "currentnav" into the list item in the sub menu */
          $menu_item['#original_link']['#attributes']['class'][] = "selectedAccordion";
     }
     if ($menu_item['#original_link']['in_active_trail'] && isset($menu_item['#below']))
          $html .= " trigger first";
     if (isset($menu_item['#attributes']) && isset($menu_item['#attributes']['class'])) {
          foreach ((array)$menu_item['#attributes']['class'] as $class) {
               $html .= " $class";
          }
     }
     $html .= "\">";
     
     if (isset($menu_item['#original_link']['#attributes'])) {
          $html .= l($menu_item['#title'], $menu_item['#href'], array(
            'attributes' => $menu_item['#original_link']['#attributes'],
            'html' => true
          ));
     } else {
          $html .= l($menu_item['#title'], $menu_item['#href'], array('html' => true));
     }
     if (isset($menu_item['#below']) && !empty($menu_item['#below'])) {
          $html .= "<ul class=\"poop\">\n";
          $html .= subcoe_hcde_local_menu($menu_item['#below']);
          $html .= "</ul>\n";
     }

     return $html;
}

function subcoe_hcde_local_menu($menu) {
  $menu = array_filter($menu, function($a)
  {
    return ( substr($a['#href'], -1) != '%' );
  });

  $i = 1;
  $html = "";
  foreach ((array)$menu as $menu_item) {
    if ($i == 1)
      $menu_item['#attributes']['class'][] = "navSectionHead";
    else if ($i == count($menu))
      $menu_item['#attributes']['class'][] = "last";
    $html .= subcoe_hcde_menu_link(array('element' => $menu_item));
    $i++;
  }
  return $html;
}

// takes a standard drupal menu array
// returns a new array of the submenu of the current page
function subcoe_hcde_submenu($menu)
{
    $submenu = $menu;
    foreach ($menu as $menu_name => $menu_item)
    {
        // local_menus will include an additional menu item for the current page
        // we do not want to add it, and it is always a key of 0
        if (!is_numeric($menu_name) && $menu_item['#original_link']['in_active_trail'])
        {
            if (array_key_exists('#below', $menu_item) && !empty($menu_item['#below']))
                $submenu = subcoe_hcde_submenu($menu_item['#below']);
            else
            {
                $submenu = array_filter($submenu, function($e)
                {
                    return !$e['#original_link']['in_active_trail'];
                });
            }
        }
    }
    return $submenu;
}

/**
 * Implements hook_file_url_alter().
 *
 * Make all URLs be protocol relative.
 * Note: protocol relatice URLs will cause IE7/8 to download stylesheets twice.
 */
function subcoe_hcde_file_url_alter(&$url) {
  
  global $base_url;

  static $relative_base_url = NULL, $relative_base_length = NULL;

  $scheme = file_uri_scheme($url);

  // For some things (e.g., images) hook_file_url_alter can be called multiple
  // times. So, we have to be sure not to alter it multiple times. If we already
  // are relative protocol we can just return.
  // Only setup the and parse this stuff once.
  if (!$relative_base_url || !$relative_base_length) {
    $relative_base_url = '//' . file_uri_target($base_url);
    $relative_base_length = strlen($relative_base_url);
  }
  if (!$scheme && substr($url, 0, $relative_base_length) == $relative_base_url) {
    return;
  }

  // Handle the case where we have public files with the scheme public:// or
  // the case the relative path doesn't start with a /. Internal relative urls
  // have the base url prepended to them.
  if (!$scheme || $scheme == 'public') {

    // Internal Drupal paths.
    if (!$scheme) {
      $path = $url;
    }
    else {
      $wrapper = file_stream_wrapper_get_instance_by_scheme($scheme);
      $path = $wrapper->getDirectoryPath() . '/' . file_uri_target($url);
    }

    // Clean up Windows paths.
    $path = str_replace('\\', '/', $path);

    $url = $base_url . '/' . $path;
  }

  // Convert full URLs to relative protocol.
  $protocols = array('http', 'https');
  $scheme = file_uri_scheme($url);
  if ($scheme && in_array($scheme, $protocols)) {
    $url = '//' . file_uri_target($url);
  }
}

function pa($a, $silent = true)
{
  if ($silent)
    echo "<!--";
  echo "<pre>" . print_r($a, true) . "</pre>";
  if ($silent)
    echo "-->";
}

?>
