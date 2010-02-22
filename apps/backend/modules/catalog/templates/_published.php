<?php if ($lyra_catalog->getIsActive()): ?>
  <?php echo link_to(image_tag('backend/yes.png', array('alt' => __('LINK_T_PUBLISHED'))),'lyra_catalog_unpublish', $lyra_catalog, array('title' => __('LINK_T_PUBLISHED'))) ?>
<?php else: ?>
  <?php echo link_to(image_tag('backend/no.png', array('alt' => __('LINK_T_UNPUBLISHED'))),'lyra_catalog_publish', $lyra_catalog, array('title' => __('LINK_T_UNPUBLISHED'))) ?>
<?php endif; ?>
