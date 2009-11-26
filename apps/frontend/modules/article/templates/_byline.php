<div class="article-byline">
  <span class="article-author">
    <?php echo __('ARTICLE_WRITTEN_BY', array('%author%'=> $item->getArticleCreatedBy()->getUsername()));?>
  </span>
  <span class="article-date">
    <?php echo __('ARTICLE_WRITTEN_ON', array('%date%'=>format_date($item->getCreatedAt(),'dd MMMM, yyyy'))); ?>
  </span>
</div>
