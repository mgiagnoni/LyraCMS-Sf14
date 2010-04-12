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
 * LyraContentTypeForm
 *
 * @package lyra
 * @subpackage form
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class LyraContentTypeForm extends BaseLyraContentTypeForm
{
  protected $config = null;

  public function configure()
  {
    unset(
      $this['type'],
      $this['module'],
      $this['model'],
      $this['plugin'],
      $this['params_file'],
      $this['params'],
      $this['created_at'],
      $this['updated_at'],
      $this['content_type_catalogs_list']
    );

    $this->widgetSchema['name']->setLabel('NAME');
    $this->widgetSchema['description']->setLabel('DESCRIPTION');
    $this->widgetSchema['is_active']->setLabel('IS_ACTIVE');

    //Embed form displaying configuration options
    $obj = $this->getObject();
    $def_file = sfConfig::get('sf_apps_dir') . '/backend/modules/' . $obj->getModule() . '/config/params.yml';
    if(!file_exists($def_file) && $obj->getPlugin()) {
      $def_file = sfConfig::get('sf_plugins_dir') . '/' . $obj->getPlugin() . '/modules/' . $obj->getModule() . '/config/params.yml';
    }
    
    $this->config = new LyraParams($obj, $def_file);
    $this->config->setCatalog(sfInflector::underscore($obj->getModule()) . '_params');

    foreach($this->config->getParamDefsSections() as $section)
    {
      
      $params_form = new LyraParamsForm(array(), array(
          'config' => $this->config,
          'section' => $section,
          'level' => 'content_type',
      ));
      $k = 'lyra_params_' . $section;
      $this->embedForm($k, $params_form);
      $this->widgetSchema[$k]->setLabel(false);
    }
    $this->widgetSchema->setNameFormat('content_type[%s]');
  }

  public function updateObject($values = null)
  {
    $item = parent::updateObject($values);
    $params = array();
    foreach($this->config->getParamDefsSections() as $section)
    {
      $params = array_merge($params, $this->config->checkValues($this->getValue('lyra_params_' . $section), $section));
    }
    //Save configuration parameters
    $item->setParams(serialize($params));
  }
}