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
 * LyraEmailVerifyForm
 *
 * @package lyra
 * @subpackage form
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class LyraEmailVerifyForm extends BaseForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'email' => new sfWidgetFormInputText(),
      'token' => new  sfWidgetFormInputText()
    ));

    $this->setValidators(array(
      'email' => new sfValidatorString(array('required' => true)),
      'token' => new sfValidatorString(array('required' => true)),
    ));

    $this->validatorSchema->setPostValidator(new LyraValidatorEmailVerify());

    $this->widgetSchema['email']->setLabel('EMAIL');
    $this->widgetSchema['token']->setLabel('VTOKEN');
    
    $this->widgetSchema->setFormFormatterName('LyraContent');
    $this->widgetSchema->setNameFormat('verify[%s]');
  }
}