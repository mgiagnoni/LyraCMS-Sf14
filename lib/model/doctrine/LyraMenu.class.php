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
 * LyraMenu
 *
 * @package lyra
 * @subpackage model
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class LyraMenu extends BaseLyraMenu
{
  function getIndentName()
  {
    return str_repeat('-- ', $this->level) . $this->name;
  }
  public function getMenuTree()
  {
    $q = Doctrine_Query::create()
      ->from('LyraMenu m')
      ->leftJoin('m.MenuContentType c')
      ->where('m.root_id = ? AND m.lft > ? AND m.rgt < ?')
      ->orderBy('m.lft asc');

    $items = $q->execute(array($this->getId(), $this->getLft(), $this->getRgt()), Doctrine::HYDRATE_ARRAY);
    if($ct = count($items))
    {
      for($i = 0; $i < $ct; $i++)
      {
        $item = $items[$i];

        if($item['params'])
        {
          $items[$i]['params'] = unserialize($item['params']);
        }

        if($item['type'] == 'object')
        {
          $obj = Doctrine_Core::getTable($item['MenuContentType']['model'])
          ->find($item['element_id']);
          $params = array();
          if(preg_match_all('#([^:/\.]+)#', $item['MenuContentType']['item_slug'], $matches)) {
            foreach($matches[0] as $field) {
              $params[$field] = $obj->$field;
            }
          }
          $params['path'] = $obj->getPath();
          $items[$i]['obj_params'] = $params;
        }
      }
    }
    return $items;
  }
}