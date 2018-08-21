<?php
// menu
// http://api.drupal.org/api/drupal/modules--block--block.tpl.php/7
// <h2 class="element-invisible">...</h2>
if ($classes) {
  $classes = ' class="'. $classes . ' "';
}
?>

<nav <?php print $id_block . $classes .  $attributes; ?> role="navigation">

  <?php print render($title_prefix); ?>
  <?php if ($block->subject): ?>
    <h2<?php print $title_attributes; ?>><?php print $block->subject ?></h2>
  <?php endif;?>
  <?php print render($title_suffix); ?>

  <?php print $content ?>
</nav>
