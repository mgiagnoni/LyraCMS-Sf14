<?php
/*
 * This file is part of the sfContentArchivePlugin package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfContentArchivePlugin manager class.
 *
 * @package     sfContentArchivePlugin
 * @subpackage  lib
 * @copyright   Copyright (C) 2010 Massimo Giagnoni.
 * @license     http://www.symfony-project.org/license MIT
 * @author      Massimo Giagnoni
 */
class sfContentArchiveManager
{
  protected $options = array(
    'page_title' => '',
    'page_meta_title' => 'Archive %month% %year%',
    'page_max_items' => 25,
    'item_template' => 'sfContentArchive/archive_item'
  );

  public function __construct($archive = null)
  {
    if(!isset($archive))
    {
      $archive = 'default';
    }
    $this->options = Doctrine_Lib::arrayDeepMerge($this->options, sfConfig::get('app_sfContentArchive_' . $archive, array()));

  }

  public function getArchiveDates()
  {
    return $this->getArchiveDatesQuery()->execute();
  }

  public function getArchiveDatesQuery()
  {
    if(!isset($this->options['model']))
    {
      throw new sfException('Model option not found in plugin configuration');
    }

    $table = Doctrine_Core::getTable($this->options['model']);
    $query = $table->createQuery();

    $datef = $this->options['date_field'];

    $query
      ->addSelect("YEAR($datef) ay, MONTH($datef) am, count(*) ct")
      ->addGroupBy("YEAR($datef)")
      ->addGroupBy("MONTH($datef)")
      ->addOrderBy("$datef DESC");

    if(method_exists($table, 'createArchiveDatesQuery'))
    {
      //Allows model table class customize query
      $query = $table->createArchiveDatesQuery($query);
    }

    return $query;
  }

  public function getArchiveItems($year, $month)
  {
    return $this->createArchiveItemsQuery($year, $month)->execute();
  }

  public function createArchiveItemsQuery($year, $month)
  {
    if(!isset($this->options['model']))
    {
      throw new sfException('Model option not found in plugin configuration');
    }

    $table = Doctrine_Core::getTable($this->options['model']);
    $query = $table->createQuery('a');
    $datef = 'a.' . $this->options['date_field'];

    $query
      ->andWhere("YEAR($datef) = ? AND MONTH($datef) = ?",array($year, $month))
      ->orderBy("$datef DESC");

    if(method_exists($table, 'createArchiveItemsQuery'))
    {
      //Allows model table class customize query
      $query = $table->createArchiveItemsQuery($query);
    }
    return $query;
  }

  public function getOptions()
  {
    return $this->options;
  }
}
