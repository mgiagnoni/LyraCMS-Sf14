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
 * LyraValidatorEmailVerify
 *
 * @package lyra
 * @subpackage validator
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class LyraValidatorEmailVerify extends sfValidatorBase
{
  public function configure($options = array(), $messages = array())
  {
    $this->setMessage('invalid', 'ERROR_INVALID_EMAIL_VERIFICATION');
  }
  protected function doClean($values)
  {
    if($values['email'] && $values['token'])
    {
      if(false === Doctrine::getTable('LyraUserProfile')
        ->emailVerify($values['email'], $values['token']))
      {
        throw new sfValidatorError($this, 'invalid');
      }
    }
  }
}