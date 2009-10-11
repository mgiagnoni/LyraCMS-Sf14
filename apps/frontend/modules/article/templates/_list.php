<?php foreach ($items as $item): ?>
  <h2 class="article-title">
    <?php echo link_to($item->getTitle(), 'article/show?id='.$item->getId())?>
  </h2>
  <div class="article-date">
    <?php echo $item->getCreatedAt() ?>
  </div>
  <div class="article-summary">
    <?php
    echo $item->getSummary(ESC_RAW);
    if($item->showReadmore()): ?>
      <span class="article-readmore">
      <?php echo link_to(__('LINK_READMORE'), 'article/show?id='.$item->getId(), array('title'=>$item->getTitle()))?>
      </span>
    <?php endif ?>
  </div>
  <div class="article-separator"></div>
<?php endforeach; ?>
