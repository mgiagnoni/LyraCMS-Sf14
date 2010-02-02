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
  protected static $prev_id = null;
  protected static $ctype = null;
  protected $item_params = null;

  public function getCfg($key)
  {
    $ctype_id = $this->getCtypeId();
    $ctype = $this->getContentType();
    
    if(!isset(self::$param_defs[$ctype_id])) {
      $config = new LyraParams($ctype->getModule(), $ctype->getPlugin());
      self::$param_defs[$ctype_id] = $config->getParams();
    }
    
    if(!isset(self::$param_defs[$ctype_id][$key])) {
      //TODO: raise exception
      return;
    }

    $levels = array('item', 'content_type');
    if(isset(self::$param_defs[$ctype_id][$key]['level'])) {
      $levels = self::$param_defs[$ctype_id][$key]['level'];
    }
    $levels[] = 'default';
    foreach($levels as $level) {
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

        case 'content_type':
          if(!isset(self::$ctype_params[$ctype_id])) {
            self::$ctype_params[$ctype_id] = unserialize(html_entity_decode(self::$ctype->getParams(), ENT_QUOTES));
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
  public function getContentType()
  {
    $ctype_id = $this->getCtypeId();
    if($ctype_id !== self::$prev_id) {
      self::$ctype = Doctrine::getTable('LyraContentType')
        ->find($ctype_id);
      self::$prev_id = $ctype_id;
    }
    return self::$ctype;
  }
}
