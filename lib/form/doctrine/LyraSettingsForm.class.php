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
  protected $config = null;
  public function configure()
  {
    unset($this['params']);

    $params_defs = sfConfig::get('sf_config_dir') . '/lyra_params.yml';
    $defs = sfYaml::load($params_defs);

    foreach ($defs as $key => $params) {
      $config = new LyraParams();
      $config->setParams($params);
      $config->setCatalog('lyra_params');
      $config->setObject($this->getObject());

      $params_form = new LyraParamsForm(array(), array(
          'config' => $config,
          'level' => 'global',
      ));
      $this->embedForm($key, $params_form);
      $this->widgetSchema[$key]->setLabel('PANEL_' . strtoupper($key));
      $this->config[$key] = $config;
    }

    $this->widgetSchema->setNameFormat('settings[%s]');
    $this->widgetSchema->setFormFormatterName('LyraSettings');
  }
  public function updateObject($values = null)
  {
    $item = parent::updateObject($values);
    $params = array();
    foreach($this->config as $key => $config) {
      $params = array_merge($params, $config->checkValues($this->getValue($key)));
    }
    //Save configuration parameters
    $item->setParams(serialize($params));
    return $item;
  }
}