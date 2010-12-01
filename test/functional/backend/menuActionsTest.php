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
 * menuActionsTest
 *
 * @package lyra
 * @subpackage functional test
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new LyraTestFunctional(new sfBrowser());
$browser->setTester('doctrine', 'sfTesterDoctrine');
$browser->loadData();
$browser->signinOk(array('username'=>'admin','password'=>'admin'));

$browser->info('1 - Menu list')->
  get('/menu')->

  with('request')->begin()->
    isParameter('module', 'menu')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '!/This is a temporary page/')->
    checkElement('tr.menu_root .sf_admin_list_td_indent_name a', 'menu_test')->
    checkElement('tr.even .sf_admin_list_td_indent_name a', '-- child_1')->
    checkElement('tr.odd .sf_admin_list_td_indent_name a', '-- -- child_1_1', array('position' => 1))->
  end()->

  info('4 - Delete menu')->
  click('li.sf_admin_action_delete a', array(), array('method' => 'delete', '_with_csrf' => true, 'position' => 2))->

  with('request')->begin()->
    isParameter('module', 'menu')->
    isParameter('action', 'delete')->
  end()->

  with('response')->
    isRedirected()->

  followRedirect()->

  // Check if menu and its descendant are deleted
  with('doctrine')->begin()->
    check('LyraMenu', array(
      'name' => 'child_1',
    ),false)->
  end()->

  with('doctrine')->begin()->
    check('LyraMenu', array(
      'name' => 'child_1_1',
    ),false)->
  end()
  ;