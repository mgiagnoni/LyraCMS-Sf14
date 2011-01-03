<?php include_partial('global/assets') ?>
<div id="sf_admin_container">
  <div id="sf_admin_header">
  </div>
  <div id="sf_admin_content">
    <?php if($show_welcome): ?>
    <div class="notice">
    <?php echo __('MSG_WELCOME', array('%name%' => $sf_user->getGuardUser()->getProfile()->getFirstName(), '%user%' => $sf_user->getGuardUser()->getUsername())); ?>
    </div>
    <?php endif;?>
  </div>
  <div id="sf_admin_footer"></div>
</div>
