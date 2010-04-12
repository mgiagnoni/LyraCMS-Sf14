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
  protected static
    $ctypes_params = null;
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
    if($this->object instanceof LyraContent)
    {
      return $this->getItemParamValue($key);
    }
    elseif($this->object instanceof LyraContentView)
    {
      return $this->getViewParamValue($key);
    }
    elseif($this->object == 'settings')
    {
      return $this->getGlobalParamValue($key, $section);
    }
    throw new sfException("Can't get parameter '$key'. Configuration object not set");
  }
  protected function getItemParamValue($key)
  {
    $ctype = $this->object->getContentType();

    if(!isset($this->def_file))
    {
      $this->def_file = $this->getParamDefinitionsPath($ctype->getModule(), $ctype->getPlugin());
    }

    if(!isset($this->params))
    {
      $this->params = new LyraParams($this->object, $this->def_file);
    }
    $value = $this->params->get($key, 'item');

    if(null === $value)
    {
      if(!isset(self::$ctypes_params[$ctype->getId()]))
      {
        self::$ctypes_params[$ctype->getId()] = new LyraParams($ctype, $this->def_file);
      }
      $value = self::$ctypes_params[$ctype->getId()]->get($key, 'item');
    }

    if(null === $value)
    {
      $value = $this->params->getDefault($key, 'item');
    }

    return $value;
  }
  protected function getViewParamValue($key)
  {
    $ctype = $this->object->getViewContentType();

    if(!isset($this->def_file))
    {
      $this->def_file = $this->getParamDefinitionsPath($ctype->getModule(), $ctype->getPlugin(), $this->object->getAction());
    }

    if(!isset($this->params))
    {
      $this->params = new LyraParams($this->object, $this->def_file);
    }
    $value = $this->params->get($key);

    if(null === $value)
    {
      if(!isset(self::$ctypes_params[$ctype->getId()]))
      {
        $def_file = $this->getParamDefinitionsPath($ctype->getModule(), $ctype->getPlugin());
        self::$ctypes_params[$ctype->getId()] = new LyraParams($ctype, $def_file);
      }
      $value = self::$ctypes_params[$ctype->getId()]->get($key, 'views');
    }

    if(null === $value)
    {
      $value = $this->params->getDefault($key);
    }

    return $value;
  }
  protected function getGlobalParamValue($key, $section)
  {
    $this->initGlobalParams();
    return $this->params->get($key, $section);
  }
  protected function getParamDefinitionsPath($module, $plugin, $action = '')
  {
    $mp = '/modules/' . $module . '/config/' . ($action ? $action . '_' : '') . 'params.yml';
    $path = sfConfig::get('sf_apps_dir') . '/backend' . $mp;
    if(!file_exists($path) && $plugin)
    {
      $path = sfConfig::get('sf_plugins_dir') . '/' . $plugin . $mp;
    }
    return $path;
  }
  protected function initGlobalParams()
  {
    if(!isset($this->params))
    {
      $settings = Doctrine_Query::create()
        ->from('LyraSettings')
        ->fetchOne();

      $this->params = new LyraParams($settings, sfConfig::get('sf_config_dir') . '/lyra_params.yml');
    }
  }
}