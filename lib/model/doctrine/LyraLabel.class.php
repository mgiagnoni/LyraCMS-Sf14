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
 * LyraLabel
 *
 * @package lyra
 * @subpackage model
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class LyraLabel extends BaseLyraLabel
{
  public function getItemsQuery() {
    $q = Doctrine::getTable('LyraArticle')
      ->getActiveItemsQuery();

    $q->innerJoin($q->getRootAlias().'.ArticleLabels l')
      ->andWhere('l.id = ?', $this->getId());
    return $q;
  }
  function getIndentName()
  {
    $indent = $this->level-1;
    if($indent < 0) {
      $indent = 0;
    }
    return str_repeat('-- ', $indent).$this->name;
  }
  public function setMetaTags(sfWebResponse $response)
  {
    $params = new LyraConfig('settings');
    $mt = $this->getMetaTitle();
    if(!$mt) {
      $mt = $this->getTitle();
    }
    if($t = $params->get('page_title_pfx', 'general')) {
      $mt = $t . ' ' . $mt;
    }
    if($t = $params->get('page_title_sfx', 'general')) {
      $mt .= ' ' . $t;
    }
    if(!$mt) {
      $mt = $this->getTitle();
    }
    $response->setTitle($mt);

    if($mt = $this->getMetaDescr()) {
        $response->addMeta('description', $mt);
    }
    if($mt = $this->getMetaKeys()) {
        $response->addMeta('keywords', $mt);
    }
    if($mt = $this->getMetaRobots()) {
        $response->addMeta('robots', $mt);
    }
  }
}