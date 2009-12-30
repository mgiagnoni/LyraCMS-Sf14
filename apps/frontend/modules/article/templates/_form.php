<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form class="content-form" action="<?php echo url_for('article/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>

<?php if($form->break_at): ?>
    <div class="col-left">
<?php endif; ?>

<?php foreach($form->panels as $title => $panel): ?>
  <?php if($form->break_at == $title):?>
    </div>
    <div class="col-right">
  <?php endif; ?>
  <div class="panel">
    <?php if($title !== 'NONE'): ?>
      <h2><?php echo __($title);?></h2>
    <?php endif; ?>
    
    <?php foreach($panel as $field): ?>
      
      <?php echo $form[$field]->renderRow(); ?>
    <?php endforeach; ?>
  </div>
<?php endforeach; ?>
<?php if($form->break_at): ?>
  </div>
<?php endif; ?>
<div class="row">
  <?php echo $form->renderHiddenFields();?>
</div>
<div class="row-submit">
  <input type="submit" class="submit" value="Save" />
</div>
</form>
