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
 * LyraContent
 *
 * @package lyra
 * @subpackage model
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class LyraContent extends BaseLyraContent
{
  protected static $param_defs = null;
  protected static $ctype_params = null;
  protected $item_params = null;

  public function getCfg($key)
  {
    $ctype_id = $this->getCtypeId();

    if(!isset(self::$param_defs[$ctype_id])) {
      $ctype = Doctrine::getTable('LyraContentType')
        ->find($ctype_id);
      $defs = sfYaml::load(sfConfig::get('sf_config_dir') . '/params/' . $ctype->getName() . '.yml');
      self::$param_defs[$ctype_id] = $defs['all'];
    }
    
    if(!isset(self::$param_defs[$ctype_id][$key])) {
      //TODO: raise exception
      return;
    }

    foreach(array('item', 'ctype', 'default') as $level) {
      $value = null;

      switch($level) {
        case 'item':
          if(!isset($this->item_params)) {
            $this->item_params = unserialize(html_entity_decode($this->getParams(), ENT_QUOTES));
          }
          if(isset($this->item_params[$key])) {
            $value = $this->item_params[$key];
          }
          break;

        case 'ctype':
          if(!isset(self::$ctype_params[$ctype_id])) {
            $ctype = Doctrine::getTable('LyraContentType')
              ->find($ctype_id);
            self::$ctype_params[$ctype_id] = unserialize(html_entity_decode($ctype->getParams(), ENT_QUOTES));
          }
          if(isset(self::$ctype_params[$ctype_id][$key])) {
            $value = self::$ctype_params[$ctype_id][$key];
          }
          break;
        
        case 'default':
          if(isset(self::$param_defs[$ctype_id][$key]['default']))
            $value = self::$param_defs[$ctype_id][$key]['default'];
          break;
      }
      
      if(isset($value)) {
        //value found: end foreach
        break;
      }
    }
    return $value;
  }
}
