<?php

/*
 * This file is part of Lyra CMS. Lyra CMS is free software; you can redistribute
 * it and/or modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see <http://www.gnu.org/licenses>.
*/

/**
 * LyraMenuForm
 *
 * @package lyra
 * @subpackage form
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class LyraMenuForm extends BaseLyraMenuForm
{
  public function configure()
  {
    unset(
      $this['root_id'],
      $this['lft'],
      $this['rgt'],
      $this['level'],
      $this['element_id'],
      $this['params']
    );

    $this->widgetSchema['ctype_id'] = new sfWidgetFormInputHidden();
    $this->validatorSchema['ctype_id'] = new sfValidatorInteger(array(
      'required' => false
    ));

    $this->widgetSchema['type'] = new sfWidgetFormInputHidden();
    $this->validatorSchema['type'] = new sfValidatorString();
    $params = null;

    if($this->isNew())
    {
      $ctype_id = $this->getOption('ctype_id');
      $view_id = $this->getOption('view_id');
      $type = $this->getOption('type');
      $this->setDefault('ctype_id', $ctype_id);
      $this->setDefault('type', $type);
    }
    else
    {
      $ctype_id = $this->getObject()->getCtypeId();
      $type = $this->getObject()->getType();
      if($params = $this->getObject()->getParams())
      {
        $params = unserialize($params);
      }
      if($type == 'list')
      {
        $view_id = $this->getObject()->getElementId();
      }
    }

    $query = Doctrine_Query::create()
      ->from('LyraMenu m');

    if(!$this->isNew())
    {
      $query->where('m.lft < ? OR m.rgt > ?', array(
        $this->getObject()->getLft(),
        $this->getObject()->getRgt()
      ));
    }
    
    $this->widgetSchema['parent_id'] = new sfWidgetFormDoctrineChoice(array(
      'model' => 'LyraMenu',
      'order_by' => array('root_id, lft', ''),
      'method' => 'getIndentName',
      'add_empty' => 'Root',
      'query' => $query
    ));

    $this->validatorSchema['parent_id'] = new sfValidatorDoctrineChoice(array(
      'required' => false,
      'model' => 'LyraMenu'
    ));

    $this->widgetSchema['parent_id']->setLabel('PARENT');

    $this->widgetSchema['name'] = new sfWidgetFormInputText();
    $this->widgetSchema['name']->setLabel('NAME');

    $this->validatorSchema['name'] = new sfValidatorString(array(
      'required' => true,
      'max_length' => 255
    ));

    $ctype = Doctrine::getTable('LyraContentType')
      ->find($ctype_id);

    if($type == 'view')
    {
      $view = Doctrine::getTable('LyraContentView')
        ->find($view_id);
    }

    switch($type)
    {
      case 'object':
        $this->selectItem($ctype_id);
        break;
      case 'external':
        $this->widgetSchema['url'] = new sfWidgetFormInputText();
        $this->validatorSchema['url'] = new sfValidatorUrl();
        if(isset($params['url']))
        {
          $this->setDefault('url', $params['url']);
        }
        break;
    }

    $this->widgetSchema->setNameFormat('menu_item[%s]');
  }

  protected function selectItem($ctype_id)
  {
    $ctype = Doctrine::getTable('LyraContentType')
          ->find($ctype_id);

    $query = Doctrine_Query::create()
      ->from($ctype->getModel() . ' c')
      ->where('c.ctype_id = ?', $ctype_id);

    $this->widgetSchema['element_id'] = new sfWidgetFormDoctrineChoice(array(
      'model' => $ctype->getModel(),
      'order_by' => array('created_at', 'desc'),
      'add_empty' => false,
      'query' => $query
    ));
    $this->widgetSchema['element_id']->setLabel('ELEMENT');
    
    $this->validatorSchema['element_id'] = new sfValidatorDoctrineChoice(array(
      'required' => false,
      'model' => $ctype->getModel()
    ));
  }
  
  public function updateObject($values = null)
  {
    $item = parent::updateObject($values);
    $type = $item->getType();
    switch($type)
    {
      case 'external':
        $item->setParams(serialize(array('url' => $this->getValue('url'))));
        break;
    }
  }
  protected function doSave($con = null)
  {
    parent::doSave($con);
    $obj = $this->getObject();
    $node = $obj->getNode();

    if($node->isValidNode())
    {
      if($obj->getParentId())
      {
        $parent = $obj->getTable()->find($obj->getParentId());

        if(false === $node->getParent() || $parent->getId() != $node->getParent()->getId())
        {
          $node->moveAsLastChildOf($parent);
        }
      }
      elseif(!$node->isRoot())
      {
        $node->makeRoot($obj->getId());
      }
    }
    else
    {
      if($obj->getParentId())
      {
        $parent = $obj->getTable()->find($obj->getParentId());
        $node->insertAsLastChildOf($parent);
      }
      else
      {
        $treeObject = $obj->getTable()->getTree();
        $treeObject->createRoot($obj);
      }
    }
  }
}