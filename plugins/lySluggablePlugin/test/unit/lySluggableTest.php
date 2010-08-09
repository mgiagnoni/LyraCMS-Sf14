<?php
/*
 * This file is part of the lySluggablePlugin package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * lySluggablePlugin unit tests.
 *
 *
 * @package     lySluggablePlugin
 * @subpackage  template
 * @copyright   Copyright (C) 2010 Massimo Giagnoni.
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL
 * @author      Massimo Giagnoni
 * @version     SVN: $Id$
 */
include(dirname(__FILE__).'/../bootstrap/unit.php');

$t = new lime_test(13, new lime_output_color());

/*
 * Article:
 *   actAs:
 *     lySluggable:
 *       fields: [title]
 *       canUpdate: true
 *       unique: false
 */

$t->info('canUpdate: true, unique: false');
$a = new Article();

$a->title = 'My article title';
$a->save();
$a->refresh();

$t->is($a->getSlug(), 'my-article-title', 'Generated slug on insert');

$a = new Article();

$a->title = 'A test title';
$a->slug = 'my slug';
$a->save();
$a->refresh();

$t->is($a->getSlug(), 'my-slug', 'User-defined slug on insert');

$a->slug = 'modified slug';
$a->save();
$a->refresh();

$t->is($a->getSlug(), 'modified-slug', 'Edited slug on update');

$a->slug = '';
$a->save();
$a->refresh();

$t->is($a->getSlug(), 'a-test-title', 'Slug re-generated from title if cleared on update');

/*
 * Article1:
 *    actAs:
 *      lySluggable:
 *        fields: [title]
 *        canUpdate: true
 *        unique: true
 */

$t->info('canUpdate: true, unique: true');

$a = new Article1();
$a->title = 'My article title';
$a->save();

$a = new Article1();
$a->title = 'My article title';
$a->save();
$a->refresh();

$t->is($a->getSlug(), 'my-article-title-1', 'Generated unique slug on insert');

$a = new Article1();
$a->title = 'Another title';
$a->slug = 'my-article-title';
$a->save();
$a->refresh();

$t->is($a->getSlug(), 'my-article-title-2', 'Made user-defined slug unique on insert');

$a = new Article1();
$a->title = 'Another title again';
$a->save();

$a->slug = 'My article title';
$a->save();
$a->refresh();

$t->is($a->getSlug(), 'my-article-title-3', 'Made edited slug unique on update');

/*
 * Article2:
 *    actAs:
 *      lySluggable:
 *        fields: [title]
 *        canUpdate: false
 */

$t->info('canUpdate: false');

$a = new Article2();
$a->title = 'My article title';
$a->slug = 'different slug';
$a->save();
$a->refresh();

$t->is($a->getSlug(), 'my-article-title', 'Generated slug overrides user defined slug on insert');

$a->slug = 'edited slug';
$a->save();
$a->refresh();

$t->is($a->getSlug(), 'my-article-title', 'Generated slug overrides edited slug on update');

/*
 * Article3:
     actAs:
       lySluggable:
         fields: [title]
         canUpdate: true
         unique: true
         uniqueBy: [path]
 */
$t->info('canUpdate: true, unique: true, uniqueBy: path');

$a = new Article3();
$a->title = 'My article title';
$a->path = 'my/path/';
$a->save();

$a = new Article3();
$a->title = 'My article title';
$a->path = 'my/path/';
$a->save();
$a->refresh();

$t->is($a->getSlug(), 'my-article-title-1', 'Same uniqueBy: slug is made unique');

$a = new Article3();
$a->title = 'My article title';
$a->path = 'my/other/path/';
$a->save();
$a->refresh();

$t->is($a->getSlug(), 'my-article-title', 'Different uniqueBy: repeated slug is allowed');

$a->path = 'my/path/';
$a->slug = 'my article title';
$a->save();
$a->refresh();

$t->is($a->getSlug(), 'my-article-title-2', 'Edited uniqueBy: repeated slug is made unique');

$a = new Article3();
$a->title = 'My article title';
$a->save();

$t->is($a->getSlug(), 'my-article-title', 'UniqueBy field NULL');
