<h4><?php echo __($sf_user->isAuthenticated() ? 'HEAD_USER' : 'HEAD_LOGIN');?></h4>
<div id="login-form-wrapper-side">
<?php if ($sf_user->isAuthenticated()):?>
  <?php include_partial('user/signout'); ?>
<?php else: ?>
  <?php include_partial('user/signin', array('form' => $form, 'show_registration_link' => $show_registration_link)); ?>
<?php endif;?>
</div>