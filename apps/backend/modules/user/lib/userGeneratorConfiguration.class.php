<?php
class userGeneratorConfiguration extends BaseUserGeneratorConfiguration
{
  public function getFormOptions()
  {
    return array(
      'user' => sfContext::getInstance()->getUser(),
      'break_at' => 'PANEL_PERMISSIONS'
    );
  }
  public function getFormDisplay()
  {
    $fieldsets = parent::getFormDisplay();
    $user = sfContext::getInstance()->getUser();
    if(!$user->hasCredential('user_permissions'))
    {
      unset(
        $fieldsets['PANEL_PERMISSIONS'][3]
      );
    }
    if(!$user->isSuperAdmin())
    {
      unset(
        $fieldsets['PANEL_PERMISSIONS'][1]
      );
    }

    return $fieldsets;
  }
}
