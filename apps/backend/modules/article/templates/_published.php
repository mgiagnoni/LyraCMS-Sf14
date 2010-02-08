<?php if ($lyra_article->getIsActive()): ?>
  <?php echo link_to(image_tag('backend/yes.png', array('alt' => __('LINK_T_PUBLISHED'))),'lyra_article_unpublish', $lyra_article, array('title' => __('LINK_T_PUBLISHED'))) ?>
<?php else: ?>
  <?php echo link_to(image_tag('backend/no.png', array('alt' => __('LINK_T_UNPUBLISHED', array(), 'sf_admin'))),'lyra_article_publish', $lyra_article, array('title' => __('LINK_T_UNPUBLISHED'))) ?>
<?php endif; ?>
