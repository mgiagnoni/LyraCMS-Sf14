<?php
/*
 * This file is part of Lyra CMS. Lyra CMS is free software; you can redistribute
 * it and/or modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see <http://www.gnu.org/licenses>.
 */

require_once dirname(__FILE__).'/../lib/routeGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/routeGeneratorHelper.class.php';

/**
 * routeActions
 *
 * @package lyra
 * @subpackage route
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class routeActions extends autoRouteActions
{
  protected $content_type = null;

  public function execute($request)
  {
    $this->forward404Unless($ctype_id = $request->getUrlParameter('ctype_id'));
    $this->forward404Unless($this->content_type = LyraContentTypeTable::getInstance()
      ->find($ctype_id));

    $this->getContext()->getRouting()
      ->setDefaultParameter('ctype_id', $ctype_id);

    $result = parent::execute($request);

    if (isset($this->form) &&
        $this->form->getObject() &&
        $this->form->getObject()->isNew())
    {
      $this->form->getObject()->ctype_id = $ctype_id;
    }

    return $result;
  }
  public function buildQuery()
  {
    $query = parent::buildQuery();
    return $query->andWhere('ctype_id = ?', $this->content_type->getId());
  }
}
