<?php
$total = $lyra_article->countComments();
echo $total . ' / ' . ($total - $lyra_article->countActiveComments());
?>
 (<a href="#"><?php echo __('LINK_SHOW_COMMENTS') ?></a>)

