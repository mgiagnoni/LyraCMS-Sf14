<?php
class userGeneratorConfiguration extends BaseUserGeneratorConfiguration
{
  public function getFormOptions()
  {
    return array(
      'break_at' => 'PANEL_PERMISSIONS'
    );
  }
}
