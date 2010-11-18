<?php
class articleComponents extends sfComponents
{
  public function executeLabels(sfWebRequest $request)
  {
    $catalog = LyraCatalogTable::getInstance()
      ->findOneByName($this->catalog);
    $this->tree = $catalog->getLabelTree();
  }
  public function executeLatest(sfWebRequest $request)
  {
    $this->items = LyraArticleTable::getInstance()
      ->getLatestItems($this->ctype, $this->max);
  }
}