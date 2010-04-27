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
 * userActionsTest
 *
 * @package lyra
 * @subpackage functional test
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new LyraTestFunctional(new sfBrowser());
$browser->loadData();
$browser->signinOk(array('username'=>'admin','password'=>'admin'));

$browser->info('1 - User list')->
  get('/sf_guard_user')->

  with('request')->begin()->
    isParameter('module', 'sfGuardUser')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '!/This is a temporary page/')->
  end()->

//  info(' 2 - Edit user')->
//  click('.sf_admin_list_td_username a')->
//
//  with('request')->begin()->
//   isParameter('module', 'sfGuardUser')->
//   isParameter('action', 'edit')->
//  end()

  
  info(' 2 - New user')->
  click('.sf_admin_action_new a')->

  with('request')->begin()->
    isParameter('module', 'sfGuardUser')->
    isParameter('action', 'new')->
  end()->

  //with('response')->debug()->
  
  info('  2.1 - Submit invalid values')->
  click('.sf_admin_action_save input', array('sf_guard_user' => array(
    'user_profile' => array('email' => 'xx')
  )))->

  with('request')->begin()->
    isParameter('module', 'sfGuardUser')->
    isParameter('action', 'create')->
  end()->

  with('form')->begin()->
    hasErrors(2)->
    isError('username', 'required')->
    isError('user_profile[email]', 'invalid')->
  end()->

  info('  2.2 - Submit form')->
  click('.sf_admin_action_save input', array('sf_guard_user' => array(
    'username' => 'testuser',
    'user_profile' => array(
      'first_name' => 'Test first name',
      'last_name' => 'Test last name',
      'email' => 'test@example.com'
     )
  )))->

  with('request')->begin()->
    isParameter('module', 'sfGuardUser')->
    isParameter('action', 'create')->
  end()->

  with('form')->begin()->
    hasErrors(false)->
  end()->

  with('response')->
    isRedirected()->

  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'sfGuardUser')->
    isParameter('action', 'edit')->
  end()
  ;

$browser->setTester('doctrine', 'sfTesterDoctrine');

$browser->info('  2.2  - Check created user')->
  with('doctrine')->begin()->
    check('sfGuardUser', array(
      'username' => 'testuser'
    ))->
  end()->

  info('  2.3  - Check created user profile')->
  with('doctrine')->begin()->
    check('LyraUserProfile', array(
      'first_name' => 'Test first name',
      'last_name' => 'Test last name',
      'email' => 'test@example.com'
    ))->
  end()
;
