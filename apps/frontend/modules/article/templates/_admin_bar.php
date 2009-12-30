<div id="admin-bar">
  <span class="action"><?php echo link_to(__('LINK_NEW'), 'article/new?id=' . $item->getCtypeId()) ?></span>
  <span class="action"><?php echo link_to(__('LINK_EDIT'), 'article/edit?id=' . $item->getId()) ?></span>
  <span class="action"><?php echo link_to(__('LINK_LOGOUT'), '@sf_guard_signout') ?></span>
</div>