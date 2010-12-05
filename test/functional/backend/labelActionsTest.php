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
 * labelActionsTest
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

$catalog = LyraCatalogTable::getInstance()->
  findOneByName('test');

$browser->info('1 - Label list')->
  get('label/' . $catalog->id)->

  with('request')->begin()->
    isParameter('module', 'label')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '!/This is a temporary page/')->
    checkElement('tr.odd .sf_admin_list_td_indent_name a', 'child_1')->
  end()->

  info('  1.1 - Move label down')->
  click('.sf_admin_list_td_order a')->

  with('request')->begin()->
    isParameter('module', 'label')->
    isParameter('action', 'down')->
  end()->

  with('response')->
    isRedirected()->

  followRedirect()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('tr.odd .sf_admin_list_td_indent_name a', 'child_2')->
  end()->

  info('2 - New label')->
  click('.sf_admin_action_new a')->

  with('request')->begin()->
    isParameter('module', 'label')->
    isParameter('action', 'new')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('input[name="label[catalog_id]"][value="' . $catalog->id . '"]')->
  end()->

  info('  2.1 - Required fields empty')->
  click('.sf_admin_action_save input')->

  with('request')->begin()->
    isParameter('module', 'label')->
    isParameter('action', 'create')->
  end()->

  with('form')->begin()->
    hasErrors(1)->
    isError('name', 'required')->
  end()->

  info('  2.2 - Submission valid')->
  click('.sf_admin_action_save input', array('label' => array('name' => 'child_3')))->

  with('request')->begin()->
    isParameter('module', 'label')->
    isParameter('action', 'create')->
  end()->

  with('form')->begin()->
    hasErrors(false)->
  end()->

  with('response')->
    isRedirected()->

  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'label')->
    isParameter('action', 'edit')->
  end()
;

$browser->setTester('doctrine', 'sfTesterDoctrine');

$browser->info('  2.3  - Check created label')->
  with('doctrine')->begin()->
    check('LyraLabel', array(
      'name' => 'child_3',
      'catalog_id' => $catalog->id
    ))->
  end()->

  info('3 - Edit label')->
  click('.link-back a')->

  with('request')->begin()->
    isParameter('module', 'label')->
    isParameter('action', 'index')->
    isParameter('catalog_id', $catalog->id)->
  end()->

  click('child_3')->

  with('request')->begin()->
    isParameter('module', 'label')->
    isParameter('action', 'edit')->
  end()->

  click('.sf_admin_action_save input', array('label' => array('description' => 'test')))->

  with('request')->begin()->
    isParameter('module', 'label')->
    isParameter('action', 'update')->
  end()->

  with('form')->begin()->
    hasErrors(false)->
  end()->

  with('response')->
    isRedirected()->

  followRedirect()->
  
  with('request')->begin()->
    isParameter('module', 'label')->
    isParameter('action', 'edit')->
  end()->

info('  3.1  - Check edited label')->
  with('doctrine')->begin()->
    check('LyraLabel', array(
      'name' => 'child_3',
      'description' => 'test',
      'catalog_id' => $catalog->id
    ))->
  end()->

  info('4 - Delete label')->
  click('.link-back a')->
  click('li.sf_admin_action_delete a', array(), array('method' => 'delete', '_with_csrf' => true, 'position' => 1))->

  with('request')->begin()->
    isParameter('module', 'label')->
    isParameter('action', 'delete')->
  end()->

  with('response')->
    isRedirected()->

  followRedirect()->

  // Check if label and its descendant are deleted
  with('doctrine')->begin()->
    check('LyraLabel', array(
      'name' => 'child_2',
      'catalog_id' => $catalog->id
    ),false)->
  end()->

  with('doctrine')->begin()->
    check('LyraLabel', array(
      'name' => 'child_2_1',
      'catalog_id' => $catalog->id
    ),false)->
  end()
  ;