<?php

/*
 * This file is part of Lyra CMS. Lyra CMS is free software; you can redistribute
 * it and/or modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see <http://www.gnu.org/licenses>.
 */

require_once dirname(__FILE__).'/../lib/commentGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/commentGeneratorHelper.class.php';

/**
 * commentActions
 *
 * @package lyra
 * @subpackage comment
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class commentActions extends autoCommentActions
{
  public function executePublish(sfwebRequest $request)
  {
    $this->lyra_comment = $this->getRoute()->getObject();
    $this->lyra_comment->publish();
    $this->getUser()->setFlash('notice', 'MSG_COMMENT_PUBLISHED');
    $this->redirect('@lyra_comment');
  }
  public function executeUnpublish(sfwebRequest $request)
  {
    $this->lyra_comment = $this->getRoute()->getObject();
    $this->lyra_comment->publish(false);
    $this->getUser()->setFlash('notice', 'MSG_COMMENT_UNPUBLISHED');
    $this->redirect('@lyra_comment');
  }
  public function executeBatchPublish(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
    Doctrine::getTable('LyraComment')->publish($ids);
    $this->getUser()->setFlash('notice', 'MSG_COMMENT_PUBLISHED');
    $this->redirect('@lyra_comment');
  }
  public function executeBatchUnpublish(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
    Doctrine::getTable('LyraComment')->publish($ids, false);
    $this->getUser()->setFlash('notice', 'MSG_COMMENT_UNPUBLISHED');
    $this->redirect('@lyra_comment');
  }
  public function executeIndex(sfWebRequest $request)
  {
    if($request->getParameter('id')) {
      $this->setFilters(array('article_id'=>$request->getParameter('id')));
    }
    parent::executeIndex($request);
    
  }
  public function executeNew(sfWebRequest $request)
  {
    $this->forward404();
  }
}
