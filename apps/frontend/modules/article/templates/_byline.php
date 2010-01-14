<div class="article-byline">
  <?php if($item->getCfg('show_author')): ?>
  <span class="article-author">
    <?php echo __('ARTICLE_WRITTEN_BY', array('%author%'=> $item->getArticleCreatedBy()->getUsername()));?>
  </span>
  <?php endif; ?>
  <?php if($item->getCfg('show_date')): ?>
  <span class="article-date">
    <?php echo __('ARTICLE_WRITTEN_ON', array('%date%'=>format_date($item->getCreatedAt(),'dd MMMM, yyyy'))); ?>
  </span>
  <?php endif; ?>
</div>
