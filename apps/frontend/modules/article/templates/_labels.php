<h4><?php echo __('HEAD_LABELS')?></h4>
<ul class="label-list">
<?php foreach($tree as $node): ?>
  <li class="lev<?php echo $node->getLevel(); ?>">
    <?php echo link_to($node->getName(),'@article_label?slug='.$node->getSlug()); ?>
  </li>
<?php endforeach ?>
</ul>
