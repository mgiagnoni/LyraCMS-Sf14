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
 * LyraParams
 *
 * @package lyra
 * @subpackage lib
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class LyraParams
{
  /**
   * Parameters definitions
   *
   * @var mixed
   */
  protected
    $param_defs = null;

  /**
   * Parameters values
   *
   * @var mixed
   */
  protected
    $param_values = null;

  /**
   * Parameters definitions file
   *
   * @var string
   */
  protected
    $defs_file;

  /**
   * Translation catalog
   *
   * @var string
   */
  protected
    $trans_catalog = null;

  public function __construct($object, $defs_file)
  {
    if(is_object($object))
    {
      $this->setObject($object);
    }
    if(!file_exists($defs_file))
    {
      throw new sfException('Parameters definitions file not found.');
    }
    $this->defs_file = $defs_file;

  }
  public function loadDefinitions()
  {
    $data = sfYaml::load($this->defs_file);
    $this->param_defs = $data;
  }
  public function getParamDefs($section = null)
  {
    if(!isset($this->param_defs))
    {
      $this->loadDefinitions();
    }

    if(null !== $section)
    {
      return $this->param_defs['params'][$section];
    }
    else
    {
      return $this->param_defs['params'];
    }
  }
  public function getParamDefsSections()
  {
    return array_keys($this->getParamDefs());
  }
  public function setParamValues($values)
  {
    if(!isset($this->param_values))
    {
      if(!is_array($values))
      {
        $values = unserialize(html_entity_decode($values, ENT_QUOTES));
      }
      $this->param_values = $values;
    }
  }
  public function get($key, $section = null)
  {
    $param_defs = $this->getParamDefs($section);

    if(!isset($param_defs[$key])) {
      throw new sfException("Parameter '$key' not found.");
    }

    if(isset($this->param_values[$key]))
    {
      return $this->param_values[$key];
    }
  }
  public function getDefault($key, $section = null)
  {
    $param_defs = $this->getParamDefs($section);

    if(!isset($param_defs[$key])) {
      throw new sfException("Parameter '$key' not found.");
    }

    if(isset($param_defs[$key]['default']))
    {
      return $param_defs[$key]['default'];
    }
  }

  public function getCatalog()
  {
    return $this->trans_catalog;
  }
  public function setCatalog($catalog)
  {
    $this->trans_catalog = $catalog;
  }
  public function setObject($object)
  {
    $this->setParamValues($object->getParams());
  }

  public function checkValues($values, $section = null)
  {
    $params = array();

    foreach($this->getParamDefs($section) as $k => $v)
    {
      if(!isset($values[$k]))
      {
        continue;
      }
      $val = $values[$k];

      switch($v['type'])
      {
        case 'boolean':
          if(isset($val) && $val !== '')
          {
            $params[$k] = (boolean)$val;
          }
          break;

        case 'list':
        case 'text':
          if(isset($val) && $val !== '')
          {
            $params[$k] = $val;
          }
          break;
      }
    }

    return $params;
  }
}