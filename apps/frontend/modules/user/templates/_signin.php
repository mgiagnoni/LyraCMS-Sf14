<form id="login-form" action="<?php echo url_for('@user_signin'); ?>" method="post">
  <?php echo $form; ?>
  <div class="row-submit">
    <input type="submit" value="Login" />
  </div>
</form>
<?php if($show_registration_link): ?>
  <?php echo link_to(__('LINK_REGISTER'), 'user/register'); ?>
<?php endif; ?>
