<div class="login-info">
<?php echo __('SIGNEDIN_AS');?>: <span class="username"><?php echo $sf_user->getGuardUser()->getUsername(); ?></span>
</div>
<?php echo link_to(__('LINK_LOGOUT'), '@user_signout', array('class' => 'logout')); ?>
