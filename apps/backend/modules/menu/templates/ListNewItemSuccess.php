<?php if(!get_slot('page_title')) { slot('page_title',__('Menu List', array(), 'messages')); } ?>
<div id="sf_admin_container">

  <?php include_partial('menu/flashes') ?>

  <div id="sf_admin_header">
    <span class="link-back"><?php echo link_to(__('LINK_BACK'),'@lyra_menu')?></span>
  </div>

  <div id="sf_admin_content">
    <div id="new-menu">
      <div class="sf_admin_col">
        <h2><?php echo __('MENU_TYPE_ROOT') ?></h2>
        <div class="item-type">
           <?php echo link_to(__('ITEM_TYPE_ROOT'), '@lyra_menu_new?type=root'); ?>
        </div>
        <h2><?php echo __('MENU_TYPE_ITEM') ?></h2>
        <?php foreach($content_types as $ct):?>
        <div class="menu-ctype">
          <?php echo $ct->getName(); ?>
        </div>
        <div class="item-type">
          <?php echo __('ITEM_TYPE_OBJECT'); ?>&nbsp;
          <?php echo link_to(__('LINK_CREATE_ITEM'), '@lyra_menu_new?ctype_id=' . $ct->getId() . '&type=object'); ?>
        </div>
        <div class="item-type">
          <?php echo __('ITEM_TYPE_LIST'); ?>&nbsp;
          <?php echo link_to(__('LINK_CREATE_ITEM'), '@lyra_menu_new?ctype_id=' . $ct->getId() . '&type=list'); ?>
        </div>
        <?php endforeach; ?>
      </div>
      <div class="sf_admin_col_2">
        <h2><?php echo __('MENU_TYPE_OTHER') ?></h2>
        <div class="item-type">
          <?php echo __('ITEM_TYPE_ROUTE'); ?>
           (<?php echo link_to(__('LINK_CREATE_ITEM'), '@lyra_menu_new?type=route'); ?>)
        </div>
        <div class="item-type">
          <?php echo __('ITEM_TYPE_EXTERNAL'); ?>
           (<?php echo link_to(__('LINK_CREATE_ITEM'), '@lyra_menu_new?type=external'); ?>)
        </div>
      </div>
    </div>
  </div>
  <div id="sf_admin_footer"></div>
</div>
