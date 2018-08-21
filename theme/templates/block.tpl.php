<?php
// kpr($variables);
// kpr($variables['template_files']);
//  http://api.drupal.org/api/drupal/modules--block--block.tpl.php/7
if ($classes) {
  $classes = ' class="'. $classes . ' "';
}

//add a aria role search if this is the search block
if($variables['block_html_id'] == "block-search-form"){
	$role = ' role="search"';
}else{
$role = '';
}
?>

<div <?php print $id_block . $classes .  $attributes . $role; ?>>

  <?php print render($title_prefix); ?>
  <?php if ($block->subject): ?>
    <h2<?php print $title_attributes; ?>><?php print $block->subject ?></h2>
  <?php endif;?>
  <?php print render($title_suffix); ?>

  <?php print $content ?>
</div>
