<?php
$total = $lyra_article->countComments();
echo $total . ' / ' . ($total - $lyra_article->countActiveComments());
?>
 (<?php echo link_to(__('LINK_SHOW_COMMENTS'),'@lyra_comment_comment?id=' . $lyra_article->getId()); ?>)

