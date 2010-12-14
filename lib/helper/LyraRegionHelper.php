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
 * LyraRegionHelper
 *
 * @package lyra
 * @subpackage helper
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
function include_region($region_name)
{
  $region = LyraRegionTable::getInstance()
    ->createQuery('a')
    ->innerJoin('a.RefComponents rc')
    ->innerJoin('rc.Component co')
    ->where('a.name = ?', $region_name)
    ->fetchOne();

  if(!$region)
  {
    throw new sfException("Region '$region_name' does not exist.");
  }

  foreach($region->getRefComponents() as $record)
  {
    $params = array();
    if($record->getParams())
    {
      $params = unserialize($record->getParams());
    }
    $component = $record->getComponent();
    $ctype = $component->getComponentContentType();
    if($ctype)
    {
      $params['ctype'] = $ctype;
    }
    if($component->getModule())
    {
      $module = $component->getModule();
    }
    else
    {
      $module = $ctype->getModule();
    }
    
    include_component($module, $component->getAction(), $params);
  }
}