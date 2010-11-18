<?php use_helper('Date') ?>
<?php foreach ($items as $item): ?>
  <h2 class="item-title">
    <?php echo link_to($item->getTitle(), $options['item_route'], $item);?>
  </h2>
  <span class="item-date"><?php echo format_date($item->getCreatedAt(),'d MMMM, yyyy') ?></span>
  <div class="item-summary">
    <?php echo $item->getRaw('summary');?>
    <span class="item-readmore">
      <?php echo link_to(__('Read more'), $options['item_route'], $item, array('title'=>$item->getTitle()))?>
    </span>
  </div>
  <div class="item-separator"></div>
<?php endforeach; ?>
