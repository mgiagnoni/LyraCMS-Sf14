<?php
class articleComponents extends sfComponents
{
  public function executeLabels(sfWebRequest $request)
  {
    $catalog = Doctrine::getTable('LyraCatalog')
      ->findOneByName($this->catalog);
    $this->tree = $catalog->getLabelTree();
  }
  public function executeArchive(sfWebRequest $request)
  {
    $this->rows = Doctrine::getTable('LyraArticle')
      ->getArchiveDates();
  }
  public function executeLatest(sfWebRequest $request)
  {
    $this->items = Doctrine::getTable('LyraArticle')
      ->getLatestItems($this->ctype, $this->max);
  }
}