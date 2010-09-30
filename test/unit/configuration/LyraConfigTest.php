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
 * LyraConfigTest
 *
 * @package lyra
 * @subpackage unit test
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */

include(dirname(__FILE__).'/../../bootstrap/Doctrine.php');

$t = new lime_test(6, new lime_output_color());

$params = new LyraConfig('settings');

$t->is($params->get('enable_registration', 'users'), true, '->get() global param (boolean)');
$t->is($params->get('moderate_comments', 'comments'), 'moderate_all', '->get() global param (list)');
$t->is($params->get('order_comments', 'comments'), 'date_asc', '->get() global param (default)');

$article = LyraArticleTable::getInstance()
  ->findOneByTitle('art4');

$params = new LyraConfig($article);

$t->is($params->get('show_read_more', 'item'), false, '->get() item param (boolean set on item)');
$t->is($params->get('show_author', 'item'), true, '->get() item param (boolean default on content type)');
$t->is($params->get('linked_title', 'item'), true, '->get() item param (boolean set on content type)');