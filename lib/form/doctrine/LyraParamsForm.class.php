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
 * LyraParamsForm
 *
 * @package lyra
 * @subpackage form
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class LyraParamsForm extends BaseForm
{
  public function configure()
  {
    $this->setParamsFields();
    $tcatalog = $this->getOption('translation_catalog' , $this->getOption('config')->getCatalog());
    $this->widgetSchema->getFormFormatter()
      ->setTranslationCatalogue($tcatalog);
  }
  
  protected function setParamsFields()
  {

    $config = $this->getOption('config');
    $section = $this->getOption('section');
    $level = $this->getOption('level', 'item');
    $nd = $level !== 'item';
    $levels = array('item', 'content_type', 'global');

    foreach($config->getParamDefs($section) as $k => $v) {
      if(isset($v['levels'])) {
        if(!is_array($v['levels'])) {
          $v['levels'] = array($v['levels']);
        }
        if(!in_array($level, $v['levels'])) {
          continue;
        }
      }
      switch($v['type']) {
        case 'boolean':
          $choices = array(1 => 'Yes', 0 => 'No');
          if(!$nd) {
            $choices = array('' => 'Default') + $choices;
          }
          $this->widgetSchema[$k] = new sfWidgetFormChoice(array(
              'choices' => $choices,
              'label' => $k,
              'expanded' => true,
              'multiple' => false
          ));
          $def = $config->get($k, $section);
          if($nd && $def === null && isset($v['default'])) {
            $def = $v['default'];
          }
          $this->setDefault($k, $def);
          $this->validatorSchema[$k] = new sfValidatorChoice(array(
              'choices' => array_keys($choices),
              'required' => false
          ));
          break;
        case 'list':
          $choices = array();
          if(!$nd) {
            $choices = array('' => 'Default');
          }
          foreach($v['choices'] as $c) {
            $choices[$c] = $c;
          }
          $this->widgetSchema[$k] = new sfWidgetFormChoice(array(
            'choices' => $choices,
            'label' => $k
          ));
          $def = $config->get($k, $section);
          if($nd && $def === null && isset($v['default'])) {
            $def = $v['default'];
          }
          $this->setDefault($k, $def);
          $this->validatorSchema[$k] = new sfValidatorChoice(array(
              'choices' => array_keys($choices),
              'required' => false
          ));
          break;

        case 'text':
          $this->widgetSchema[$k] = new sfWidgetFormInputText(array(
            'label' => $k
          ));
          $this->setDefault($k, $config->get($k, $section));
          $size = isset($v['size']) ? (int)$v['size'] : 255;
          $this->validatorSchema[$k] = new sfValidatorString(array('max_length' => $size, 'required' => false));
          break;
      }
    }
  }
}
