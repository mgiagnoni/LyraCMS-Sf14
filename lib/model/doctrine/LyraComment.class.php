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
 * LyraComment
 * 
 * @package lyra
 * @subpackage model
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class LyraComment extends BaseLyraComment
{
  public function publish($on = true)
  {
    $this->setIsActive($on);
    $this->save();
  }
  public function postInsert($event)
  {
    $q = LyraArticleTable::getInstance()
      ->createQuery()
      ->update()
      ->set('num_comments', 'num_comments + 1')
      ->where('id = ?', $this->getArticleId());

    if($this->getIsActive()) {
      $q->set('num_active_comments', 'num_active_comments + 1');
    }
    
    $q->execute();
  }
  public function postUpdate($event)
  {
    $modified = $this->getLastModified();
    if(isset($modified['is_active'])) {
      $inc = $modified['is_active'] ? ' + 1' : ' - 1';
      LyraArticleTable::getInstance()
        ->createQuery()
        ->update()
        ->set('num_active_comments', 'num_active_comments' . $inc)
        ->where('id = ?', $this->getArticleId())
        ->execute();
    }
  }
  public function postDelete($event)
  {
    $q = LyraArticleTable::getInstance()
      ->createQuery()
      ->update()
      ->set('num_comments', 'num_comments - 1')
      ->where('id = ?', $this->getArticleId());

    if($this->getIsActive()) {
      $q->set('num_active_comments', 'num_active_comments - 1');
    }

    $q->execute();
  }
}