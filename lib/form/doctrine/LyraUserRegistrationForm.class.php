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
 * LyraUserRegistrationForm
 *
 * @package lyra
 * @subpackage form
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class LyraUserRegistrationForm extends PluginsfGuardUserForm
{
  public function configure()
  {
    $this->useFields(array('username', 'password'));
    $this->widgetSchema['password'] = new sfWidgetFormInputPassword();
    $this->widgetSchema['password_again'] = new sfWidgetFormInputPassword();
    $this->widgetSchema['username']->setLabel('USERNAME');
    $this->widgetSchema['password']->setLabel('PASSWORD');  
    $this->widgetSchema['password_again']->setLabel('PASSWORD_AGAIN');

    $this->validatorSchema['password_again'] = clone $this->validatorSchema['password'];
    $this->validatorSchema['password']->setOption('required',true);
    $this->mergePostValidator(new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'password_again', array(), array('invalid' => 'ERROR_PASSWORDS_DONT_MATCH')));

    $profileForm = new LyraUserProfileForm($this->object->Profile, array('embedded_from' => 'frontend'));

    $this->embedForm('user_profile', $profileForm);
    $this->widgetSchema['user_profile']->setLabel(false);
    $this->widgetSchema->moveField('user_profile', sfWidgetFormSchema::FIRST);

    $this->widgetSchema->setFormFormatterName('LyraContent');
    $this->widgetSchema->setNameFormat('user[%s]');
  }
  public function updateObject($values = null)
  {
    $user = parent::updateObject($values);
    $params = new LyraConfig('settings');

    $active = (false === $params->get('require_approval', 'users') && false === $params->get('email_verification', 'users'));
    $user->setIsActive($active);
    if(true === $params->get('email_verification', 'users'))
    {
      $user->Profile->setVtoken(sha1($user->getUsername() . mt_rand()));
    }
  }
}