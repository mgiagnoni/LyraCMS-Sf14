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
 * commentActionsTest
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

$browser->info('1 - Comment list')->
  get('/comment/index')->

  with('request')->begin()->
    isParameter('module', 'comment')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '!/This is a temporary page/')->
  end()->

  info('  1.1 - Unpublish comment from list')->
  click('.sf_admin_list_td_published a')->

  with('request')->begin()->
    isParameter('module', 'comment')->
    isParameter('action', 'unpublish')->
  end()->

  isRedirected()->
  followRedirect()
;

$browser->setTester('doctrine', 'sfTesterDoctrine');

$browser->info('  1.2 - Is comment unpublished?')->
  with('doctrine')->begin()->
    check('LyraComment', array(
      'content' => 'comment1',
      'is_active' => false
    ))->
  end()->

  info('  1.3 - Publish comment from list')->
  click('.sf_admin_list_td_published a')->

  with('request')->begin()->
    isParameter('module', 'comment')->
    isParameter('action', 'publish')->
  end()->

  isRedirected()->
  followRedirect()->

  info('  1.4 - Is comment published?')->
  with('doctrine')->begin()->
    check('LyraComment', array(
      'content' => 'comment1',
      'is_active' => true
    ))->
  end()->

  info('2 - Edit comment')->
  click('.sf_admin_action_edit a')->

  with('request')->begin()->
    isParameter('module', 'comment')->
    isParameter('action', 'edit')->
  end()->

  info('  2.1 - Submit invalid values')->
  click('.sf_admin_action_save input', array('comment' => array(
        'author_name' => '',
        'author_email' => 'test-invalid',
        'author_url' => 'test-invalid'
      )))->

  with('request')->begin()->
    isParameter('module', 'comment')->
    isParameter('action', 'update')->
  end()->

  with('form')->begin()->
    hasErrors(3)->
    isError('author_name', 'required')->
    isError('author_email', 'invalid')->
    isError('author_url', 'invalid')->
  end()->

  info('  2.2 - Submit valid values')->
  click('.sf_admin_action_save input', array('comment' => array(
        'author_name' => 'test',
        'author_email' => 'test@test.com',
        'author_url' => 'http://www.test.com'
      )))->

  with('request')->begin()->
    isParameter('module', 'comment')->
    isParameter('action', 'update')->
  end()->

  with('form')->begin()->
    hasErrors(false)->
  end()->

  isRedirected()->
  followRedirect()->
  with('request')->begin()->
    isParameter('module', 'comment')->
    isParameter('action', 'edit')->
  end()->

  with('doctrine')->begin()->
    check('LyraComment', array(
      'content' => 'comment1',
      'author_email' => 'test@test.com'
    ))->
  end()
  ;
