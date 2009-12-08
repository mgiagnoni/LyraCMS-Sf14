<h3 id="comment-form"><?php echo __('HEAD_SUBMIT_COMMENT') ?></h3>
<div id="form-wrapper">
  <form action="<?php echo url_for('article/comment?id=' . $form['article_id']->getValue()) ?>" method="post">
    <?php echo $form ?>
    <div class="row"><input type="submit" value="Submit" /></div>
  </form>
</div>
