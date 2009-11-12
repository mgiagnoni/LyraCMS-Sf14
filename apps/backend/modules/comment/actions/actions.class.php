<?php

require_once dirname(__FILE__).'/../lib/commentGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/commentGeneratorHelper.class.php';

/**
 * comment actions.
 *
 * @package    lyra
 * @subpackage comment
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class commentActions extends autoCommentActions
{
  public function executePublish(sfwebRequest $request)
  {
    $this->lyra_comment = $this->getRoute()->getObject();
    $this->lyra_comment->publish();
    $this->getUser()->setFlash('notice', 'MSG_COMMENT_PUBLISHED');
    $this->redirect('@lyra_comment_comment');
  }
  public function executeUnpublish(sfwebRequest $request)
  {
    $this->lyra_comment = $this->getRoute()->getObject();
    $this->lyra_comment->publish(false);
    $this->getUser()->setFlash('notice', 'MSG_COMMENT_UNPUBLISHED');
    $this->redirect('@lyra_comment_comment');
  }
  public function executeBatchPublish(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
    Doctrine::getTable('LyraComment')->publish($ids);
    $this->getUser()->setFlash('notice', 'MSG_COMMENT_PUBLISHED');
    $this->redirect('@lyra_comment_comment');
  }
  public function executeBatchUnpublish(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
    Doctrine::getTable('LyraComment')->publish($ids, false);
    $this->getUser()->setFlash('notice', 'MSG_COMMENT_UNPUBLISHED');
    $this->redirect('@lyra_comment_comment');
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
