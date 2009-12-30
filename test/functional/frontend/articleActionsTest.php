<?php

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
$browser->info('2 - Article form')->
  info('  2.1 - Create an article')->
  with('user')->begin()->
    isAuthenticated(true)->
  end()->

  get('/article/new?id=' . $ctypes[0]->id)->
  with('request')->begin()->
    isParameter('module', 'article')->
    isParameter('action', 'new')->
  end()->
  
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

  info('  2.2 - Submit invalid values')->
  get('/article/new?id=' . $ctypes[0]->id)->
  with('request')->begin()->
    isParameter('module', 'article')->
    isParameter('action', 'new')->
  end()->

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