<?php

/*
 * This file is part of Lyra CMS. Lyra CMS is free software; you can redistribute
 * it and/or modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see <http://www.gnu.org/licenses>.
 */

/**
 * LyraConfig
 *
 * @package lyra
 * @subpackage lib
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */

class LyraConfig
{
  protected
    $object = null,
    $params = null,
    $def_file = null;

  public function __construct($object = null)
  {
    if($object)
    {
      $this->setObject($object);
    }
  }
  public function setObject($object)
  {
    $this->object = $object;
  }
  public function get($key, $section = null)
  {
      $value = null;
      $levels = is_object($this->object) ? $this->object->getParameterLevels() : array(array('type' => 'global', 'def_section' => null));
      
      foreach($levels as $i => $level)
      {
        if(!isset($this->params[$i]))
        {
          $this->initParams($level['type'], $i);
        }
        $value = $this->params[$i]->get($key, isset($section) ? $section : $level['def_section']);
        if(null !== $value)
        {
          break;
        }
        
      }
      if(null === $value)
      {
        $value = $this->params[$i]->getDefault($key, isset($section) ? $section : $level['def_section']);
      }
      return $value;
  }
  public function keyExists($key, $section = null)
  {
    $levels = is_object($this->object) ? $this->object->getParameterLevels() : array(array('type' => 'global', 'def_section' => null));

    foreach($levels as $i => $level)
    {
      if(!isset($this->params[$i]))
      {
        $this->initParams($level['type'], $i);
      }
      if($this->params[$i]->keyExists($key, isset($section) ? $section : $level['def_section']))
      {
        return true;
      }
    }

    return false;
  }
  public function mergeConfig($config, $section = null)
  {
    foreach($config as $k => $v)
    {
      if($this->keyExists($k, $section))
      {
        $config[$k] = $this->get($k, $section);
      }
    }

    return $config;
  }
  protected function initGlobalParams()
  {
    $cache = sfConfig::get('sf_cache_dir') . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . sfConfig::get('sf_environment') . DIRECTORY_SEPARATOR . 'lyra_settings.cache.php';
    if(file_exists($cache))
    {
      require $cache;
      return new LyraParams($data, sfConfig::get('sf_config_dir') . '/lyra_params.yml');
    }
    $settings = Doctrine_Query::create()
      ->from('LyraSettings')
      ->fetchOne();

    $params = new LyraParams($settings, sfConfig::get('sf_config_dir') . '/lyra_params.yml');

    if($cache)
    {
      $c = new LyraCache($cache);
      $c->save($params->getParamValues());
    }

    return $params;
  }
  protected function initParams($holder, $idx)
  {
    switch($holder)
    {
      case 'object':
        $def_file = $this->object->getParamDefinitionsPath();
        $this->params[$idx] = new LyraParams($this->object, $def_file);
        break;
      case 'content_type':
        //TODO: *ugly*, relation names must be made consistent.
        if($this->object instanceof LyraContent)
        {
          $ctype = $this->object->getContentType();
        }
        elseif($this->object instanceof LyraRoute)
        {
          $ctype = $this->object->getRouteContentType();
        }
        $def_file = $ctype->getParamDefinitionsPath();
        $this->params[$idx] = new LyraParams($ctype, $def_file);
        break;
      case 'global':
        $this->params[$idx] = $this->initGlobalParams();
        break;
    }
  }
}