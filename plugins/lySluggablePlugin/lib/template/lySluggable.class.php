<?php
/*
 * This file is part of the lySluggablePlugin package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * lySluggablePlugin template class.
 *
 * In part taken from template class of standard Doctrine sluggable behavior
 *
 * @package     lySluggablePlugin
 * @subpackage  template
 * @copyright   Copyright (C) 2010 Massimo Giagnoni.
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL
 * @author      Massimo Giagnoni
 * @author      Konsta Vesterinen
 * @version     SVN: $Id$
 */
class Doctrine_Template_lySluggable extends Doctrine_Template
{
  protected
    $_options = array(
        'name'          =>  'slug',
        'alias'         =>  null,
        'type'          =>  'string',
        'length'        =>  255,
        'unique'        =>  true,
        'options'       =>  array(),
        'fields'        =>  array(),
        'uniqueBy'      =>  array(),
        'uniqueIndex'   =>  true,
        'canUpdate'     =>  false,
        'builder'       =>  array('Doctrine_Inflector', 'urlize'),
        'provider'      =>  null,
        'indexName'     =>  null
    );

  public function setTableDefinition()
  {
      $name = $this->_options['name'];
      if ($this->_options['alias']) {
          $name .= ' as ' . $this->_options['alias'];
      }
      if ($this->_options['indexName'] === null) {
          $this->_options['indexName'] = $this->getTable()->getTableName().'_lysluggable';
      }
      $this->hasColumn($name, $this->_options['type'], $this->_options['length'], $this->_options['options']);

      if ($this->_options['unique'] == true && $this->_options['uniqueIndex'] == true) {
          $indexFields = array($this->_options['name']);
          $indexFields = array_merge($indexFields, $this->_options['uniqueBy']);
          $this->index($this->_options['indexName'], array(
            'fields' => $indexFields,
            'type' => 'unique'
          ));
      }

      $this->addListener(new Doctrine_Template_Listener_lySluggable($this->_options));
  }
}