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
 * articleActionsTest
 *
 * @package lyra
 * @subpackage functional test
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new LyraTestFunctional(new sfBrowser());
//$browser->loadData();
$browser->signinOk(array('username'=>'admin','password'=>'admin'));

$ctype = Doctrine::getTable('LyraContentType')
  ->findOneByModule('article');

$browser->info('1 - Article list')->
  get('/article?id=' . $ctype->id)->

  with('request')->begin()->
    isParameter('module', 'article')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '!/This is a temporary page/')->
  end()
;

$browser->info('2 - New article')->
  get('/article/new')->

  with('request')->begin()->
    isParameter('module', 'article')->
    isParameter('action', 'new')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
  end()->
  
  info('  2.1 - Submit form')->
  select('article_lyra_params_show_read_more_1')->
  click('li.sf_admin_action_save input', array('article' => array(
      'title' => 'backend test',
      'content' => 'test'
   )))->

  with('request')->begin()->
    isParameter('module', 'article')->
    isParameter('action', 'create')->
  end()->

  with('form')->begin()->
    hasErrors(false)->
  end()->

  isRedirected()
;

$browser->setTester('doctrine', 'sfTesterDoctrine');

$browser->info('  2.2  - Check created article')->
  with('doctrine')->begin()->
    check('LyraArticle', array(
      'title' => 'backend test',
      'ctype_id' => $ctype->id,
      'params' => serialize(array('show_read_more' => true))
    ))->
  end()
;