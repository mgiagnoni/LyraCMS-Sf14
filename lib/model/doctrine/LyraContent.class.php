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
 * LyraContent
 *
 * @package lyra
 * @subpackage model
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class LyraContent extends BaseLyraContent
{
  protected static 
    $prev_id = null,
    $ctype = null;

  public function getContentType()
  {
    $ctype_id = $this->getCtypeId();
    if($ctype_id !== self::$prev_id) {
      self::$ctype = LyraContentTypeTable::getInstance()
        ->find($ctype_id);
      self::$prev_id = $ctype_id;
    }
    return self::$ctype;
  }
  public function postInsert($event)
  {
    if($this->getPath()) {
      $this->updatePathRecord();
    }
  }
  public function postUpdate($event)
  {
    $modified = $this->getLastModified();
    if(array_key_exists ('path', $modified) || array_key_exists ('slug', $modified)) {
      $this->updatePathRecord();
    }
  }
  protected function updatePathRecord()
  {
    $saved_path = trim($this->getPath(), '/');

    $q = Doctrine_Query::create()
      ->from('LyraPath p')
      ->innerJoin('p.PathContentType c')
      ->where('p.content_id = ?');

    $path = $q->fetchOne(array(
      $this->getId()
    ));

    if(empty($saved_path)) {
      if($path) {
        $path->delete();
      }
      return;
    }

    if(!$path)
    {
      $path = new LyraPath();
      $path->content_id = $this->getId();
      $path->ctype_id = $this->getCtypeId();
      $ctype = LyraContentTypeTable::getInstance()->find($path->ctype_id);
    }
    else
    {
      $ctype = $path->getPathContentType();
    }

    $path->is_active = true;
    $slug = ltrim($ctype->item_slug, '/');
    $format = ($ctype->format ? '.' . $ctype->format : '');
    $path->pattern = $saved_path . '/' . $slug . $format;
    if(preg_match_all('#([^:/\.]+)#', $slug, $matches)) {
      foreach($matches[0] as $field) {
        $slug = str_replace(':'. $field, $this->$field, $slug);
      }
    }
    $path->path = $saved_path . '/' . $slug . $format;
    $path->save();
  }
}
