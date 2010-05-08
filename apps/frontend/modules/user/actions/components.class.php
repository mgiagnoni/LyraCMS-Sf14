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
 * userComponents
 *
 * @package lyra
 * @subpackage user
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class userComponents extends sfComponents
{
  public function executeLogin(sfWebRequest $request)
  {
    $this->form = new LyraUserSigninForm();
    $params = new LyraConfig('settings');
    $this->show_registration_link = $params->get('enable_registration', 'users');
  }
}