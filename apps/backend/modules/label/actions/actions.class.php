<?php

require_once dirname(__FILE__).'/../lib/labelGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/labelGeneratorHelper.class.php';

/**
 * label actions.
 *
 * @package    lyra
 * @subpackage label
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class labelActions extends autoLabelActions
{
  public function executeIndex(sfWebRequest $request)
  {
    if($request->getParameter('id')) {
      //$this->setFilters(array('catalog_id'=>$request->getParameter('id')));
      $this->getUser()->setAttribute('lyra_catalog_id', $request->getParameter('id', 0));
    }

    $catalog = Doctrine::getTable('LyraCatalog')->find(
      $this->getUser()->getAttribute('lyra_catalog_id', 0)
    );
    if($catalog) {
      $this->getResponse()->setSlot(
        'page_title',
        $this->getContext()->getI18N()->__('TITLE_LABELS') . ' '.
        $this->getContext()->getI18N()->__('TITLE_CATALOG', array('%catalog%'=>$catalog->getName()))
      );
    }
    parent::executeIndex($request);
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

    $this->getUser()->setFlash('notice', 'MSG_LABEL_DELETED');

    $this->redirect('@lyra_label_label');
  }
  public function executeMove(sfWebRequest $request)
  {
    $record = $this->getRoute()->getObject();
    
    switch($request->getParameter('dir')) {
      case 0:
        $next = $record->getNode()->getNextSibling();
        if($next) {
          $record->getNode()->moveAsNextSiblingOf($next);
        }
        break;
      case 1:
        $prev = $record->getNode()->getPrevSibling();
        if($prev) {
          $record->getNode()->moveAsPrevSiblingOf($prev);
        }
        break;
    }
    $this->redirect('@lyra_label_label');
  }
  protected function addSortQuery($query)
  {
    $alias = $query->getRootAlias();
    $query->andWhere($alias . '.catalog_id = ? AND ' .$alias .'.level > 0', $this->getUser()->getAttribute('lyra_catalog_id',0));
    $query->addOrderBy('root_id, lft');
  }
}
