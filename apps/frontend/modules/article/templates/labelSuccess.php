<?php 
slot('page_title', $label->title);
if($label->getDescription()): ?>
  <div class="label-description"><?php echo $label->getDescription(); ?></div>
<?php endif; ?>

<?php
$items = $pager->getResults();
if(count($items)):
  include_partial('article/list', array('items' => $items));
else:?>
  <div class="info-message"><?php echo __('MSG_ARTICLES_NOT_FOUND')?></div>
<?php endif;?>

<?php if ($pager->haveToPaginate()): ?>
  <?php 
    $base = '@article_label?slug=' . $label->getSlug() . '&page=';
  ?>
  <div class="pagination">
    <?php echo link_to('First', $base . '1');?>
    <?php echo link_to('Prev', $base . $pager->getPreviousPage());?>
    <?php foreach ($pager->getLinks() as $page): ?>
      <?php if ($page == $pager->getPage()): ?>
        <?php echo $page ?>
      <?php else:
        echo link_to($page, $base . $page);
      endif; ?>
    <?php endforeach; ?>
    <?php echo link_to('Next', $base . $pager->getNextPage());?>
    <?php echo link_to('Last', $base . $pager->getLastPage());?>
  </div>
<?php endif; ?>
