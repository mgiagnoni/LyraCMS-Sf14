<?php
$total = $lyra_article->getNumComments();
echo $total . ' / ' . ($total - $lyra_article->getNumActiveComments());
?>
 (<?php echo link_to(__('LINK_SHOW_COMMENTS'),'@lyra_comment?id=' . $lyra_article->getId()); ?>)

