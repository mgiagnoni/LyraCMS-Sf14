<div id="admin-bar">
  <span class="action"><?php echo link_to(__('LINK_NEW'), 'article/new') ?></span>
  <span class="action"><?php echo link_to(__('LINK_EDIT'), 'article/edit?id='.$item->getId()) ?></span>
  <span class="action"><a href="#"><?php echo __('LINK_LOGOUT') ?></a></span>
</div>