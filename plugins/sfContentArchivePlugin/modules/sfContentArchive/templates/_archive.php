<?php use_helper('Date','I18N') ?>
<ul class="archive-list">
<?php
  $cy = null;
  foreach($rows as $row):
    $year = $row->ay;
    $month = format_date($year . '-' . $row->am . '-01', 'MMMM');

    if($year != $cy)
    {
      if($cy)
      {
        echo '</ul></li>';
      }
      echo '<li class="year">' . $year;
      echo '<ul class="months">';
      $cy = $year;
    }
?>
<li class="month">
    <?php echo link_to($month, $options['route'], array('year' => $year, 'month' => $row->am)); ?>
    <span class="counter">(<?php echo $row->ct ?>)</span>
</li>
<?php endforeach ?>
</ul></li>
</ul>
