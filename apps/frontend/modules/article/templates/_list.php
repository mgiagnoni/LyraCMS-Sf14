<?php use_helper('Date') ?>
<?php foreach ($items as $item): ?>
  <h2 class="article-title">
    <?php
    if($item->getCfg('linked_title')) {
      echo link_to($item->getTitle(), $item->getContentType()->getType() . '_show', $item);
    } else {
      echo $item->getTitle();
    }
?>
  </h2>
  <?php include_partial('article/byline', array('item' => $item));?>
  <div class="article-summary">
    <?php
    echo $item->getSummary(ESC_RAW);
    if($item->showReadmore()): ?>
      <span class="article-readmore">
      <?php echo link_to(__('LINK_READMORE'), $item->getContentType()->getType() . '_show', $item, array('title'=>$item->getTitle()))?>
      </span>
    <?php endif ?>
  </div>
  <div class="article-separator"></div>
<?php endforeach; ?>
