<?php
if($sf_user->isAuthenticated()) {
  include_partial('article/admin_bar', array('item' => $item));
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
  <?php echo $item->getContent(ESC_RAW) ?>
</div>
<?php
if(count($comments)) {
  include_partial('article/comments', array('comments'=>$comments));
}
if($form) {
  include_partial('article/comment_form', array('form'=>$form));
}
?>