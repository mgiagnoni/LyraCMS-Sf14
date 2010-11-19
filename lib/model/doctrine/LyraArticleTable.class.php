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
 * LyraArticleTable
 *
 * @package lyra
 * @subpackage model
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class LyraArticleTable extends Doctrine_Table
{
  public static function getInstance()
  {
    return Doctrine_Core::getTable('LyraArticle');
  }

  /**
   * Retrieves articles to be featured on front page.
   *
   * @return Doctrine_Collection
   */
  public function getFrontPageItems()
  {
    $q = $this->getActiveItemsQuery()
      ->andWhere('is_featured = ?', true);

    return $q->execute();
  }

  /**
   * Called by sfContentArchivePlugin to allow customization of the query that
   * retrieves articles to be shown on archive pages.
   *
   * @param Doctrine_Query $query
   * @return Doctrine_Query
   */
  public function createArchiveItemsQuery($query)
  {
    $a = $query->getRootAlias();
    $query = $this->getActiveItemsQueryWhere($query);
    $query
      ->andWhere("is_archived = ?", true)
      ->leftJoin("$a.ArticleCreatedBy");
    
    return $query;
  }

  /**
   * Called by sfContentArchivePlugin to allow customization of the query used
   * by archive component.
   *
   * @param Doctrine_Query $query
   * @return Doctrine_Query
   */
  public function createArchiveDatesQuery($query)
  {
    $query = $this->getActiveItemsQueryWhere($query);
    $query
      ->andWhere("is_archived = ?", true);

    return $query;
  }

  /**
   * Retrieves active articles.
   *
   * @param array $params
   * @return Doctrine_Collection
   */
  public function getActiveItems($params = array())
  {
    $q = $this->getActiveItemsQuery($params);
    
    return $q->execute();
  }

  /**
   * Retrieves articles to be included in feed.
   *
   * @param array $params
   * @return Doctrine_Collection
   */
  public function getFeedItems($params = array())
  {
    $q = $this->getActiveItemsQuery($params);
    
    $q->andWhere('is_feeded = ?', true)
      ->orderBy('created_at DESC');
    
    return $q->execute();
  }

  /**
   * Retrieves latest $max articles.
   *
   * @param integer $ctype
   * @param integer $max
   * @return Doctrine_Collection
   */
  public function getLatestItems($ctype = null, $max = 5)
  {
    $q = $this->getActiveItemsQuery(array('ctype' => $ctype));

    $q->limit($max)
      ->orderBy('created_at DESC');
    
    return $q->execute();
  }

  /**
   * Generates query to retrieve active (published) articles.
   *
   * @param array $params
   * @return Doctrine_Query
   */
  public function getActiveItemsQuery($params = array())
  {
    $q = $this->createQuery('a');
    $q = $this->getActiveItemsQueryWhere($q);
    $q->leftJoin('a.ArticleCreatedBy')
      ->orderBy(
        'is_sticky DESC, ' .
        (isset($params['sort']) ? $params['sort'] : 'created_at') .
        (isset($params['order']) ? ' ' . $params['order'] : ' DESC')
      );

    if(isset($params['ctype']))
    {
      $q->innerJoin('a.ContentType ct WITH ct.type = ?', $params['ctype']);
    }
    if(isset($params['limit']) && (int)$params['limit'] > 0)
    {
      $q->limit($params['limit']);
    }
    return $q;
  }

  /**
   * Adds default criteria to select active articles.
   *
   * @param Doctrine_Query $query
   * @return Doctrine_Query
   */
  public function getActiveItemsQueryWhere($query)
  {
    $query
      ->andWhere("is_active = ?", true)
      ->andWhere("(publish_start IS NULL OR publish_start <= NOW())")
      ->andWhere("(publish_end IS NULL OR publish_end >= NOW())");

    return $query;
  }

  /**
   * Customizes query to select article for backend list.
   *
   * @param Doctrine_Query $q
   * @return Doctrine_Query
   */
  public function getBackendItemsQuery(Doctrine_Query $q)
  {
    $rootAlias = $q->getRootAlias();
    $q->leftJoin($rootAlias . '.ArticleCreatedBy u');

    return $q;
  }

  /**
   * Finds an article (used by routing).
   *
   * @param array $params
   * @return mixed
   */
  public function findItem($params = array())
  {
    if(!isset($params['slug'])) {
      return false;
    }
    $q = $this->getActiveItemsQuery();
    
    $q->andWhere('slug = ?', $params['slug']);
    if(isset($params['path']))
    {
      $q->andWhere('path = ?', $params['path']);
    }
    if(isset($params['year']))
    {
      $q->andWhere('YEAR(created_at) = ?', $params['year']);
    }
    if(isset($params['month']))
    {
      $q->andWhere('MONTH(created_at) = ?', $params['month']);
    }
    if(isset($params['day']))
    {
      $q->andWhere('DAY(created_at) = ?', $params['day']);
    }
    return $q->fetchOne();
  }

  /**
   * Publishes / unpublishes multiple articles.
   *
   * @param array $ids articles IDs
   * @param boolean $on true = publish, false = unpublish
   */
  public function publish($ids, $on = true)
  {
    $q = $this->createQuery()
      ->whereIn('id', $ids);

    foreach ($q->execute() as $item) {
      $item->publish($on);
    }
  }
}