<?php
if($sf_user->isAuthenticated()) {
  include_partial('article/admin_bar', array('item' => $item));
}
if(isset($form) && $form->isBound() && !$form->isValid()) { ?>
  <div class="comment-error">
  <?php echo __('ERROR_COMMENT_SUBMIT'); ?>
    <a href="#comment-form"><?php echo __('LINK_CORRECT_COMMENT_SUBMIT'); ?></a>
  </div>
<?php
}
?>
<?php use_helper('Date') ?>
<h1 class="article-title">
  <?php echo $item->getTitle() ?>
</h1>
<?php if($item->getSubtitle()): ?>
  <div class="article-subtitle">
    <?php echo $item->getSubtitle() ?>
  </div>
<?php endif ?>
<?php include_partial('article/byline', array('item' => $item));?>
<div class="article-content">
  <?php
  echo $item->getSummary(ESC_RAW);
  echo $item->getContent(ESC_RAW);
  ?>
</div>
<?php
if(count($comments)) {
  include_partial('article/comments', array('comments'=>$comments));
}
if($form) {
  include_partial('article/comment_form', array('form'=>$form));
}
?>