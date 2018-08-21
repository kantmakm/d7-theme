<?php

// Plugin definition
$plugin = array(
  'title' => t('HTML5 base'),
  'category' => t('starter'),
  'icon' =>  'starter-html5page.png',
  'theme' => 'starter-html5page',
  'css' =>   'starter-html5page.admin.css',
  'regions' => array(
    'top' => t('Top (<header>)'),
    'top_mobile' => t('Top - Mobile (<header>)'),
    'middle' => t('Middle (role="main")'),
    'bottom' => t('Bottom (<footer>)'),
  ),
);
