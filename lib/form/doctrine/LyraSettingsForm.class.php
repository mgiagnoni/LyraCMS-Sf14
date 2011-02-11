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
 * LyraSettingsForm
 *
 * @package lyra
 * @subpackage form
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class LyraSettingsForm extends BaseLyraSettingsForm
{
  protected $config = array();

  public function configure()
  {
    unset($this['params']);

    foreach(array('general','comments','users','mailer') as $section)
    {
      $config = new LyraParamHolder($this->getObject(), $section);
      $config->setCatalog('lyra_params');

      $params_form = new LyraParamsForm(array(), array(
          'config' => $config
      ));
      $this->embedForm($section, $params_form);
      $this->widgetSchema[$section]->setLabel('PANEL_' . strtoupper($section));
      $this->config[$section] = $config;
    }

    $this->widgetSchema->setNameFormat('settings[%s]');
    $this->widgetSchema->setFormFormatterName('LyraSettings');
  }
  public function updateObject($values = null)
  {
    $item = parent::updateObject($values);
    $params = array();
    foreach($this->config as $section => $config)
    {
      $params = array_merge($params, $config->checkValues($this->getValue($section)));
    }
    //Save configuration parameters
    $item->setParams($params);
    return $item;
  }
}
