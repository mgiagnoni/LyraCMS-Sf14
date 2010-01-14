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
  protected $params = null;
  protected $values = null;
 
  public function __construct($ctype)
  {
    $opt = sfYaml::load(sfConfig::get('sf_config_dir') . '/params/' . $ctype . '.yml');
    $this->params = $opt['all'];
  }
  public function getParams()
  {
    return $this->params;
  }
  public function setObject($obj) {
    $this->values = unserialize(html_entity_decode($obj->getParams(), ENT_QUOTES));;
  }
  public function getValue($key)
  {
    $v = null;
    
    if(!isset($this->params[$key])) {
      //TODO: raise exception
      return;
    }
    if(isset($this->values[$key])) {
       $v = $this->values[$key];
    }

    return $v;
  }
  public function serialize($values)
  {
    $params = array();
    $out = '';

    foreach($this->params as $k => $v) {
      $val = $values[$k];

      switch($v['type']) {
        case 'boolean':
          if(isset($val) && $val !== '') {
            $params[$k] = (boolean)$val;
          }
          break;

        case 'list':
          if(isset($val) && $val !== '') {
            $params[$k] = $val;
          }
          break;
      }
    }
    if(count($params)) {
      $out = serialize($params);
    }
    return $out;
  }
}