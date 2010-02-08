<?php

/*
 * This file is part of Lyra CMS. Lyra CMS is free software; you can redistribute
 * it and/or modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see <http://www.gnu.org/licenses>.
 */

require_once dirname(__FILE__).'/../lib/articleGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/articleGeneratorHelper.class.php';

/**
 * articleActions
 *
 * @package lyra
 * @subpackage article
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class articleActions extends autoArticleActions
{
  protected $content_type = null;
  
  public function execute($request)
  {
    $this->forward404Unless($ctype_id = $request->getUrlParameter('ctype_id'));
    $this->forward404Unless($this->content_type = Doctrine::getTable('LyraContentType')
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
  public function executePublish(sfwebRequest $request)
  {
    $this->lyra_article = $this->getRoute()->getObject();
    $this->lyra_article->publish();
    $this->getUser()->setFlash('notice', 'MSG_ARTICLE_PUBLISHED');
    $this->redirect('@lyra_article');
  }
  public function executeUnpublish(sfwebRequest $request)
  {
    $this->lyra_article = $this->getRoute()->getObject();
    $this->lyra_article->publish(false);
    $this->getUser()->setFlash('notice', 'MSG_ARTICLE_UNPUBLISHED');
    $this->redirect('@lyra_article');
  }
  public function executeFeature(sfWebRequest $request)
  {
    $this->lyra_article = $this->getRoute()->getObject();
    $this->lyra_article->feature();
    $this->getUser()->setFlash('notice', 'MSG_ARTICLE_FEATURED');
    $this->redirect('@lyra_article');
  }
  public function executeUnfeature(sfWebRequest $request)
  {
    $this->lyra_article = $this->getRoute()->getObject();
    $this->lyra_article->feature(false);
    $this->getUser()->setFlash('notice', 'MSG_ARTICLE_UNFEATURED');
    $this->redirect('@lyra_article');
  }
  public function executeBatchPublish(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
    Doctrine::getTable('LyraArticle')->publish($ids);
    $this->getUser()->setFlash('notice', 'MSG_ARTICLE_PUBLISHED');
    $this->redirect('@lyra_article');
  }
  public function executeBatchUnpublish(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
    Doctrine::getTable('LyraArticle')->publish($ids, false);
    $this->getUser()->setFlash('notice', 'MSG_ARTICLE_UNPUBLISHED');
    $this->redirect('@lyra_article');
  }
  public function buildQuery()
  {
    $query = parent::buildQuery();
    return $query->andWhere('ctype_id = ?', $this->content_type->getId());
  }
}
