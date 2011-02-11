<?php
require_once sfConfig::get('sf_plugins_dir') . '/sfContentArchivePlugin/modules/sfContentArchive/lib/BasesfContentArchiveComponents.class.php';

class sfContentArchiveComponents extends BasesfContentArchiveComponents
{
  public function executeArchive(sfWebRequest $request)
  {
    $archive = new sfContentArchiveManager($this->archive);
    $this->options = $archive->getOptions();
    if(isset($this->params))
    {
      $this->options = array_merge($this->options, $this->params->getValues());
    }
    $this->rows = $archive->getArchiveDates();
  }
}
