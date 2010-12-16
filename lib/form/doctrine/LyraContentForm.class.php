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
 * LyraContentForm
 *
 * @package lyra
 * @subpackage form
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class LyraContentForm extends BaseLyraContentForm
{
  protected
    $ctype_id = null,
    $config = null,
    $show_params = true;

  public function configure()
  {
    unset($this['params']);
    $this->widgetSchema['ctype_id'] = new sfWidgetFormInputHidden();

    if($this->isNew()) {
      $this->ctype_id = $this->getOption('ctype_id');
      $this->setDefault('ctype_id', $this->ctype_id);
    } else {
      $this->ctype_id = $this->getObject()->getCtypeId();
    }
    //Embed form displaying configuration parameters
    $ctype = LyraContentTypeTable::getInstance()->find($this->ctype_id);

    $this->config = new LyraParams($this->isNew() ? null : $this->getObject(), $ctype->getParamDefinitionsPath());
    $this->config->setCatalog(sfInflector::underscore($ctype->getModule()) . '_params');

    if($this->show_params) {
      $params_form = new LyraParamsForm(array(), array('config' => $this->config, 'section' => 'item'));
      $this->embedForm('lyra_params', $params_form);
      $this->widgetSchema['lyra_params']->setLabel(false);
    }

    //Merge form to enter metatags informations
    $metatags_form = new LyraMetatagsForm();
    $this->mergeForm($metatags_form);
    
    $selected = array();
    if(!$this->isNew()) {
      $selected= $this->getObject()
        ->get($this->getLabelRelationName())
        ->getPrimaryKeys();
    }

    //Embed form displaying label selection lists
    $label_lists_form = new LyraLabelListsForm(array(), array('ctype_id' => $this->ctype_id, 'selected' => $selected));
    $this->embedForm('labels', $label_lists_form);
    $this->widgetSchema['labels']->setLabel(false);

    $this->validatorSchema['path'] = new LyraValidatorPath(array(
      'required' => false
    ));
  }
  public function updateObject($values = null)
  {
    $item = parent::updateObject($values);
    if($this->show_params) {
      //Save configuration parameters
      $item->setParams(serialize($this->config->checkValues($this->getValue('lyra_params'), 'item')));
    }
    return $item;
  }

  public function getLabelRelationName()
  {
    return str_replace('Lyra', '', $this->getModelName()) . 'Labels';
  }
  protected function doSave($con = null)
  {
    parent::doSave($con);
    $this->saveLabels($con);
  }
  protected function saveLabels($con = null)
  {
    if (!$this->isValid()) {
        throw $this->getErrorSchema();
    }

    if (is_null($con)) {
        $con = $this->getConnection();
    }

    $existing = $this->getObject()
      ->get($this->getLabelRelationName())
      ->getPrimaryKeys();

    $values = array();
    $lists_values = $this->getValue('labels');

    $catalogs = Doctrine_Query::create()
      ->from('LyraContentTypeCatalog c')
      ->where('c.ctype_id = ?')
      ->execute(array($this->ctype_id), Doctrine::HYDRATE_ARRAY);

    foreach ($catalogs as $cg) {
      //get selected values of each list
      $v = $lists_values['label_' . $cg['catalog_id']];
      if (!is_array($v)) {
          $v = array();
      }
      $values = array_merge($v, $values);
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink)) {
        $this->getObject()
          ->unlink($this->getLabelRelationName(), array_values($unlink), true);
    }

    $link = array_diff($values, $existing);
    if (count($link)) {
        $this->getObject()
          ->link($this->getLabelRelationName(), array_values($link), true);
    }
  }
}
