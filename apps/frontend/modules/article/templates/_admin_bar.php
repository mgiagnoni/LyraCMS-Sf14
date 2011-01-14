<div id="admin-bar">
  <?php if($sf_user->hasCredential(array('content_administer','article_administer','article_create'),false)): ?>
    <span class="action"><?php echo link_to(__('LINK_NEW'), 'article/new?id=' . $item->getCtypeId()) ?></span>
  <?php endif; ?>
  <?php if($sf_user->hasCredential(array('content_administer','article_administer','article_edit'),false)): ?>
    <span class="action"><?php echo link_to(__('LINK_EDIT'), 'article/edit?id=' . $item->getId()) ?></span>
  <?php endif; ?>
  <span class="action"><?php echo link_to(__('LINK_LOGOUT'), '@sf_guard_signout') ?></span>
</div>