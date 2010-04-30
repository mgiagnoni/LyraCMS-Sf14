<h2><?php echo __('HEAD_USER_REGISTRATION') ?></h2>
<form id="registration-form" action="<?php echo url_for('user/'.($form->getObject()->isNew() ? 'create' : 'update')) ?>" method="post">
  <?php if (!$form->getObject()->isNew()): ?>
    <input type="hidden" name="sf_method" value="put" />
  <?php endif; ?>
  <div class="col-left">
    <?php echo $form['user_profile']->renderRow(); ?>
    <div class="row-submit">
    <input type="submit" value="Submit" />
    </div>
  </div>
  <div class="col-right">
    <?php foreach(array('username','password','password_again') as $field): ?>
      <?php echo $form[$field]->renderRow(); ?>
    <?php endforeach; ?>
  </div>
  <div class="row">
    <?php echo $form->renderHiddenFields();?>
  </div>
</form>
