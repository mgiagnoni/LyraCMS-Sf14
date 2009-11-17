<?php if ($lyra_catalog->getIsActive()): ?>
  <?php echo link_to(image_tag('backend/yes.png', array('alt' => __('LINK_T_PUBLISHED'))),'catalog/unpublish?id='.$lyra_catalog->getId(), array('title' => __('LINK_T_PUBLISHED'))) ?>
<?php else: ?>
  <?php echo link_to(image_tag('backend/no.png', array('alt' => __('LINK_T_UNPUBLISHED'))),'catalog/publish?id='.$lyra_catalog->getId(), array('title' => __('LINK_T_UNPUBLISHED'))) ?>
<?php endif; ?>
