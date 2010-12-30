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
 * LyraUserAdminForm
 *
 * @package lyra
 * @subpackage form
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class LyraUserAdminForm extends sfGuardUserAdminForm
{
  public function configure()
  {
    parent::configure();

    $profileForm = new LyraUserProfileForm($this->object->Profile);
    unset($profileForm['id'], $profileForm['user_id']);
    $this->embedForm('user_profile', $profileForm);
    $this->widgetSchema['user_profile']->setLabel(false);
    $this->widgetSchema['password']->setAttribute('autocomplete', 'off');
    $this->widgetSchema['password_again']->setAttribute('autocomplete', 'off');
  }
}
