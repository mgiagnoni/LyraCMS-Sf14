<?php use_helper('Date') ?>
<h4><?php echo __('HEAD_LATEST')?></h4>
<ul class="latest-list">
<?php foreach ($items as $item): ?>
  <li>
    <span class="title"><?php echo link_to($item->getTitle(), $item->getContentType()->getType() . '_show', $item); ?></span>
    <span class="date"><?php echo format_date($item->getCreatedAt(), 'd MMM, yyyy'); ?></span>
  </li>
<?php endforeach; ?>
</ul>
<?php if(isset($feed)): ?>
<div class="feed-subscribe"><?php echo link_to(__('LINK_SUBSCRIBE_FEED'), $feed); ?></div>
<?php endif; ?>
