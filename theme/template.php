<?php
/**
 * Template file for Starter basetheme.
 */

$path_to_theme = path_to_theme();

include_once './' . $path_to_theme . '/inc/css.php';
include_once './' . $path_to_theme . '/inc/js.php';
include_once './' . $path_to_theme . '/inc/icons.php';
include_once './' . $path_to_theme . '/inc/form.php';
include_once './' . $path_to_theme . '/inc/table.php';
include_once './' . $path_to_theme . '/inc/views.php';
include_once './' . $path_to_theme . '/inc/menu.php';
include_once './' . $path_to_theme . '/inc/system.php';
include_once './' . $path_to_theme . '/inc/date.php';
include_once './' . $path_to_theme . '/inc/misc.php';
include_once './' . $path_to_theme . '/inc/forum.php';
include_once './' . $path_to_theme . '/inc/blockify.php';
include_once './' . $path_to_theme . '/inc/panels.php';

// Auto-rebuild the theme registry during theme development.
if (theme_get_setting('starter_rebuild_registry')) {
  system_rebuild_theme_data();
}

/**
 * Implements HOOK_theme().
 */
function starter_theme(){
  return array(
    'nomarkup' => array (
      'render element' => 'element',
       'function' => 'theme_nomarkup',
     ),
  );
}

/*
  All the preprocess magic.
*/
function starter_preprocess(&$vars, $hook) {
  global $theme;
  global $base_url;
  $path = drupal_get_path('theme', $theme);
  $theme_path = drupal_get_path('theme', 'starter');

  //For third-generation iPad with high-resolution Retina display
  $appletouchicon = '<link rel="apple-touch-icon" sizes="144x144" href="' . $base_url .'/'. $path . '/apple-touch-icon-144x144.png">';
  //For iPhone with high-resolution Retina display
  $appletouchicon .= '<link rel="apple-touch-icon" sizes="114x114" href="' . $base_url .'/'. $path . '/apple-touch-icon-114x114.png">'. "\n";
  //For first- and second-generation iPad:
  $appletouchicon .= '<link rel="apple-touch-icon" sizes="72x72" href="' . $base_url .'/'.  $path . '/apple-touch-icon-72x72.png">' . "\n";
  //For non-Retina iPhone, iPod Touch, and Android 2.1+ devices
  $appletouchicon .=  '<link rel="apple-touch-icon" href="' . $base_url .'/'.  $path . '/apple-touch-icon.png">' . "\n";
  $appletouchicon .=  '<link rel="apple-touch-startup-image" href="' . $base_url .'/'.  $path . '/apple-startup.png">' . "\n";
  /*
    Go through all the hooks of drupal and give em epic love
  */

  if ( $hook == "html" ) {
    // =======================================| HTML |========================================

    //get the path for the site
    $vars['starter_path'] = $base_url .'/'. $theme_path;

    //lets make it a tiny bit more readable in the html.tpl.php
    //gets processed in mothership_process_html
    $vars['html_attributes_array'] = array(
      'lang' => $vars['language']->language,
      'dir' => $vars['language']->dir,
    );

    $metatags = array(
      '#tag' => 'meta',
      '#attributes' => array(
        'name' => 'Generator',
        'content' => 'Drupal Starter',
      ),
    );
    drupal_add_html_head($metatags, 'my_meta');

    //custom 403/404
    $headers = drupal_get_http_header();
    if(isset($headers['status']) ){
      if($headers['status'] == '404 Not Found'){
        $vars['theme_hook_suggestions'][] = 'html__404';
      }
    }

    //LIBS
    //We dont wanna add modules just to put in a js file so were adding em here instead

    //--- modernizr love CDN style for the lazy ones
    /*if (theme_get_setting('starter_modernizr')) {
      drupal_add_js('http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.0.6/modernizr.min.js', 'external');
    }*/

    $vars['appletouchicon'] = $appletouchicon;

    //-----<body> CSS CLASSES  -----------------------------------------------------------------------------------------------
    //Remove & add classes body

    /*if (theme_get_setting('mothership_classes_body_html')) {
      $vars['classes_array'] = array_values(array_diff($vars['classes_array'],array('html')));
    }

    if (theme_get_setting('mothership_classes_body_front')) {
      $vars['classes_array'] = array_values(array_diff($vars['classes_array'],array('not-front')));
      $vars['classes_array'] = array_values(array_diff($vars['classes_array'],array('front')));
    }

    if (theme_get_setting('mothership_classes_body_loggedin')) {
      $vars['classes_array'] = array_values(array_diff($vars['classes_array'],array('logged-in')));
      $vars['classes_array'] = array_values(array_diff($vars['classes_array'],array('not-logged-in')));
    }

    if (theme_get_setting('mothership_classes_body_layout')) {
      $vars['classes_array'] = array_values(array_diff($vars['classes_array'],array('two-sidebars')));
      $vars['classes_array'] = array_values(array_diff($vars['classes_array'],array('one-sidebar sidebar-first')));
      $vars['classes_array'] = array_values(array_diff($vars['classes_array'],array('one-sidebar sidebar-second')));
      $vars['classes_array'] = array_values(array_diff($vars['classes_array'],array('no-sidebars')));
    }

    if (theme_get_setting('mothership_classes_body_toolbar')) {
      $vars['classes_array'] = array_values(array_diff($vars['classes_array'],array('toolbar')));
      $vars['classes_array'] = array_values(array_diff($vars['classes_array'],array('toolbar-drawer')));
    }*/

    $vars['classes_array'] = array_values(array_diff($vars['classes_array'], array('html', 'not-front', 'logged-in', 'not-logged-in', 'toolbar', 'toolbar-drawer')));

    //if (theme_get_setting('mothership_classes_body_pagenode')) {
      $vars['classes_array'] = preg_grep('/^page-node/', $vars['classes_array'], PREG_GREP_INVERT);
    //}

    //if (theme_get_setting('mothership_classes_body_nodetype')) {
      $vars['classes_array'] = preg_grep('/^node-type/', $vars['classes_array'], PREG_GREP_INVERT);
    //}

    /*if (theme_get_setting('mothership_classes_body_path')) {
      $path_all = drupal_get_path_alias($_GET['q']);
      $vars['classes_array'][] = drupal_html_class('path-' . $path_all);
    }*/

    /*if (theme_get_setting('mothership_classes_body_path_first')) {
      $path = explode('/', $_SERVER['REQUEST_URI']);
      if($path['1']){
        $vars['classes_array'][] = drupal_html_class('pathone-' . $path['1']);
      }
    }*/

  }
  elseif ($hook == "page") {
    // =======================================| PAGE |========================================

    //New template suggestions

    // page--nodetype.tpl.php
    if ( isset($vars['node']) ){
      $vars['theme_hook_suggestions'][] = 'page__' . $vars['node']->type;
    }

    //custom 404/404
    $headers = drupal_get_http_header();

    if (isset($headers['status'])) {
      if($headers['status'] == '404 Not Found'){
        $vars['theme_hook_suggestions'][] = 'page__404';
      }
    }

    //remove the "theres no content default yadi yadi" from the frontpage
    unset($vars['page']['content']['system_main']['default_message']);

    // Remove the block template wrapper from the main content block.
    if (!empty($vars['page']['content']['system_main']) AND
      isset($vars['page']['content']['system_main']['#theme_wrappers']) AND
      is_array($vars['page']['content']['system_main']['#theme_wrappers'])
    ) {
      $vars['page']['content']['system_main']['#theme_wrappers'] = array_diff($vars['page']['content']['system_main']['#theme_wrappers'], array('block'));
    }


    /*-
      USER ACCOUNT TABS
      Removes the tabs from user  login, register & password
      fixes the titles to so no more "user account" all over
    */
    if (FALSE) {
      switch (current_path()) {
        case 'user':
          $vars['title'] = t('Login');
          unset( $vars['tabs'] );
          break;
        case 'user/register':
          $vars['title'] = t('New account');
          unset( $vars['tabs'] );
          break;
        case 'user/password':
          $vars['title'] = t('I forgot my password');
          unset( $vars['tabs'] );
          break;

        default:
          # code...
          break;
      }
    }

  }
  elseif ( $hook == "region" ) {
    // =======================================| region |========================================
    $vars['classes_array'] = array_values(array_diff($vars['classes_array'],array('region')));

  }
  elseif ( $hook == "block" ) {
    // =======================================| block |========================================
    //block-subject should be called title so it actually makes sence...
    $vars['id_block'] = "";
    $vars['classes_array'] = array_values(array_diff($vars['classes_array'],array('block')));

    /*if (theme_get_setting('mothership_classes_block')) {
      $vars['classes_array'] = preg_grep('/^block-/', $vars['classes_array'], PREG_GREP_INVERT);
    }*/

    /*if (theme_get_setting('mothership_classes_block_contextual')) {
      $vars['classes_array'] = array_values(array_diff($vars['classes_array'], array('contextual-links-region')));
    }*/

    $vars['id_block'] = ' id="' . $vars['block_html_id'] . '"';

    /*if (theme_get_setting('mothership_classes_block_id_as_class')) {
      $vars['classes_array'][] = $vars['block_html_id'];
    }*/

    //adds title class to the block ... OMG!
    $vars['title_attributes_array']['class'][] = 'title';
    $vars['content_attributes_array']['class'][] = 'block-content';

    //add a theme suggestion to block--menu.tpl so we dont have create a ton of blocks with <nav>
    if (
      ($vars['elements']['#block']->module == "system" AND $vars['elements']['#block']->delta == "navigation") OR
      ($vars['elements']['#block']->module == "system" AND $vars['elements']['#block']->delta == "main-menu") OR
      ($vars['elements']['#block']->module == "system" AND $vars['elements']['#block']->delta == "user-menu") OR
      ($vars['elements']['#block']->module == "admin" AND $vars['elements']['#block']->delta == "menu") OR
       $vars['elements']['#block']->module == "menu_block"
    ){
      $vars['theme_hook_suggestions'][] = 'block__menu';
    }

    //add a theme hook suggestion to the bean so its combinated with its reagion
    if ($vars['elements']['#block']->module == "bean" AND $vars['elements']['bean']){
      $vars['theme_hook_suggestions'][] = 'block__bean_'. $vars['elements']['#block']->region;
    }

  }
  elseif ( $hook == "node" ) {
    // =======================================| NODE |========================================
    //Template suggestions
    //add new theme hook suggestions based on type & wiewmode
    // a default catch all teaser are set op as node--nodeteaser.tpl.php

    //one unified node teaser template
    if($vars['view_mode'] == "teaser"){
      $vars['theme_hook_suggestions'][] = 'node__nodeteaser';
    }

    if($vars['view_mode'] == "teaser" AND $vars['promote']){
      $vars['theme_hook_suggestions'][] = 'node__nodeteaser__promote';
    }

    if($vars['view_mode'] == "teaser" AND $vars['sticky']){
      $vars['theme_hook_suggestions'][] = 'node__nodeteaser__sticky';
    }

    if($vars['view_mode'] == "teaser" AND $vars['is_front']){
      $vars['theme_hook_suggestions'][] = 'node__nodeteaser__front';
    }

    //$vars['theme_hook_suggestions'][] = 'node__' . $vars['type'] ;

    //fx node--gallery--teaser.tpl
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['type'] . '__' . $vars['view_mode'];

    //add a noderef to the list
    if (isset($vars['referencing_field'])) {
      $vars['theme_hook_suggestions'][] = 'node__noderef';
      $vars['theme_hook_suggestions'][] = 'node__noderef__' . $vars['type'];
      $vars['theme_hook_suggestions'][] = 'node__noderef__' . $vars['type'] . '__' . $vars['view_mode'];
    }

    $vars['id_node'] = "";

    /*if (theme_get_setting('mothership_classes_node')) {
      $vars['classes_array'] = array_values(array_diff($vars['classes_array'], array('node')));
    }*/


    /*
      change node-xxx to a more generalised name so we can use the same class other places
      fx in the comments
    */
    $vars['classes_array'] = array_values(array_diff($vars['classes_array'],array('node-sticky','node-unpublished', 'node-promoted')));
    if($vars['promote']){
      $vars['classes_array'][] = 'promote';
    }
    if($vars['sticky']){
      $vars['classes_array'][] = 'sticky';
    }
    if($vars['status'] =="0"){
      $vars['classes_array'][] = 'unpublished';
    }
    if (isset($vars['preview'])) {
      $vars['classes_array'][] = 'node-preview';
    }

    // css id for the node
    if (theme_get_setting('mothership_classes_node_id')) {
      $vars['id_node'] =  'node-'. $vars['nid'];
    }

    /*
    remove class from the ul that holds the links
    <ul class="inline links">
    this is generated in the node_build_content() function in the node.module
    */
    /*if (theme_get_setting('mothership_classes_node_links_inline') AND isset($vars['content']['links']['#attributes']['class'])) {
      $vars['content']['links']['#attributes']['class'] = array_values(array_diff($vars['content']['links']['#attributes']['class'],array('inline')));
    }

    if (theme_get_setting('mothership_classes_node_links_links') AND (isset($vars['content']['links']['#attributes']['class']))) {
      $vars['content']['links']['#attributes']['class'] = array_values(array_diff($vars['content']['links']['#attributes']['class'],array('links')));
    }*/
    // TODO: add a field to push in whatever class names we want to
    // $vars['content']['links']['#attributes']['class'][] = "hardrock hallelulia";

    //  remove the class attribute it its empty
    if(isset($vars['content']['links']['#attributes']['class'])){
      if(isset($vars['content']['links']['#attributes']['class']) && !$vars['content']['links']['#attributes']['class']){
        unset($vars['content']['links']['#attributes']['class']);
      }
    }

   // kpr($vars['theme_hook_suggestions']);

  }
  elseif ( $hook == "comment" ) {
    // =======================================| COMMENT |========================================
    if (isset($vars['elements']['#comment']->new) && $vars['elements']['#comment']->new){
      $vars['classes_array'][] = ' new';
    }

    if ($vars['status'] == "comment-unpublished"){
       $vars['classes_array'][] = ' unpublished';
    }

    //remove inline class from the ul links
    /*if (theme_get_setting('mothership_classes_node_links_inline')) {
      $vars['content']['links']['#attributes']['class'] = array_values(array_diff($vars['content']['links']['#attributes']['class'],array('inline')));
    }*/

  }
  elseif ( $hook == "field" ) {
    // =======================================| FIELD |========================================
    //if (theme_get_setting('mothership_classes_field_field')) {
      $vars['classes_array'] = array_values(array_diff($vars['classes_array'],array('field')));
    //}

    //kill the field-name-xxxx class
    /*if (theme_get_setting('mothership_classes_field_name')) {
      $vars['classes_array'] = preg_grep('/^field-name-/', $vars['classes_array'], PREG_GREP_INVERT);
    }
    //kill the field-type-xxxx class
    if (theme_get_setting('mothership_classes_field_type')) {
      $vars['classes_array'] = preg_grep('/^field-type-/', $vars['classes_array'], PREG_GREP_INVERT);
    }*/

    //label
    /*if (theme_get_setting('mothership_classes_field_label')) {
      $vars['classes_array'] = preg_grep('/^field-label-/', $vars['classes_array'], PREG_GREP_INVERT);
      $vars['classes_array'] = array_values(array_diff($vars['classes_array'],array('clearfix')));
    }*/

   // $vars['theme_hook_suggestions'][] = 'node__' . $vars['type'] . '__' . $vars['view_mode'];

  }
  elseif ( $hook == "maintenance_page" ) {
    // =======================================| maintenance page |========================================

    $vars['path'] = $path;
    $vars['appletouchicon'] = $appletouchicon;
    $vars['theme_hook_suggestions'][] = 'static__maintenance';
  }
}

function starter_process_html(&$vars, $hook) {
  $vars['html_attributes'] = drupal_attributes($vars['html_attributes_array']);
}

/*
  // Purge needless XHTML stuff.
  nathan ftw! -> http://sonspring.com/journal/html5-in-drupal-7
*/
function starter_process_html_tag(&$vars) {
  $el = &$vars['element'];

  // Remove type="..." and CDATA prefix/suffix.
  unset($el['#attributes']['type'], $el['#value_prefix'], $el['#value_suffix']);

  // Remove media="all" but leave others unaffected.
  if (isset($el['#attributes']['media']) && $el['#attributes']['media'] === 'all') {
    unset($el['#attributes']['media']);
  }
}

/*
freeform class killing
*/
function starter_class_killer(&$vars){
  $remove_class_node = explode(", ", theme_get_setting('mothership_classes_node_freeform'));
  $vars['classes_array'] = array_values(array_diff($vars['classes_array'],$remove_class_node));
  $vars['classes'] = "";

//  kpr($vars['classes_array']);
 // return $vars;
}
