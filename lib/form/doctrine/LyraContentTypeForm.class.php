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
      $this['db_name'],
      $this['params'],
      $this['created_at'],
      $this['updated_at'],
      $this['content_type_catalogs_list']
    );

    $this->widgetSchema['name']->setLabel('NAME');
    $this->widgetSchema['description']->setLabel('DESCRIPTION');
    $this->widgetSchema['module']->setLabel('MODULE');
    $this->widgetSchema['is_active']->setLabel('IS_ACTIVE');

    //Embed form displaying configuration options
    $this->config = new LyraParams($this->getObject()->getName());
    $this->config->setObject($this->getObject());
    $params_form = new LyraParamsForm(array(), array('config' => $this->config, 'nodefault' => true));
    $this->embedForm('lyra_params', $params_form);
    $this->widgetSchema['lyra_params']->setLabel(false);
    $this->widgetSchema->setNameFormat('content_type[%s]');
  }

  public function updateObject($values = null)
  {
    $item = parent::updateObject($values);
    //Save configuration parameters
    $item->setParams($this->config->serialize($this->getValue('lyra_params')));
  }
}