<?php

require_once dirname(__FILE__).'/../lib/regionGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/regionGeneratorHelper.class.php';

/**
 * region actions.
 *
 * @package    lyra
 * @subpackage region
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class regionActions extends autoRegionActions
{
  public function executeNew(sfWebRequest $request)
  {
    $this->forward404();
  }
  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404();
  }
  public function executeDelete(sfWebRequest $request)
  {
    $this->forward404();
  }
 public function executeBatch(sfWebRequest $request)
 {
   $this->forward404();
 }
 public function executeBatchDelete(sfWebRequest $request)
 {
   $this->forward404();
 }
}
