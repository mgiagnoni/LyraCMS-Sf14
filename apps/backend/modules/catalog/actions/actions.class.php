<?php

/*
 * This file is part of Lyra CMS. Lyra CMS is free software; you can redistribute
 * it and/or modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see <http://www.gnu.org/licenses>.
 */

require_once dirname(__FILE__).'/../lib/catalogGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/catalogGeneratorHelper.class.php';

/**
 * catalogActions
 *
 * @package lyra
 * @subpackage catalog
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class catalogActions extends autoCatalogActions
{
  public function executePublish(sfwebRequest $request)
  {
    $this->lyra_catalog = $this->getRoute()->getObject();
    $this->lyra_catalog->publish();
    $this->getUser()->setFlash('notice', 'MSG_CATALOG_PUBLISHED');
    $this->redirect('@lyra_catalog');
  }
  public function executeUnpublish(sfwebRequest $request)
  {
    $this->lyra_catalog = $this->getRoute()->getObject();
    $this->lyra_catalog->publish(false);
    $this->getUser()->setFlash('notice', 'MSG_CATALOG_UNPUBLISHED');
    $this->redirect('@lyra_catalog');
  }
}
