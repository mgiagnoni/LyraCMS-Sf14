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
 * LyraArticle
 *
 * @package lyra
 * @subpackage model
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class LyraArticle extends BaseLyraArticle
{
  
  public function getActiveComments()
  {
    return $this->getActiveCommentsQuery()
      ->execute();
  }
  public function countActiveComments()
  {
    return $this->getActiveCommentsQuery()
      ->count();
  }
  public function countComments()
  {
    return $this->getCommentsQuery()
      ->count();
  }
  public function publish($on = true)
  {
    $this->setIsActive($on);
    $this->save();
  }
  public function feature($on = true)
  {
    $this->setIsFeatured($on);
    $this->save();
  }
  protected function getCommentsQuery()
  {
    $q = Doctrine_Query::create()
      -> from('LyraComment c')
      ->andWhere('c.article_id = ?', $this->getId());
    return $q;
  }
  protected function getActiveCommentsQuery()
  {
    $q = LyraCommentTable::getInstance()
      ->getActiveItemsQuery();

    $q->andWhere($q->getRootAlias() .'.article_id = ?', $this->getId());
      
    return $q;
  }
  public function getDay()
  {
    return strftime('%d',strtotime($this->getCreatedAt()));
  }
  public function getMonth()
  {
    return strftime('%m',strtotime($this->getCreatedAt()));
  }
  public function getYear()
  {
    return strftime('%Y',strtotime($this->getCreatedAt()));
  }
}