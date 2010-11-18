<?php
/*
 * This file is part of the sfContentArchivePlugin package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfContentArchivePlugin sfContentArchive module base actions class.
 *
 * @package     sfContentArchivePlugin
 * @subpackage  sfContentArchive
 * @copyright   Copyright (C) 2010 Massimo Giagnoni.
 * @license     http://www.symfony-project.org/license MIT
 * @author      Massimo Giagnoni
 */
class BasesfContentArchiveActions extends sfActions
{
  public function executeArchive(sfWebRequest $request)
  {
    
    $archive = new sfContentArchiveManager($request->getParameter('archive', 'default'));
    $this->options = $archive->getOptions();

    $this->year = $request->getParameter('year');
    $this->month = $request->getParameter('month');
    $this->forward404Unless(checkdate($this->month, 1, $this->year));
    $this->pager = new sfDoctrinePager($this->options['model'], $this->options['page_max_items']);
    $this->pager->setQuery(
      $archive
        ->createArchiveItemsQuery($this->year, $this->month)
    );
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  }
}
