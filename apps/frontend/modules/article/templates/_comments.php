<?php use_helper('Date');?>
<h2 id="comments"><?php echo __('HEAD_COMMENTS') ?></h2>
<?php foreach($comments as $comment):?>
<div class="comment-wrapper">
<div class="comment-header">
  <?php
  $author = $comment->getAuthorName();
  if($comment->getAuthorUrl()) {
    $author = link_to($author, $comment->getAuthorUrl());
  }
  echo __('COMMENT_HEADER',
    array(
      '%name%'=>'<span class="author">' . $author . '</span>',
      '%date%'=>'<span class="date">' . format_date($comment->getCreatedAt(),'dd MMMM yyyy') . '</span>',
      '%time%'=>'<span class="time">' . format_date($comment->getCreatedAt(),'HH:mm') . '</span>'
    ));
  ?>
</div>
<div class="comment-content"><?php echo $comment->getContent()?></div>
</div>
<?php endforeach;?>
