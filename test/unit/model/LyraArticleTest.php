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
 * LyraArticleTest
 *
 * @package lyra
 * @subpackage unit test
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
include(dirname(__FILE__).'/../../bootstrap/Doctrine.php');

$t = new lime_test(9, new lime_output_color());

$t->comment('->save()');
$article = create_article();
$date = date('Y-m-d H:i:s',time());
$article->save();
$t->is($article->slug, 'test-article','->save() creates correct slug');
$t->is($article->created_at, $date, '->save() sets correct created_at date');
$t->is($article->created_at, $article->updated_at, '->save() new article created_at equal updated_at');
sleep(1);
$article->title = 'modified title';
$article->save();
$t->isnt($article->created_at, $article->updated_at ,'->save() updated article created_at not equal updated_at');

$t->comment('Add 2 labels');
$label1 = LyraLabelTable::getInstance()->findOneByName('child_1');
$label2 = LyraLabelTable::getInstance()->findOneByName('child_2');
$article->link('ArticleLabels', array($label1->id, $label2->id), true);
$id = $article->id;
$labels = LyraArticleLabelTable::getInstance()->findByArticleId($id);
$t->is(count($labels), 2, '->save() correctly links article and labels');
$t->comment('Remove 1 label');
$article->unlink('ArticleLabels', array($label1->id), true);
$labels = LyraArticleLabelTable::getInstance()->findByArticleId($id);
$t->is(count($labels), 1, '->save() correctly unlinks article and label');
$t->comment('Delete article');
$article->delete();
$labels = LyraArticleLabelTable::getInstance()->findByArticleId($id);
$t->is(count($labels), 0, '->delete() correctly removes article / label links');

$t->comment('Check configuration parameters');
$article = LyraArticleTable::getInstance()->findOneByTitle('art4');
$params = new LyraConfig($article);
$t->is($params->get('show_read_more'), false, 'show_read_more = false (item level)');
$t->is($params->get('linked_title'), true, 'linked_title = true (content type level)');

function create_article($defaults = array())
{
  $ctype = LyraContentTypeTable::getInstance()
    ->findOneByType('article');
    
  $article = new LyraArticle();

  $article->fromArray(array_merge(array(
    'title' => 'Test article',
    'summary' => 'Test summary',
    'content' => 'Test content',
    'is_active' => true,
    'ctype_id' => $ctype->id
  ), $defaults));

  return $article;
}