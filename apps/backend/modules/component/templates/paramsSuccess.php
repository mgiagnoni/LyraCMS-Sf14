<?php include_partial('region/assets') ?>
<div id="sf_admin_container">
  <div id="sf_admin_header">
    <span class="link-back"><?php echo link_to(__('LINK_BACK'),'@lyra_region')?></span>
  </div>
  <div id="sf_admin_content">
    <?php include_partial('component/form_params', array('form' => $form_params)) ?>
  </div>
  <div id="sf_admin_footer"></div>
</div>
