<?php

/**
 * LyraComponent
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    lyra
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class LyraComponent extends BaseLyraComponent
{
  public function __toString()
  {
    return $this->getAction();
  }
  public function getParamDefinitionsPath()
  {
    $def_file = sfConfig::get('sf_apps_dir') . '/backend/modules/' . $this->getModuleName() . '/config/components.yml';

    if(!file_exists($def_file))
    {
      $ctype = $this->getComponentContentType();
      if($plugin = $ctype->getPlugin())
      {
        $def_file = sfConfig::get('sf_plugins_dir') . '/' . $plugin . '/modules/' . $ctype->getModule() . '/config/components.yml';
      }
    }

    return $def_file;
  }
  public function getModuleName()
  {

    if($this->getCtypeId())
    {
      $module = $this->getComponentContentType()->getModule();
    }
    else
    {
      $module = $this->getModule();
    }

    return $module;
  }
}