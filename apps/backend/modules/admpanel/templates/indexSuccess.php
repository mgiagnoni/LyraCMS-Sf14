<?php include_partial('global/assets') ?>
<div id="sf_admin_container">
  <div id="sf_admin_header">
  </div>
  <div id="sf_admin_content">
    <?php if($show_welcome): ?>
    <div class="notice">
    <?php echo __('MSG_WELCOME', array('%name%' => $sf_user->getGuardUser()->getProfile()->getFirstName(), '%user%' => $sf_user->getGuardUser()->getUsername())); ?>
    </div>
    <?php endif;?>
    <h1>Reminders</h1>
    <?php if(!$infos):?>
      <?php echo __('MSG_NO_REMINDERS'); ?>
    <?php else: ?>
      <?php if(isset($infos['unpub'])): ?>
        <ul>
          <?foreach($infos['unpub'] as $k => $v): ?>
            <li>
            <?php echo format_number_choice('MSG_'.strtoupper($k).'_UNPUBLISHED', array('%count%' => $v['count']),$v['count']); ?>
             (<?php echo link_to(__('LINK_SHOW'), sfInflector::underscore($v['ctype']->getModel()), array('ctype_id' => $v['ctype']->getId(),'unpublished' => 1)); ?>)
            </li>
          <?php endforeach;?>
        </ul>
      <?php endif; ?>
      <?php if(isset($infos['comment'])): ?>
        <ul>
          <li>
          <?php echo format_number_choice('MSG_COMMENT_UNPUBLISHED', array('%count%' => $infos['comment']), $infos['comment']) ?>
           (<?php echo link_to(__('LINK_SHOW'), 'lyra_comment', array('unpublished' => 1)); ?>)
          </li>
        </ul>
      <?php endif; ?>
    <?php endif; ?>
   </div>
  <div id="sf_admin_footer"></div>
</div>
