<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
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
    return str_repeat('--', $this->level).$this->name;
  }
}