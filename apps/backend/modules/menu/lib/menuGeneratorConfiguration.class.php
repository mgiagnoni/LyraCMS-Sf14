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
    $ctype_id = $view_id = null;
    $request = sfContext::getInstance()->getRequest();
    if($request->isMethod('POST')) {
      $values = $request->getParameter('menu_item');
      $type = $values['type'];
      if($type == 'list' || $type == 'object')
      {
        $ctype_id = $values['ctype_id'];
        $view_id = $values['element_id'];
        $type = $values['type'];
      }
    } 
    else
    {
      $ctype_id = $request->getParameter('ctype_id');
      $view_id = $request->getParameter('view_id');
      $type = $request->getParameter('type');
    }
    return array(
      'user' => sfContext::getInstance()->getUser(),
      'ctype_id' => $ctype_id,
      'view_id' => $view_id,
      'type' => $type
    );
  }
}
