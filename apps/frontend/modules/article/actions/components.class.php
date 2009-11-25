<?php
class articleComponents extends sfComponents
{
  public function executeLabels(sfWebRequest $request)
  {
    $catalog = Doctrine::getTable('LyraCatalog')
      ->findOneByName($this->catalog);
    $this->tree = $catalog->getLabelTree();
  }
}