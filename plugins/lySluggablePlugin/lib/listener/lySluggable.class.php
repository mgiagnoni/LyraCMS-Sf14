<?php
/*
 * This file is part of the lySluggablePlugin package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * lySluggablePlugin listener class.
 *
 * In part taken from listener class of standard Doctrine sluggable behavior
 *
 * @package     lySluggablePlugin
 * @subpackage  listener
 * @copyright   Copyright (C) 2010 Massimo Giagnoni.
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL
 * @author      Massimo Giagnoni
 * @author      Konsta Vesterinen
 * @version     SVN: $Id$
 */
class Doctrine_Template_Listener_lySluggable extends Doctrine_Record_Listener
{
  protected $_options = array();

  public function __construct(array $options)
  {
      $this->_options = $options;
  }

  public function preInsert(Doctrine_Event $event)
  {
    $record = $event->getInvoker();
    $name = $record->getTable()->getFieldName($this->_options['name']);

    if(false !== $this->_options['canUpdate']) {
      if(empty($record->$name)) {
        $slug = $this->buildSlug($record);
      } else {
        $slug = call_user_func_array($this->_options['builder'], array($record->$name, $record));
      }
    } else {
      $slug = $this->buildSlug($record);
    }

    if(false !== $this->_options['unique']) {
      $slug = $this->makeSlugUnique($record, $slug);
    }
    $record->$name = $slug;
  }

  public function preUpdate(Doctrine_Event $event)
  {
    $record = $event->getInvoker();
    $name = $record->getTable()->getFieldName($this->_options['name']);
    $slug = '';

    if(empty($record->$name)) {
      $slug = $this->buildSlug($record);
    } else if(array_key_exists($name, $record->getModified())) {
      if(false !== $this->_options['canUpdate']) {
        $slug = call_user_func_array($this->_options['builder'], array($record->$name, $record));
      } else {
        $slug = $this->buildSlug($record);
      }
    }
    
    if($slug) {
      if(false !== $this->_options['unique']) {
        $slug = $this->makeSlugUnique($record, $slug);
      }
      $record->$name = $slug;
    }
  }

  protected function buildSlug($record)
  {
    if (empty($this->_options['fields'])) {
        if (is_callable($this->_options['provider'])) {
            $value = call_user_func($this->_options['provider'], $record);
        } else if (method_exists($record, 'getUniqueSlug')) {
            $value = $record->getUniqueSlug($record);
        } else {
            $value = (string) $record;
        }
    } else {
        $value = '';
        foreach ($this->_options['fields'] as $field) {
            $value .= $record->$field . ' ';
        }
        $value = substr($value, 0, -1);
    }

    $value = call_user_func_array($this->_options['builder'], array($value, $record));

    return $value;
  }

  protected function makeSlugUnique($record, $proposal)
  {
    /* fix for use with Column Aggregation Inheritance */
    if ($record->getTable()->getOption('inheritanceMap')) {
      $parentTable = $record->getTable()->getOption('parents');
      $i = 0;
      // Be sure that you do not instanciate an abstract class;
      $reflectionClass = new ReflectionClass($parentTable[$i]);
      while ($reflectionClass->isAbstract()) {
        $i++;
        $reflectionClass = new ReflectionClass($parentTable[$i]);
      }
      $table = Doctrine::getTable($parentTable[$i]);
    } else {
      $table = $record->getTable();
    }

    $name = $table->getFieldName($this->_options['name']);
    $slug = $proposal;

    $whereString = 'r.' . $name . ' LIKE ?';
    $whereParams = array($proposal.'%');

    if ($record->exists()) {
      $identifier = $record->identifier();
      $whereString .= ' AND r.' . implode(' != ? AND r.', $table->getIdentifierColumnNames()) . ' != ?';
      $whereParams = array_merge($whereParams, array_values($identifier));
    }

    foreach ($this->_options['uniqueBy'] as $uniqueBy) {
      if (is_null($record->$uniqueBy)) {
          $whereString .= ' AND r.'.$uniqueBy.' IS NULL';
      } else {
          $whereString .= ' AND r.'.$uniqueBy.' = ?';
          $value = $record->$uniqueBy;
          if ($value instanceof Doctrine_Record) {
              $value = current((array) $value->identifier());
          }
          $whereParams[] =  $value;
      }
    }

    // Disable indexby to ensure we get all records
    $originalIndexBy = $table->getBoundQueryPart('indexBy');
    $table->bindQueryPart('indexBy', null);

    $query = $table->createQuery('r')
      ->select('r.' . $name)
      ->where($whereString , $whereParams)
      ->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);

    // We need to introspect SoftDelete to check if we are not disabling unique records too
    if ($table->hasTemplate('Doctrine_Template_SoftDelete')) {
      $softDelete = $table->getTemplate('Doctrine_Template_SoftDelete');

      // we have to consider both situations here
      if ($softDelete->getOption('type') == 'boolean') {
        $conn = $query->getConnection();

        $query->addWhere(
          '(r.' . $softDelete->getOption('name') . ' = ' . $conn->convertBooleans(true) .
          ' OR r.' . $softDelete->getOption('name') . ' = ' . $conn->convertBooleans(false) . ')'
        );
      } else {
          $query->addWhere('(r.' . $softDelete->getOption('name') . ' IS NOT NULL OR r.' . $softDelete->getOption('name') . ' IS NULL)');
      }
    }

    $similarSlugResult = $query->execute();
    $query->free();

    // Change indexby back
    $table->bindQueryPart('indexBy', $originalIndexBy);

    $similarSlugs = array();
    foreach ($similarSlugResult as $key => $value) {
      $similarSlugs[$key] = strtolower($value[$name]);
    }

    $i = 1;
    while (in_array(strtolower($slug), $similarSlugs)) {
      $slug = $proposal . '-' . $i;
      $i++;
    }

    // If slug is longer then the column length then we need to trim it
    // and try to generate a unique slug again
    $length = $table->getFieldLength($this->_options['name']);
    if (strlen($slug) > $length) {
      $slug = substr($slug, 0, $length - (strlen($i) + 1));
      $slug = $this->makeSlugUnique($record, $slug);
    }

    return  $slug;
  }
}