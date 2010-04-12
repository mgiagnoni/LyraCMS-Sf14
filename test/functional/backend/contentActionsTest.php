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
 * contentActionsTest
 *
 * @package lyra
 * @subpackage functional test
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new LyraTestFunctional(new sfBrowser());
$browser->signinOk(array('username'=>'admin','password'=>'admin'));

$browser->info('1 - Content types list')->
  get('/content/index')->

  with('request')->begin()->
    isParameter('module', 'content')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '!/This is a temporary page/')->
  end()->

  info('2 - Edit content type')->
  click('td.sf_admin_list_td_name a')->

  with('request')->begin()->
    isParameter('module', 'content')->
    isParameter('action', 'edit')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
  end()->

  info('  2.1 - Submit form')->
  select('content_type_lyra_params_item_show_read_more_0')->
  click('li.sf_admin_action_save input', array('content_type' => array(
      'description' => 'backend test'
   )))->

  with('request')->begin()->
    isParameter('module', 'content')->
    isParameter('action', 'update')->
  end()->

  with('form')->begin()->
    hasErrors(false)->
  end()->

  isRedirected()
;

$browser->setTester('doctrine', 'sfTesterDoctrine');
$q = Doctrine_Query::create()
  ->from('LyraContentType ct')
  ->where("ct.description = 'backend test'")
  ->andWhere("ct.params LIKE '%s:14:\"show_read_more\";b:0%'");

$browser->info('  2.2 - Check edited fields')->
  with('doctrine')->begin()->
    check('LyraContentType', $q)->
  end();
