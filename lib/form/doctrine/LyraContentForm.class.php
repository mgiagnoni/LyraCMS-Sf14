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
    $ctype = Doctrine::getTable('LyraContentType')->find($this->ctype_id);
    
    $this->config = new LyraParams($ctype->getModule(), $ctype->getPlugin());
    if(!$this->isNew()) {
      $this->config->setObject($this->getObject());
    }
    if($this->show_params) {
      $params_form = new LyraParamsForm(array(), array('config' => $this->config));
      $this->embedForm('lyra_params', $params_form);
      $this->widgetSchema['lyra_params']->setLabel(false);
    }
  }
  public function updateObject($values = null)
  {
    $item = parent::updateObject($values);
    if($this->show_params) {
      //Save configuration parameters
      $item->setParams(serialize($this->config->checkValues($this->getValue('lyra_params'))));
    }
    return $item;
  }
}
