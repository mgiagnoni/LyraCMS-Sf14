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
 * BackendLyraArticleForm
 *
 * @package lyra
 * @subpackage form
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class BackendLyraArticleForm extends LyraArticleForm
{
  protected $config = null;

  public function configure()
  {
    parent::configure();
    
    //Embed form displaying configuration options
    $ctype = Doctrine::getTable('LyraContentType')->find($this->ctype_id);
    $ctype_name = $ctype->getName();
    $this->config = new LyraParams($ctype_name);
    if(!$this->isNew()) {
      $this->config->setObject($this->getObject());
    }
    $params_form = new LyraParamsForm(array(), array('config' => $this->config));
    $this->embedForm('lyra_params', $params_form);
    $this->widgetSchema['lyra_params']->setLabel(false);
  }
}