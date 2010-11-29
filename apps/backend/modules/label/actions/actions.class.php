<?php

/*
 * This file is part of Lyra CMS. Lyra CMS is free software; you can redistribute
 * it and/or modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see <http://www.gnu.org/licenses>.
 */

require_once dirname(__FILE__).'/../lib/labelGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/labelGeneratorHelper.class.php';

/**
 * labelActions
 *
 * @package lyra
 * @subpackage label
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class labelActions extends autoLabelActions
{
  protected
    $catalog = null;

  public function execute($request)
  {
    $this->forward404Unless($catalog_id = $request->getUrlParameter('catalog_id'));
    $this->forward404Unless($this->catalog = LyraCatalogTable::getInstance()
      ->find($catalog_id));

    $this->getContext()->getRouting()
      ->setDefaultParameter('catalog_id', $catalog_id);

    $result = parent::execute($request);

    if (isset($this->form) &&
        $this->form->getObject() &&
        $this->form->getObject()->isNew())
    {
      $this->form->getObject()->catalog_id = $catalog_id;
    }

    return $result;
  }
  public function executeIndex(sfWebRequest $request)
  {
    
    $this->getResponse()->setSlot(
      'page_title',
      $this->getContext()->getI18N()->__('TITLE_LABELS') . ' '.
      $this->getContext()->getI18N()->__('TITLE_CATALOG', array('%catalog%'=>$this->catalog->getName()))
    );
    parent::executeIndex($request);
  }
  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    $object = $this->getRoute()->getObject();
    $object->deleteAsNode();

    $this->getUser()->setFlash('notice', 'MSG_LABEL_DELETED');

    $this->redirect('@lyra_label');
  }
  public function executeDown(sfWebRequest $request)
  {
    $record = $this->getRoute()->getObject();

    $next = $record->getNode()->getNextSibling();
    if($next) {
      $record->getNode()->moveAsNextSiblingOf($next);
    }

    $this->redirect('@lyra_label');
  }
  public function executeUp(sfWebRequest $request)
  {
    $record = $this->getRoute()->getObject();

    $prev = $record->getNode()->getPrevSibling();
    if($prev) {
      $record->getNode()->moveAsPrevSiblingOf($prev);
    }

    $this->redirect('@lyra_label');
  }
  protected function addSortQuery($query)
  {
    $alias = $query->getRootAlias();
    $query->andWhere($alias . '.catalog_id = ? AND ' .$alias .'.level > 0', $this->getRequest()->getParameter('catalog_id',0));
    $query->addOrderBy('root_id, lft');
  }

  protected function executeBatchDelete(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');

    $records = Doctrine_Query::create()
      ->from('LyraLabel')
      ->whereIn('id', $ids)
      ->execute();

    foreach ($records as $record)
    {
      $record->deleteAsNode();
    }

    $this->getUser()->setFlash('notice', 'The selected items have been deleted successfully.');
    $this->redirect('@lyra_label');
  }
}
