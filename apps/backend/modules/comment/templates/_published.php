<?php if ($lyra_comment->getIsActive()): ?>
  <?php echo link_to(image_tag('backend/yes.png', array('alt' => __('LINK_T_PUBLISHED'))),'lyra_comment_unpublish', $lyra_comment, array('title' => __('LINK_T_PUBLISHED'))) ?>
<?php else: ?>
  <?php echo link_to(image_tag('backend/no.png', array('alt' => __('LINK_T_UNPUBLISHED'))),'lyra_comment_publish', $lyra_comment, array('title' => __('LINK_T_UNPUBLISHED'))) ?>
<?php endif; ?>
