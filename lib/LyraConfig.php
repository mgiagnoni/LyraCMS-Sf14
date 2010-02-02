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
 * LyraCfg
 *
 * @package lyra
 * @subpackage lib
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */

class LyraCfg
{
  protected static $global_params = null;

  public static function get($key)
  {
    if(!isset(self::$global_params)) {
      self::load();
    }
    if(!isset(self::$global_params[$key])) {
      //TODO: raise exception
      return false;
    }
    return self::$global_params[$key];
  }
  public static function set($key, $value)
  {
    if(!isset(self::$global_params)) {
      self::load();
    }
    self::$global_params[$key] = $value;
  }
  protected static function load()
  {
    $settings = Doctrine_Query::create()
      ->from('LyraSettings')
      ->fetchOne();
    self::$global_params = unserialize($settings->getParams());
  }
}
?>
