<?php if ($lyra_article->getIsFeatured()): ?>
  <?php echo link_to(image_tag('backend/yes.png', array('alt' => __('LINK_T_FEATURED'))),'lyra_article_unfeature', $lyra_article, array('title' => __('LINK_T_FEATURED'))) ?>
<?php else: ?>
  <?php echo link_to(image_tag('backend/no.png', array('alt' => __('LINK_T_UNFEATURED'))),'lyra_article_feature', $lyra_article, array('title' => __('LINK_T_UNFEATURED'))) ?>
<?php endif; ?>