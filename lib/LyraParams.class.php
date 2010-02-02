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
  protected
    $params = null,
    $values = null,
    $trans_catalog = null;

  public function __construct($module = '', $plugin = '')
  {

    if($module) {
      $params_defs = null;
      $params_defs = sfConfig::get('sf_apps_dir') . '/backend/modules/' . $module . '/config/params.yml';
      if(!file_exists($params_defs) && $plugin) {
        $params_defs = sfConfig::get('sf_plugins_dir') . '/' . $plugin . '/modules/' . $module . '/config/params.yml';
      }

      if(!$params_defs || !file_exists($params_defs)) {
          //TODO: raise exception
      }

      $defs = sfYaml::load($params_defs);
      $this->setCatalog(sfInflector::underscore($module) . '_params');
      $this->setParams($defs['all']);
    }
  }
  public function getParams()
  {
    return $this->params;
  }
  public function setParams($params)
  {
    $this->params = $params;
  }
  public function getCatalog()
  {
    return $this->trans_catalog;
  }
  public function setCatalog($catalog)
  {
    $this->trans_catalog = $catalog;
  }
  public function setObject($obj, $key = null) {
    $values = unserialize(html_entity_decode($obj->getParams(), ENT_QUOTES));
    if($key) {
      $values = $values[$key];
    }
    $this->values = $values;
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
  public function checkValues($values)
  {
    $params = array();

    foreach($this->params as $k => $v) {
      if(!isset($values[$k])) {
        continue;
      }
      $val = $values[$k];

      switch($v['type']) {
        case 'boolean':
          if(isset($val) && $val !== '') {
            $params[$k] = (boolean)$val;
          }
          break;

        case 'list':
        case 'text':
          if(isset($val) && $val !== '') {
            $params[$k] = $val;
          }
          break;
      }
    }

    return $params;
  }
}