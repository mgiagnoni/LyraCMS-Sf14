<?php if ($lyra_comment->getIsActive()): ?>
  <?php echo link_to(image_tag('backend/yes.png', array('alt' => __('LINK_T_PUBLISHED'))),'comment/unpublish?id='.$lyra_comment->getId(), array('title' => __('LINK_T_PUBLISHED'))) ?>
<?php else: ?>
  <?php echo link_to(image_tag('backend/no.png', array('alt' => __('LINK_T_UNPUBLISHED'))),'comment/publish?id='.$lyra_comment->getId(), array('title' => __('LINK_T_UNPUBLISHED'))) ?>
<?php endif; ?>
