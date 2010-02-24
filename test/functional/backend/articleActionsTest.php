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
$browser->loadData();
$browser->signinOk(array('username'=>'admin','password'=>'admin'));

$ctype = Doctrine::getTable('LyraContentType')
  ->findOneByType('article');

$browser->info('1 - Lists')->
  info('  1.1 - Articles')->
  get('/article/' . $ctype->id)->

  with('request')->begin()->
    isParameter('module', 'article')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '!/This is a temporary page/')->
    checkElement('.sf_admin_list_td_title:contains("art1")')->
    checkElement('.sf_admin_list_td_title:contains("test page")', false)->
  end()
;

$ctype2 = Doctrine::getTable('LyraContentType')
  ->findOneByType('page');

$browser->info('  1.2 - Pages')->
get('/article/' . $ctype2->id)->

  with('request')->begin()->
    isParameter('module', 'article')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '!/This is a temporary page/')->
    checkElement('.sf_admin_list_td_title:contains("art1")', false)->
    checkElement('.sf_admin_list_td_title:contains("test page")')->
  end()
;

$browser->info('2 - New article')->
  get('/article/' . $ctype->id)->
  click('.sf_admin_action_new a')->

  with('request')->begin()->
    isParameter('module', 'article')->
    isParameter('action', 'new')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
  end()->
  info('  2.1 - Submit invalid values')->
  click('li.sf_admin_action_save input', array('article' => array(
      'meta_robots' => 'invalid choice'
   )))->
  
  with('request')->begin()->
    isParameter('module', 'article')->
    isParameter('action', 'create')->
  end()->

  with('form')->begin()->
    hasErrors(2)->
    isError('title', 'required')->
    isError('meta_robots', 'invalid')->
  end()->

  info('  2.2 - Submit form')->
  select('article_lyra_params_show_read_more_1')->
  click('li.sf_admin_action_save input', array('article' => array(
      'title' => 'aaa-backend test',
      'content' => 'test',
      'meta_title' => 'test meta'
   )))->

  with('request')->begin()->
    isParameter('module', 'article')->
    isParameter('action', 'create')->
  end()->

  with('form')->begin()->
    hasErrors(false)->
  end()->

  isRedirected()->
  followRedirect()
;

$browser->setTester('doctrine', 'sfTesterDoctrine');

$browser->info('  2.2  - Check created article')->
  with('doctrine')->begin()->
    check('LyraArticle', array(
      'title' => 'aaa-backend test',
      'meta_title' => 'test meta',
      'ctype_id' => $ctype->id,
      'params' => serialize(array('show_read_more' => true))
    ))->
  end()->

  info('3 - Publish / Unpublish')->
  click('.link-back a')->

   with('request')->begin()->
    isParameter('module', 'article')->
    isParameter('action', 'index')->
  end()->

  click('.sf_admin_list_th_title a')->

  info('  3.1 - Publish article from list')->
  click('.sf_admin_list_td_published a')->

  with('request')->begin()->
    isParameter('module', 'article')->
    isParameter('action', 'publish')->
  end()->

  isRedirected()->
  followRedirect()->

  info('  3.2 - Is article published?')->
  with('doctrine')->begin()->
    check('LyraArticle', array(
      'title' => 'aaa-backend test',
      'is_active' => true
    ))->
  end()->

  info('  3.3 - Unpublish article from list')->
  click('.sf_admin_list_td_published a')->

  with('request')->begin()->
    isParameter('module', 'article')->
    isParameter('action', 'unpublish')->
  end()->

  isRedirected()->
  followRedirect()->

  info('  3.4 - Is article unpublished?')->
  with('doctrine')->begin()->
    check('LyraArticle', array(
      'title' => 'aaa-backend test',
      'is_active' => false
    ))->
  end()->

  info('4 - Feature / Unfeature')->

  info('  4.1 - Feature article from list')->
  click('.sf_admin_list_td_front_page a')->

  with('request')->begin()->
    isParameter('module', 'article')->
    isParameter('action', 'feature')->
  end()->

  isRedirected()->
  followRedirect()->

  info('  4.2 - Is article featured?')->
  with('doctrine')->begin()->
    check('LyraArticle', array(
      'title' => 'aaa-backend test',
      'is_featured' => true
    ))->
  end()->

  info('  4.3 - Unfeature article from list')->
  click('.sf_admin_list_td_front_page a')->

  with('request')->begin()->
    isParameter('module', 'article')->
    isParameter('action', 'unfeature')->
  end()->

  isRedirected()->
  followRedirect()->

  info('  4.4 - Is article unfeatured?')->
  with('doctrine')->begin()->
    check('LyraArticle', array(
      'title' => 'aaa-backend test',
      'is_featured' => false
    ))->
  end()
;