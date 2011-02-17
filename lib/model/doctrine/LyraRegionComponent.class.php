<?php

/**
 * LyraRegionComponent
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    lyra
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class LyraRegionComponent extends BaseLyraRegionComponent
{
  public function getParamDefinitionsPath()
  {
    return $this->getComponent()->getParamDefinitionsPath();
  }
  public function getParamDefinitionsSection()
  {
    return $this->getComponent()->getParamDefinitionsSection();
  }
  public function postSave($event)
  {
    $cache = new LyraCache('region_' . $this->getRegion()->getName());
    $cache->delete();
  }
}
