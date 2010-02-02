<?php

/*
 * This file is part of Lyra CMS. Lyra CMS is free software; you can redistribute
 * it and/or modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see <http://www.gnu.org/licenses>.
 */
require_once dirname(__FILE__).'/../lib/settingsGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/settingsGeneratorHelper.class.php';

/**
 * settingsActions
 *
 * @package lyra
 * @subpackage settings
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class settingsActions extends autoSettingsActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward404();
  }
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
 public function executeFilter(sfWebRequest $request)
 {
   $this->forward404();
 }
}
