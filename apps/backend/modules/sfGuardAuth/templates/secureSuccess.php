<?php use_helper('I18N') ?>
<div class="unauth-error">
<?php echo image_tag('/images/backend/dialog-error-3');?>
<?php echo __("You don't have the required permission to access this page.") ?>
 <?php echo link_to(__('MENU_LOGOUT'), '@sf_guard_signout') ?>
</div>
