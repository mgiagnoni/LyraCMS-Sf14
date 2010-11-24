<?php
use_helper('Date','I18N');
$monthname = format_date("$year-$month-01", 'MMMM');

if($options['page_meta_title'])
{
  $sf_response->setTitle(__($options['page_meta_title'], array('%year%' => $year, '%month%' => $monthname)));
}
?>
<?php if($options['page_title']): ?>
<h1><?php echo __($options['page_title']) ?></h1>
<?php endif; ?>

<?php
$items = $pager->getResults();
if(count($items)):
  include_partial($options['item_template'], array('items'=>$items, 'options' => $options));
else:?>
  <div class="info-message"><?php echo __('No results')?></div>
<?php endif; ?>
  
<?php if ($pager->haveToPaginate()): ?>
  <?php
    $base = '@'. $options['route'] .'?year=' . $year . '&month=' . $month . '&page=';
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
