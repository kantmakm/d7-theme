<!doctype html>

<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="<?php print $language->language; ?>" <?php print $rdf_namespaces; ?> <?php print $html_attributes; ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="<?php print $language->language; ?>" <?php print $rdf_namespaces; ?> <?php print $html_attributes; ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="<?php print $language->language; ?>" <?php print $rdf_namespaces; ?> <?php print $html_attributes; ?>> <!--<![endif]-->
<head>
<title><?php print $head_title; ?></title>
<?php print $head; ?>
<?php print $appletouchicon; ?>
<meta http-equiv="cleartype" content="on">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<?php print $styles; ?>
<!--[if lt IE 9]>
  <script src="<?php print $starter_path; ?>/js/respond.min.js"></script>
<![endif]-->
<!--[if lt IE 9]>
  <script src="<?php print $starter_path; ?>/js/html5.js"></script>
<![endif]-->
</head>
<body class="<?php print $classes; ?>" <?php print $attributes;?>>
<a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
<?php print $page_top; //stuff from modules always render first ?>
<?php print $page; // uses the page.tpl ?>
<script type="text/javascript">
  var theme_url = '<?php print $starter_path; ?>/';
</script>
<?php print $scripts; ?>
<?php print $page_bottom; //stuff from modules always render last ?>
</body>
</html>
