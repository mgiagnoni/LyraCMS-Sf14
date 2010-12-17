<div class="sf_admin_list">
  <?php if (!$pager->getNbResults()): ?>
    <p><?php echo __('No result', array(), 'sf_admin') ?></p>
  <?php else: ?>
    <table cellspacing="1">
      <thead>
        <tr>
          <th>
            <?php echo __('Name'); ?>
          </th>
          <th>
             <?php echo __('Order'); ?>
          </th>
          <th>
             <?php echo __('Actions'); ?>
          </th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($pager->getResults() as $lyra_region): ?>
          <tr class="sf_admin_row region">
            <td>
              <?php echo $lyra_region->getName(); ?>
            </td>
            <td>
              <?php include_partial('region/list_td_actions', array('lyra_region' => $lyra_region, 'helper' => $helper)) ?>
            </td>
          </tr>
            <?php $rcomps = $lyra_region->getRefComponents();
            foreach($rcomps as $nrow => $rc): ?>
            <tr class="sf_admin_row">
              <td>
                <?php echo $rc->getComponent()->getAction()?>
              </td>
              <td>
                <?php include_partial('region/order', array('lyra_component' => $rc->getComponent(), 'lyra_region' => $lyra_region, 'show_up' => $nrow > 0, 'show_down' => $nrow < count($rcomps)-1));?>
              </td>
              <?php include_partial('region/component_td_actions', array('lyra_component' => $rc->getComponent(), 'lyra_region' => $lyra_region)); ?>
            </tr>
          <?php endforeach; ?>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>
