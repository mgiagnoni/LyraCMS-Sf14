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
 * catalogActionsTest
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

$browser->info('1 - Catalog list')->
  get('/catalog/index')->

  with('request')->begin()->
    isParameter('module', 'catalog')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '!/This is a temporary page/')->
  end()->

  info(' 2 - New catalog')->
  click('.sf_admin_action_new a')->
  
  with('request')->begin()->
    isParameter('module', 'catalog')->
    isParameter('action', 'new')->
  end()->
  
  info('  2.1 - Submit invalid values')->
  click('.sf_admin_action_save input')->
  
  with('request')->begin()->
    isParameter('module', 'catalog')->
    isParameter('action', 'create')->
  end()->

  with('form')->begin()->
    hasErrors(1)->
    isError('name', 'required')->
  end()->
  
  info('  2.2 - Submit valid values')->
  click('.sf_admin_action_save input', array('catalog' => array(
      'name' => 'aaa-test',
      'description' => 'test'
    )))->

  with('request')->begin()->
    isParameter('module', 'catalog')->
    isParameter('action', 'create')->
  end()->

  with('form')->begin()->
    hasErrors(false)->
  end()->

  with('response')->
    isRedirected()->

  followRedirect()->
  with('request')->begin()->
    isParameter('module', 'catalog')->
    isParameter('action', 'edit')->
  end();

$browser->setTester('doctrine', 'sfTesterDoctrine');

$browser->info('  2.3 - Check created catalog')->
  with('doctrine')->begin()->
    check('LyraCatalog', array(
      'name' => 'aaa-test',
    ))->
  end()->
  info('3 - Publish / Unpublish')->
  click('.link-back a')->

  with('request')->begin()->
    isParameter('module', 'catalog')->
    isParameter('action', 'index')->
  end()->
  
  //sort list by name
  click('.sf_admin_list_th_name a')->

  info('  3.1 - Publish catalog from list')->
  click('.sf_admin_list_td_published a')->

  with('request')->begin()->
    isParameter('module', 'catalog')->
    isParameter('action', 'publish')->
  end()->

  with('response')->
    isRedirected()->

  followRedirect()->

  info('  3.2 - Is catalog published?')->
  with('doctrine')->begin()->
    check('LyraCatalog', array(
      'name' => 'aaa-test',
      'is_active' => true
    ))->
  end()->

  info('  3.1 - Unpublish catalog from list')->
  click('.sf_admin_list_td_published a')->

  with('request')->begin()->
    isParameter('module', 'catalog')->
    isParameter('action', 'unpublish')->
  end()->

  with('response')->
    isRedirected()->

  followRedirect()->

  info('  3.3 - Is catalog unpublished?')->
  with('doctrine')->begin()->
    check('LyraCatalog', array(
      'name' => 'aaa-test',
      'is_active' => false
    ))->
  end()->

  info('4 - Edit catalog')->
  click('aaa-test')->

   with('request')->begin()->
    isParameter('module', 'catalog')->
    isParameter('action', 'edit')->
  end()->

  click('.sf_admin_action_save input', array('catalog' => array(
      'description' => 'modified'
    )))->

  with('request')->begin()->
    isParameter('module', 'catalog')->
    isParameter('action', 'update')->
  end()->

  with('form')->begin()->
    hasErrors(false)->
  end()->

  with('response')->
    isRedirected()->
  
  followRedirect()->
  with('request')->begin()->
    isParameter('module', 'catalog')->
    isParameter('action', 'edit')->
  end()->

  info('  4.1 - Check modified catalog')->
  with('doctrine')->begin()->
    check('LyraCatalog', array(
      'name' => 'aaa-test',
      'description' => 'modified'
    ))->
  end()
;
