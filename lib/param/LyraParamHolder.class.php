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
 * LyraParamHolder
 *
 * @package lyra
 * @subpackage param
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */

class LyraParamHolder
{
  /**
   * Parameters definitions
   *
   * @var mixed
   */
  protected
    $definitions = null;

  /**
   * Parameters values
   *
   * @var mixed
   */
  protected
    $values = null;

  /**
   * Merged values (parameter values after executing a mergeValues() method)
   * 
   * @var mixed 
   */
  protected
    $merged = null;

  /**
   * Parameters default values
   *
   * @var mixed
   */
  protected
    $defaults = null;

  /**
   * Translation catalog
   *
   * @var string
   */
  protected
    $trans_catalog = null;

  public function __construct($source, $section = null, $defs_file = null)
  {
    $this->setValues($source);
    if(null == $section && is_object($source))
    {
      $section = $source->getParamDefinitionsSection();
    }
    if(null == $defs_file && is_object($source))
    {
      $defs_file = $source->getParamDefinitionsPath();
    }
    $this->definitions = $this->loadDefinitions($defs_file, $section);
    $this->defaults = $this->loadDefaults();
  }
  public function get($key, $chk_default = true)
  {
    if(!isset($this->definitions[$key]))
    {
      throw new sfException("Parameter '$key' not found.");
    }

    if(!isset($this->merged))
    {
      $this->merged = $this->values;
    }
    $value = null;
    if(isset($this->merged[$key]))
    {
      $value = $this->merged[$key];
    }
    if($chk_default && null === $value && isset($this->defaults[$key]))
    {
      $value = $this->defaults[$key];
    }

    return $value;
  }
  public function getValues()
  {
    if(isset($this->merged))
    {
      return $this->merged;
    }

    return $this->values;
  }
  public function getDefaultValues()
  {
    return $this->defaults;
  }
  public function setValues($source)
  {
    $values = array();
    if(is_object($source))
    {
      $values = $source->getParams();
      if(!is_array($values))
      {
        $values = array();
      }
    }
    else if(is_array($source))
    {
      $values = $source;
    }
    $this->values = $values;
  }
  public function mergeValues($source)
  {
    $values = is_object($source) ? $source->getParams() : $source;
    if(!is_array($values))
    {
      $values = array();
    }
    $this->merged = array_merge($this->values, $values);
  }
  public function mergeDefs($defs_file, $section = null)
  {
    $this->definitions = array_merge($this->definitions, $this->loadDefinitions($defs_file, $section));
  }
  public function getParamDefs()
  {
    return $this->definitions;
  }
  public function checkValues($values)
  {
    $params = array();
    if($defs = $this->getParamDefs())
    {
      foreach($defs as $k => $v)
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
    }
    return $params;
  }
  public function getCatalog()
  {
    return $this->trans_catalog;
  }
  public function setCatalog($catalog)
  {
    $this->trans_catalog = $catalog;
  }
  protected function loadDefinitions($defs_file, $section = null)
  {
    if(!file_exists($defs_file))
    {
      throw new sfException('Parameters definitions file not found.');
    }

    $data = sfYaml::load($defs_file);
    $defs = $data['params'];

    if(null !== $section)
    {
      foreach(explode('/', $section) as $s)
      {
        $defs = $defs[$s];
      }
    }
    return $defs;
  }
  protected function loadDefaults()
  {
    $defaults = array();
    if($defs = $this->getParamDefs())
    {
      foreach($defs as $k => $v)
      {
        if(isset($v['default']))
        {
          $defaults[$k] = $v['default'];
        }
      }
    }
    return $defaults;
  }
}
