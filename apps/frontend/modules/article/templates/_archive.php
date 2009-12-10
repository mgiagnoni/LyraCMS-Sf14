<?php use_helper('Date') ?>
<h4><?php echo __('HEAD_ARCHIVE')?></h4>
<ul class="archive-list">
<?php
  $cy = null;
  foreach($rows as $row):
    $year = $row->ay;
    $month = format_date($year . '-' . $row->am . '-01', 'MMMM');

    if($year != $cy) {
      if($cy) {
        echo '</ul></li>';
      }
      echo '<li class="year">' . $year;
      echo '<ul class="months">';
      $cy = $year;
    }
?>
<li class="month"><?php echo link_to($month, '@article_archive?year=' . $year .'&month=' . $row->am); ?></li>
<?php endforeach ?>
</ul></li>
</ul>
