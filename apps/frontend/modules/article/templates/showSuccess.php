
<h1 class="article-title">
  <?php echo $item->getTitle() ?>
</h1>
<?php if($item->getSubtitle()): ?>
  <div class="article-subtitle">
    <?php echo $item->getSubtitle() ?>
  </div>
<?php endif ?>
<div class="article-date">
  <?php echo $item->getCreatedAt() ?>
</div>
<div class="article-content">
  <?php echo $item->getContent(ESC_RAW) ?>
</div>