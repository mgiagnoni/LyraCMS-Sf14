<?php use_helper('Date') ?>
<?php foreach ($items as $item):
  $params = $item->getParamHolder();
?>
  <h2 class="article-title">
    <?php
    if($params->get('linked_title')) {
      echo link_to($item->getTitle(), $item->getContentType()->getType() . '_show', $item);
    } else {
      echo $item->getTitle();
    }
?>
  </h2>
  <?php include_partial('article/byline', array('item' => $item, 'params' => $params));?>
  <div class="article-summary">
    <?php
    echo $item->getSummary(ESC_RAW);
    if($params->get('show_read_more') && trim($item->getContent())): ?>
      <span class="article-readmore">
      <?php echo link_to(__('LINK_READMORE'), $item->getContentType()->getType() . '_show', $item, array('title'=>$item->getTitle()))?>
      </span>
    <?php endif ?>
  </div>
  <div class="article-separator"></div>
<?php endforeach; ?>
