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
  public function getActiveItems($ctype = null)
  {
    $q = $this->getActiveItemsQuery();
    if($ctype)
    {
      $q->innerJoin($q->getRootAlias() . '.ArticleContentType ct WITH ct.type = ?', $ctype);
    }
    return $q->execute();
  }

  public function getActiveItemsQuery()
  {
    return $this->createQuery('a')
      ->where('a.is_active = ?', true)
      ->andWhere('(a.publish_start IS NULL OR a.publish_start <= NOW())')
      ->andWhere('(a.publish_end IS NULL OR a.publish_end >= NOW())')
      ->leftJoin('a.ArticleCreatedBy')
      ->addOrderBy('a.is_sticky DESC, a.created_at DESC');
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
    $q->andWhere($q->getRootAlias() .'.slug = ?', $params['slug']);
    
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