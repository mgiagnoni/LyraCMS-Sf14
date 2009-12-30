<?php

require_once dirname(__FILE__).'/../lib/articleGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/articleGeneratorHelper.class.php';

/**
 * article actions.
 *
 * @package    lyra
 * @subpackage article
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class articleActions extends autoArticleActions
{
  public function executeIndex(sfWebRequest $request)
  {
    if($request->getParameter('id')) {
      $this->getUser()->setAttribute('lyra_ctype_id', $request->getParameter('id', 0));
    }
    parent::executeIndex($request);
  }
  public function executePublish(sfwebRequest $request)
  {
    $this->lyra_article = $this->getRoute()->getObject();
    $this->lyra_article->publish();
    $this->getUser()->setFlash('notice', 'MSG_ARTICLE_PUBLISHED');
    $this->redirect('@lyra_article_article');
  }
  public function executeUnpublish(sfwebRequest $request)
  {
    $this->lyra_article = $this->getRoute()->getObject();
    $this->lyra_article->publish(false);
    $this->getUser()->setFlash('notice', 'MSG_ARTICLE_UNPUBLISHED');
    $this->redirect('@lyra_article_article');
  }
  public function executeFeature(sfWebRequest $request)
  {
    $this->lyra_article = $this->getRoute()->getObject();
    $this->lyra_article->feature();
    $this->getUser()->setFlash('notice', 'MSG_ARTICLE_FEATURED');
    $this->redirect('@lyra_article_article');
  }
  public function executeUnfeature(sfWebRequest $request)
  {
    $this->lyra_article = $this->getRoute()->getObject();
    $this->lyra_article->feature(false);
    $this->getUser()->setFlash('notice', 'MSG_ARTICLE_UNFEATURED');
    $this->redirect('@lyra_article_article');
  }
  public function executeBatchPublish(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
    Doctrine::getTable('LyraArticle')->publish($ids);
    $this->getUser()->setFlash('notice', 'MSG_ARTICLE_PUBLISHED');
    $this->redirect('@lyra_article_article');
  }
  public function executeBatchUnpublish(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
    Doctrine::getTable('LyraArticle')->publish($ids, false);
    $this->getUser()->setFlash('notice', 'MSG_ARTICLE_UNPUBLISHED');
    $this->redirect('@lyra_article_article');
  }
}
