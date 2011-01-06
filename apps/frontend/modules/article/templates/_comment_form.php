<?php if(null !== $form):?>
<h3 id="comment-form"><?php echo __('HEAD_SUBMIT_COMMENT') ?></h3>
<div id="form-wrapper">
  <form action="<?php echo url_for('article/comment?id=' . $form['article_id']->getValue()) ?>" method="post">
    <?php echo $form ?>
    <div class="row"><input type="submit" value="Submit" /></div>
  </form>
</div>
<?php else: ?>
  <?php if($sf_user->isAnonymous() && $params->get('allow_comments') && !$params->get('allow_anonymous_comments')):?>
    <span class="must-login"><?php echo __('MUST_LOGIN_SUBMIT_COMMENT');?></span>
  <?php endif;?>
<?php endif;?>
