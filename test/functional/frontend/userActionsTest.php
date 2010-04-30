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
 * userActions
 *
 * @package lyra
 * @subpackage functional test
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new LyraTestFunctional(new sfBrowser());
$browser->loadData();

$browser->info('1 - User registration form')->
  get('/user/register')->
  with('request')->begin()->
    isParameter('module', 'user')->
    isParameter('action', 'register')->
  end()->

  with('response')->begin()->
    isStatusCode()->
    checkForm('LyraUserRegistrationForm')->
  end()->

  info('  1.1 - Submit empty values')->
  click('.row-submit input')->

  with('request')->begin()->
    isParameter('module', 'user')->
    isParameter('action', 'create')->
  end()->

  with('form')->begin()->
    isError('user_profile[first_name]', 'required')->
    isError('user_profile[last_name]', 'required')->
    isError('user_profile[email]', 'required')->
    isError('username', 'required')->
    isError('password', 'required')->
  end()->

  info('  1.2 - Submit invalid values')->
  click('.row-submit input', array('user' => array(
    'user_profile' => array(
      'first_name' => 'Test',
      'last_name' => 'User',
      'email' => 'invalid'
    ),
    'username' => 'admin',
    'password' => 'pwd',
    'password_again' => 'x'
  )))->

  with('request')->begin()->
    isParameter('module', 'user')->
    isParameter('action', 'create')->
  end()->

  with('form')->begin()->
    isError('user_profile[email]', 'invalid')->
    isError('username', 'invalid')->
    isError('password', 'invalid')->
  end()->

  info('  1.3 - Submit valid values')->
  click('.row-submit input', array('user' => array(
    'user_profile' => array(
      'first_name' => 'Test',
      'last_name' => 'User',
      'email' => 'test@example.com'
    ),
    'username' => 'test',
    'password' => 'pwd',
    'password_again' => 'pwd'
  )))->

  with('request')->begin()->
    isParameter('module', 'user')->
    isParameter('action', 'create')->
  end()->

  with('form')->begin()->
    hasErrors(false)->
  end()->

  with('response')->
    isRedirected()->

  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'user')->
    isParameter('action', 'register')->
  end();

$browser->setTester('doctrine', 'sfTesterDoctrine');

$browser->info('  1.4  - Check created user')->
  with('doctrine')->begin()->
    check('sfGuardUser', array(
      'username' => 'test',
      'is_active' => false
    ))->
  end()->

  info('  1.5  - Check created user profile')->
  with('doctrine')->begin()->
    check('LyraUserProfile', array(
      'first_name' => 'Test',
      'last_name' => 'User',
      'email' => 'test@example.com'
    ))->
  end()
;
