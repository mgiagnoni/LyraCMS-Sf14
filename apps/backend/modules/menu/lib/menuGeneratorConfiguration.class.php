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
 * menuGeneratorConfiguration
 *
 * @package lyra
 * @subpackage menu
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class menuGeneratorConfiguration extends BaseMenuGeneratorConfiguration
{
  public function getFormOptions()
  {
    $ctype_id = $list_id = null;
    $request = sfContext::getInstance()->getRequest();
    $user = sfContext::getInstance()->getUser();

    if($request->isMethod('GET'))
    {
      $defaults = array();
      if($request->hasParameter('ctype_id'))
      {
        $ctype_id = $request->getParameter('ctype_id');
        $defaults['ctype_id'] = $ctype_id;
      }
      if($request->hasParameter('list_id'))
      {
        $list_id = $request->getParameter('list_id');
        $defaults['list_id'] = $list_id;
      }
      if($request->hasParameter('type'))
      {
        $type = $request->getParameter('type');
        $defaults['type'] = $type;
      }
      if(count($defaults) > 0)
      {
        $user->setAttribute('default_data', $defaults, 'LyraMenuForm');
      }
    }
 
    return array('user' => $user);
  }
}
