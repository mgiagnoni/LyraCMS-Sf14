<?php

/**
 * LyraRoute
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    lyra
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id$
 */
class LyraRoute extends BaseLyraRoute
{
  public function getParamDefinitionsPath()
  {
    $ctype = $this->getRouteContentType();
    
    $def_file = sfConfig::get('sf_apps_dir') . '/backend/modules/' . $ctype->getModule() . '/config/params.yml';
    if(!file_exists($def_file) && $ctype->getPlugin()) {
      $def_file = sfConfig::get('sf_plugins_dir') . '/' . $ctype->getPlugin() . '/modules/' . $ctype->getModule() . '/config/params.yml';
    }

    return $def_file;
  }
  public function getParamDefinitionsSection()
  {
    return 'lists/' . $this->getAction() . '/other';
  }
}
