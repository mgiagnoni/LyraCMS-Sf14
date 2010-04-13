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

  with('response')->
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

  $browser->info('3 - Article configuration')->
  get('/')->
  with('response')->begin()->
    info('  3.1 - Readmore link shown')->
    checkElement('.article-readmore a[title="art1"]')->
    info('  3.2 - Readmore link hidden')->
    checkElement('.article-readmore a[title="art4"]', false)->
  end()
  ;

  $browser->info('4 - Comments')->
  get('/')->
  click('art1')->

  with('request')->begin()->
    isParameter('module', 'article')->
    isParameter('action', 'show')->
  end();

  $browser->info('  4.1 - Submit comment');

  $comment = array(
      'author_name' => 'test',
      'author_email' => 'test@example.com',
      'author_url' => 'http://www.example.com',
      'content' => 'test comment'
    );
  submit_comment($browser, $comment);

  $browser->with('doctrine')->begin()->
    check('LyraComment', array_merge($comment, array('is_active' => false)))->
  end();
 
  $browser->info('  4.2 - Submit comment (not moderated)');

  $settings = Doctrine_Query::create()
    ->from('LyraSettings')
    ->fetchOne();
  $params = unserialize($settings->getParams(ESC_RAW));

  $params['moderate_comments'] = 'moderate_none';
  $settings->setParams(serialize($params));
  $settings->save();

  submit_comment($browser, $comment);

  $browser->with('doctrine')->begin()->
    check('LyraComment', array_merge($comment, array('is_active' => true)))->
  end();

  $browser->info('  4.3 - Submit comment (not moderated user auth)');

  $params['moderate_comments'] = 'moderate_no_auth';
  $settings->setParams(serialize($params));
  $settings->save();
  
  submit_comment($browser, $comment);

  $browser->with('doctrine')->begin()->
    check('LyraComment', array_merge($comment, array('is_active' => true)))->
  end();

  $browser->info('  4.4 - Submit comment (moderated user not auth)')->
  get('/logout')->

  with('response')->
    isRedirected()->
    
  followRedirect();

  submit_comment($browser, $comment);

  $browser->with('doctrine')->begin()->
    check('LyraComment', array_merge($comment, array('is_active' => false)))->
  end();

  $browser->info('  4.5 - Submit comment (required fields empty)');
  unset(
    $comment['author_name'],
    $comment['author_email'],
    $comment['content']
  );

  submit_comment($browser, $comment, false);

  $browser->with('form')->begin()->
    hasErrors(3)->
    isError('author_name', 'required')->
    isError('author_email', 'required')->
    isError('content', 'required')->
  end();

$browser->info('5 - Pages')->

  info('  5.1 - Published page')->
  get('/test-page.html')->
  with('request')->begin()->
    isParameter('module', 'article')->
    isParameter('action', 'show')->
  end()->
  with('response')->begin()->
    isStatusCode(200)->
  end()->

  info('  5.2 - Unpublished page')->
  get('/unpublished.html')->
  with('request')->begin()->
    isParameter('module', 'article')->
    isParameter('action', 'show')->
  end()->
  with('response')->begin()->
    isStatusCode(404)->
  end()
  ;

  function submit_comment($browser, $comment, $check_errors = true)
  {
    $browser->click('Submit', array('comment' => $comment))->

    with('request')->begin()->
      isParameter('module', 'article')->
      isParameter('action', 'comment')->
    end();

    if($check_errors) {
      $browser->with('form')->begin()->
        hasErrors(false)->
      end()->

      with('response')->
        isRedirected()->

      followRedirect()->

      with('request')->begin()->
        isParameter('module', 'article')->
        isParameter('action', 'show')->
      end();
    }
  }