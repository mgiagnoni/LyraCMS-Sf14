<?php
/*
 * This file is part of Lyra CMS. Lyra CMS is free software; you can redistribute
 * it and/or modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see <http://www.gnu.org/licenses>.
 */

/**
 * articleActions
 *
 * @package lyra
 * @subpackage article
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class articleActions extends sfActions
{
  public function executeFront(sfWebRequest $request)
  {
    $this->items = LyraArticleTable::getInstance()
      ->getFrontPageItems();
    $this->setTemplate('index');
  }
  public function executeIndex(sfWebRequest $request)
  {
    $this->items = LyraArticleTable::getInstance()
      ->getActiveItems($request->getParameter('ctype'));
  }
  public function executeFeed(sfWebRequest $request)
  {
    $this->items = LyraArticleTable::getInstance()
      ->getFeedItems($request->getParameter('ctype'));
    $this->base = $request->getUriPrefix();
  }
  public function executeShow(sfWebRequest $request)
  {
    $this->item = $this->getRoute()->getObject();
    $this->params = new LyraConfig($this->item);
    $this->item->setMetaTags($this->getResponse());
    $this->form = $this->comments = null;
    if($this->params->get('show_comments')) {
      //Gets article comments list
      $this->comments = $this->item->getActiveComments();
    }
    if($this->params->get('allow_comments')) {
      $this->form = new LyraCommentForm();
      $this->form->setDefault('article_id', $this->item->getId());
    }
  }

  public function executeNew(sfWebRequest $request)
  {
    if($request->getParameter('id')) {
      $this->getUser()->setAttribute('lyra_ctype_id', $request->getParameter('id', 0));
    }
    $this->form = new LyraArticleForm(null, array('user'=>$this->getUser(), 'ctype_id' => $request->getParameter('id')));
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new LyraArticleForm(null, array('user'=>$this->getUser(), 'ctype_id' => $this->getUser()->getAttribute('lyra_ctype_id')));

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($lyra_article = LyraArticleTable::getInstance()->find($request->getParameter('id')), sprintf('Object lyra_article does not exist (%s).', $request->getParameter('id')));
    $this->form = new LyraArticleForm($lyra_article, array('user'=>$this->getUser()));
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($lyra_article = LyraArticleTable::getInstance()->find($request->getParameter('id')), sprintf('Object lyra_article does not exist (%s).', $request->getParameter('id')));
    $this->form = new LyraArticleForm($lyra_article, array('user'=>$this->getUser()));

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($lyra_article = LyraArticleTable::getInstance()->find($request->getParameter('id')), sprintf('Object lyra_article does not exist (%s).', $request->getParameter('id')));
    $lyra_article->delete();

    $this->redirect('article/index');
  }
  public function executeComment(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));
    $this->item = LyraArticleTable::getInstance()
      ->find($request->getParameter('id'));
    $this->forward404Unless($this->item);
    $this->params = new LyraConfig($this->item);
    $this->forward404Unless($this->params->get('allow_comments'));
    $this->form = new LyraCommentForm(null, array('user'=>$this->getUser()));
    $this->processCommentForm($request, $this->form);
    $this->comments = $this->item->getActiveComments();
    $this->setTemplate('show');
  }
  public function executeLabel(sfWebRequest $request)
  {
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
      LyraArticleTable::getInstance()
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