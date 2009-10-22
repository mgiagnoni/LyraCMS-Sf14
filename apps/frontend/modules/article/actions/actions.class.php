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
    $this->item = Doctrine::getTable('LyraArticle')
      ->find($request->getParameter('id'));
    $this->forward404Unless($this->item);
    $this->item->setMetaTags($this->getResponse());
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new LyraArticleForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new LyraArticleForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($lyra_article = Doctrine::getTable('LyraArticle')->find($request->getParameter('id')), sprintf('Object lyra_article does not exist (%s).', $request->getParameter('id')));
    $this->form = new LyraArticleForm($lyra_article);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($lyra_article = Doctrine::getTable('LyraArticle')->find($request->getParameter('id')), sprintf('Object lyra_article does not exist (%s).', $request->getParameter('id')));
    $this->form = new LyraArticleForm($lyra_article);

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

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      $lyra_article = $form->save();

      $this->redirect('article/edit?id='.$lyra_article->getId());
    }
  }
}