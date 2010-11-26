<?php

/*
 * This file is part of Lyra CMS. Lyra CMS is free software; you can redistribute
 * it and/or modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see <http://www.gnu.org/licenses>.
*/

require_once dirname(__FILE__).'/../lib/menuGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/menuGeneratorHelper.class.php';

/**
 * menuActions
 *
 * @package lyra
 * @subpackage menu
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class menuActions extends autoMenuActions
{
  public function executeListNewItem(sfWebRequest $request)
  {
    $this->content_types = Doctrine_Query::create()
      ->from('LyraContentType t')
      ->leftJoin('t.ContentTypeRoutes r')
      ->orderBy('t.type')
      ->execute();
  }
  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    $object = $this->getRoute()->getObject();
    if ($object->getNode()->isValidNode()) {
      $object->getNode()->delete();
    } else {
      $object->delete();
    }

    $this->getUser()->setFlash('notice', 'MSG_MENU_DELETED');

    $this->redirect('@lyra_menu');
  }
  public function executeDown(sfWebRequest $request)
  {
    $record = $this->getRoute()->getObject();

    $next = $record->getNode()->getNextSibling();
    if($next) {
      $record->getNode()->moveAsNextSiblingOf($next);
    }

    $this->redirect('@lyra_menu');
  }
  public function executeUp(sfWebRequest $request)
  {
    $record = $this->getRoute()->getObject();

    $prev = $record->getNode()->getPrevSibling();
    if($prev) {
      $record->getNode()->moveAsPrevSiblingOf($prev);
    }

    $this->redirect('@lyra_menu');
  }
  protected function addSortQuery($query)
  {
    $query->addOrderBy('root_id, lft');
  }
}
