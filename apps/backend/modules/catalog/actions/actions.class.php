<?php

require_once dirname(__FILE__).'/../lib/catalogGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/catalogGeneratorHelper.class.php';

/**
 * catalog actions.
 *
 * @package    lyra
 * @subpackage catalog
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class catalogActions extends autoCatalogActions
{
  public function executePublish(sfwebRequest $request)
  {
    $this->lyra_catalog = $this->getRoute()->getObject();
    $this->lyra_catalog->publish();
    $this->getUser()->setFlash('notice', 'MSG_CATALOG_PUBLISHED');
    $this->redirect('@lyra_catalog_catalog');
  }
  public function executeUnpublish(sfwebRequest $request)
  {
    $this->lyra_catalog = $this->getRoute()->getObject();
    $this->lyra_catalog->publish(false);
    $this->getUser()->setFlash('notice', 'MSG_CATALOG_UNPUBLISHED');
    $this->redirect('@lyra_catalog_catalog');
  }
}
