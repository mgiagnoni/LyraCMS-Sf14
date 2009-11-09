<?php if ($lyra_article->getIsFeatured()): ?>
  <?php echo link_to(image_tag('backend/yes.png', array('alt' => __('LINK_T_FEATURED'))),'article/unfeature?id='.$lyra_article->getId(), array('title' => __('LINK_T_FEATURED'))) ?>
<?php else: ?>
  <?php echo link_to(image_tag('backend/no.png', array('alt' => __('LINK_T_UNFEATURED'))),'article/feature?id='.$lyra_article->getId(), array('title' => __('LINK_T_UNFEATURED'))) ?>
<?php endif; ?>