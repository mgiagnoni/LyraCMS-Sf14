<div class="sf_admin_form">
  <form action="<?php echo url_for('lyra_component_update_params', array('id' => $form->getObject()->getComponentId(), 'region_id' => $form->getObject()->getRegionId()));?>" method="post">
    <div class="sf_admin_col">
      <fieldset id="sf_fieldset_none">
        <div class="sf_admin_form_row">
          <?php echo $form; ?>
        </div>
      </fieldset>
      <ul class="sf_admin_actions">
        <li class="sf_admin_action_save">
          <input type="submit" value="Save" />
        </li>
      </ul>
    </div>
  </form>
</div>
