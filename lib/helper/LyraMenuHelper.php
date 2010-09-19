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
 * LyraMenuHelper
 *
 * @package lyra
 * @subpackage helper
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
function menu_tree($items)
{
  $prevLevel = -1;
  $curLevel = -1;
  $html = '';

  foreach($items as $item)
  {
    $curLevel = $item['level'];
    if($curLevel > $prevLevel)
    {
      $html .= ($html ? '<ul>' : '<ul class="menu">') . '<li>';
    }
    else if($curLevel < $prevLevel)
    {
      for($tmp = $prevLevel; $tmp > $curLevel; $tmp--)
      {
        $html .= '</li></ul>';
      }
      $html .= '</li><li>';
    }
    else
    {
      $html .= '</li><li>';
    }
    $html .= generate_menu_link($item);
    $prevLevel = $curLevel;
  }
  for($tmp = $curLevel; $tmp > 0; $tmp--)
  {
    $html .= '</li></ul>';
  }
  return $html;
}
function generate_menu_link($item)
{
  $ctype = $item['MenuContentType'];

  switch($item['type'])
  {
    case 'object':
      $html = link_to($item['name'], $ctype['type'] . '_show', array_merge($item->getRaw('obj_params'), array('ctype' => $ctype)));
      break;
    case 'list':
      $html = link_to($item['name'], $ctype['type'] . '_index');
      break;
    case 'route':
      $html =  link_to($item['name'], $item['params']['route_name']);
      break;
    case 'external':
      $html =  link_to($item['name'], $item['params']['url']);
      break;
    case 'placeholder':
      break;
  }
  return $html;
}