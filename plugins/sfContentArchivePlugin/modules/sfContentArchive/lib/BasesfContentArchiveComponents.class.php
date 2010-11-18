<?php
/*
 * This file is part of the sfContentArchivePlugin package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfContentArchivePlugin sfContentArchive base component actions class.
 *
 * @package     sfContentArchivePlugin
 * @subpackage  sfContentArchive
 * @copyright   Copyright (C) 2010 Massimo Giagnoni.
 * @license     http://www.symfony-project.org/license MIT
 * @author      Massimo Giagnoni
 */
class BasesfContentArchiveComponents extends sfComponents
{
  public function executeArchive(sfWebRequest $request)
  {
    $archive = new sfContentArchiveManager($this->archive);
    $this->options = $archive->getOptions();
    $this->rows = $archive->getArchiveDates();
  }
}
