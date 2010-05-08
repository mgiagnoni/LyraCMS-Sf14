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
 * LyraUserProfileForm
 *
 * @package lyra
 * @subpackage form
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class LyraUserProfileForm extends BaseLyraUserProfileForm
{

  public function configure()
  {
    $this->useFields(array('first_name', 'last_name', 'email'));
    $from_frontend = 'frontend' == $this->getOption('embedded_from');
    $this->widgetSchema['first_name']->setLabel('FIRST_NAME');
    $this->widgetSchema['last_name']->setLabel('LAST_NAME');
    $this->widgetSchema['email']->setLabel('EMAIL');

    $this->validatorSchema['email'] = new sfValidatorEmail(array(
      'required' => $from_frontend
    ));
    $this->validatorSchema['first_name']->setOption('required', $from_frontend);
    $this->validatorSchema['last_name']->setOption('required', $from_frontend);

    if($from_frontend)
    {
      $this->widgetSchema->setFormFormatterName('LyraContent');
    }
    $this->widgetSchema->setNameFormat('profile[%s]');
  }
}
