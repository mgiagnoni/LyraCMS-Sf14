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
  $region = LyraRegionTable::getInstance()->getRegionData($region_name);
  $request = sfContext::getInstance()->getRequest();
  $content = $request->getParameter('ctype');
  $action = $request->getParameter('action');

  foreach($region['components'] as $component)
  {
    if($content && isset($component['visibility']['content']))
    {
      $v = $component['visibility']['content'];
      $keys = array($content . '.all');
      if(!empty($action))
      {
        $keys[] = $content . '.' . $action;
      }
      $f = count(array_intersect($keys, $v)) > 0;
      if(($component['vis_flag'] && !$f) || (!$component['vis_flag'] && $f) )
      {
        continue;
      }
    }
    $params = new LyraParamHolder($component['params'], $component['action'], $component['param_defs']);
    include_component($component['module'], $component['action'], array( 'ctype' => $component['ctype'], 'params' => $params));
  }
}
