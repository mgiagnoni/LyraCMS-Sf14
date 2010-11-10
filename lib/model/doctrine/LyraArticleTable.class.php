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
  public function getFrontPageItems()
  {
    $q = $this->getActiveItemsQuery()
      ->andWhere('a.is_featured = ?', true);
    return $q->execute();
  }
  public function getArchiveDates()
  {
    $q = $this->createQuery('a')
      ->select('YEAR(created_at) ay, MONTH(created_at) am, count(*) ct')
      ->where('a.is_active = ? AND a.is_archived = ?', array(true, true))
      ->addGroupBy('YEAR(created_at)')
      ->addGroupBy('MONTH(created_at)')
      ->addOrderBy('a.created_at DESC');
    return $q->execute();
  }
  public function getArchiveItemsQuery($year, $month)
  {
    $q = $this->getActiveItemsQuery()
      ->andWhere('is_archived = ? AND YEAR(created_at) = ? AND MONTH(created_at) = ?',array(true, $year, $month))
      ->orderBy('created_at DESC');
    return $q;
  }
  public function getActiveItems($params = array())
  {
    $q = $this->getActiveItemsQuery($params);
    
    return $q->execute();
  }
  public function getFeedItems($params = array())
  {
    $q = $this->getActiveItemsQuery($params);
    
    $q->andWhere('is_feeded = ?', true)
      ->orderBy($q->getRootAlias() . '.created_at DESC');
    
    return $q->execute();
  }
  public function getLatestItems($ctype = null, $max = 5)
  {
    $q = $this->getActiveItemsQuery(array('ctype' => $ctype));

    $q->limit($max)
      ->orderBy($q->getRootAlias() . '.created_at DESC');
    
    return $q->execute();
  }
  public function getActiveItemsQuery($params = array())
  {
    $q = $this->createQuery('a')
      ->where('a.is_active = ?', true)
      ->andWhere('(a.publish_start IS NULL OR a.publish_start <= NOW())')
      ->andWhere('(a.publish_end IS NULL OR a.publish_end >= NOW())')
      ->leftJoin('a.ArticleCreatedBy')
      ->orderBy(
        'a.is_sticky DESC, a.' .
        (isset($params['sort']) ? $params['sort'] : 'created_at') .
        (isset($params['order']) ? ' ' . $params['order'] : ' DESC')
      );

    if(isset($params['ctype']))
    {
      $q->innerJoin('a.ArticleContentType ct WITH ct.type = ?', $params['ctype']);
    }
    if(isset($params['limit']) && (int)$params['limit'] > 0)
    {
      $q->limit($params['limit']);
    }
    return $q;
  }
  public function getBackendItemsQuery(Doctrine_Query $q)
  {
    $rootAlias = $q->getRootAlias();
    $q->leftJoin($rootAlias . '.ArticleCreatedBy u');

    return $q;
  }
  public function findItem($params = array())
  {
    if(!isset($params['slug'])) {
      return false;
    }
    $q = $this->getActiveItemsQuery();
    $alias = $q->getRootAlias();
    
    $q->andWhere($alias .'.slug = ?', $params['slug']);
    if(isset($params['path']))
    {
      $q->andWhere($alias .'.path = ?', $params['path']);
    }
    if(isset($params['year']))
    {
      $q->andWhere('YEAR(' .$alias .'.created_at) = ?', $params['year']);
    }
    if(isset($params['month']))
    {
      $q->andWhere('MONTH(' .$alias .'.created_at) = ?', $params['month']);
    }
    if(isset($params['day']))
    {
      $q->andWhere('DAY(' .$alias .'.created_at) = ?', $params['day']);
    }
    return $q->fetchOne();
  }
  public function publish($ids, $on = true)
  {
    $q = $this->createQuery('a')
      ->whereIn('a.id', $ids);

    foreach ($q->execute() as $item) {
      $item->publish($on);
    }
  }
}