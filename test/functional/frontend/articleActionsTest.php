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

$browser->info('1 - The homepage')->
  get('/')->
  with('request')->begin()->
    isParameter('module', 'article')->
    isParameter('action', 'index')->
  end();
  $browser->with('response')->begin()->
    info(' 1.1 - Featured articles are listed')->
    checkElement('.article-title:contains("art1")', true)->
    info(' 1.2 - Unfeatured articles are not listed')->
    checkElement('.article-title:contains("art2")', false)->
    info(' 1.3 - Unpublished articles are not listed')->
     checkElement('.article-title:contains("art3")', false)->
  end()
;
$browser->setTester('doctrine', 'sfTesterDoctrine');
$browser->signinOk(array('username'=>'admin','password'=>'admin'));
$ctypes = Doctrine::getTable('LyraContentType')->findAll();
$catalogs = $ctypes[0]->ContentTypeCatalogs;

$browser->info('2 - Article form')->
  info('  2.1 - Show new article form')->
  with('user')->begin()->
    isAuthenticated(true)->
  end()->

  get('/article/new?id=' . $ctypes[0]->id)->
  with('request')->begin()->
    isParameter('module', 'article')->
    isParameter('action', 'new')->
  end()->

  info('  2.2 - Check label selection lists');
  foreach($catalogs as $c) {
    $browser->with('response')->
      checkElement('#article_labels_label_' . $c->id);
  }

  $browser->info('  2.3  - Submit form')->
  click('Save', array('article' => array(
      'title' => 'new article',
      'is_active' => true
   )))->

  with('request')->begin()->
    isParameter('module', 'article')->
    isParameter('action', 'create')->
  end()->

  with('form')->begin()->
    hasErrors(false)->
  end()->

  isRedirected()->
  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'article')->
    isParameter('action', 'edit')->
  end()->

  with('doctrine')->begin()->
    check('LyraArticle', array(
      'title' => 'new article',
      'is_active' => true
    ))->
  end()->

  info('  2.4 - Show new article form')->
  get('/article/new?id=' . $ctypes[0]->id)->
  with('request')->begin()->
    isParameter('module', 'article')->
    isParameter('action', 'new')->
  end()->

  info('  2.5 - Submit invalid values')->
  click('Save', array('article' => array()))->

  with('request')->begin()->
    isParameter('module', 'article')->
    isParameter('action', 'create')->
  end()->

  with('form')->begin()->
    hasErrors(1)->
    isError('title', 'required')->
  end()
  ;