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
 * LyraMenuTable
 *
 * @package lyra
 * @subpackage model
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */

class LyraMenuTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
      return Doctrine_Core::getTable('LyraMenu');
    }
    public function getMenuTree($menu_name)
    {
      //TODO: make menu caching configurable. For now menu cache is active only in prod environment.
      $cache = null;
      if(sfConfig::get('sf_environment') == 'prod')
      {
        $cache = sfConfig::get('sf_cache_dir') . DIRECTORY_SEPARATOR . sfConfig::get('sf_app') . DIRECTORY_SEPARATOR . sfConfig::get('sf_environment') . DIRECTORY_SEPARATOR . 'lyra_menu_'. $menu_name . '.cache.php';

        if(file_exists($cache))
        {
          $data = file_get_contents($cache);
          return unserialize($data);
        }
      }

      $menu = $this->findOneByName($menu_name);
      if(!$menu)
      {
        throw new sfException("Menu '$menu_name' not found");
      }
      if($data = $menu->getMenuTree())
      {
        if($cache)
        {
          file_put_contents($cache, serialize($data));
        }
      }
      return $data;
    }
}