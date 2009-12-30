<?php
/**
 * article actions.
 *
 * @package    lyra
 * @subpackage article
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class articleActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->items = Doctrine::getTable('LyraArticle')
      ->getFrontPageItems();
  }

  public function executeShow(sfWebRequest $request)
  {
    //$this->item = Doctrine::getTable('LyraArticle')
    //  ->find($request->getParameter('id'));
    //$this->forward404Unless($this->item);
    $this->item = $this->getRoute()->getObject();
    $this->item->setMetaTags($this->getResponse());
    //Gets article comments list
    $this->comments = $this->item->getActiveComments();
    $this->form = new LyraCommentForm();
    $this->form->setDefault('article_id', $this->item->getId());
  }

  public function executeNew(sfWebRequest $request)
  {
    if($request->getParameter('id')) {
      $this->getUser()->setAttribute('lyra_ctype_id', $request->getParameter('id', 0));
    }
    $this->form = new LyraArticleForm(null, array('user'=>$this->getUser()));
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new LyraArticleForm(null, array('user'=>$this->getUser()));

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($lyra_article = Doctrine::getTable('LyraArticle')->find($request->getParameter('id')), sprintf('Object lyra_article does not exist (%s).', $request->getParameter('id')));
    $this->form = new LyraArticleForm($lyra_article, array('user'=>$this->getUser()));
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($lyra_article = Doctrine::getTable('LyraArticle')->find($request->getParameter('id')), sprintf('Object lyra_article does not exist (%s).', $request->getParameter('id')));
    $this->form = new LyraArticleForm($lyra_article, array('user'=>$this->getUser()));

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($lyra_article = Doctrine::getTable('LyraArticle')->find($request->getParameter('id')), sprintf('Object lyra_article does not exist (%s).', $request->getParameter('id')));
    $lyra_article->delete();

    $this->redirect('article/index');
  }
  public function executeComment(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));
    $this->item = Doctrine::getTable('LyraArticle')->find($request->getParameter('id'));
    $this->forward404Unless($this->item);
    $this->form = new LyraCommentForm();
    $this->processCommentForm($request, $this->form);
    $this->comments = $this->item->getActiveComments();
    $this->setTemplate('show');
  }
  public function executeLabel(sfWebRequest $request)
  {
    /*$this->forward404Unless(
      $this->label = Doctrine::getTable('LyraLabel')
        ->find($request->getParameter('id'))
    );*/
    $this->label = $this->getRoute()->getObject();
    $this->label->setMetaTags($this->getResponse());
    $this->pager = new sfDoctrinePager('LyraLabel', 25);
    $this->pager->setQuery($this->label->getItemsQuery());
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  }
  public function executeArchive(sfWebRequest $request)
  {
    $this->year = $request->getParameter('year');
    $this->month = $request->getParameter('month');
    $this->forward404Unless(checkdate($this->month, 1, $this->year));
    $this->pager = new sfDoctrinePager('LyraArticle', 25);
    $this->pager->setQuery(
      Doctrine::getTable('LyraArticle')
        ->getArchiveItemsQuery($this->year, $this->month)
    );
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  }
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      $lyra_article = $form->save();

      $this->redirect('article/edit?id='.$lyra_article->getId());
    }
  }
  protected function processCommentForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      $comment = $form->save();
      $this->getUser()->setFlash('notice', $comment->getIsActive() ? 'MSG_COMMENT_SAVED' : 'MSG_COMMENT_APPROVAL');
      $this->redirect('@article_show?slug='.$comment->getCommentArticle()->getSlug());
    }
  }
}