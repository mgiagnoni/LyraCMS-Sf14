<div class="login-info">
<?php echo __('SIGNEDIN_AS');?>:
<span class="username">
<?php
switch($params->get('user_info'))
{
  case 'first_name':
    echo $sf_user->getGuardUser()->getProfile()->getFirstName();
    break;
  case 'first_last':
    echo $sf_user->getGuardUser()->getProfile()->getFirstName(), ' ',
    $sf_user->getGuardUser()->getProfile()->getLastName();
    break;
  default:
    echo $sf_user->getGuardUser()->getUsername();
    break;
}
?>
</span>
</div>
<?php echo link_to(__('LINK_LOGOUT'), '@user_signout', array('class' => 'logout')); ?>
