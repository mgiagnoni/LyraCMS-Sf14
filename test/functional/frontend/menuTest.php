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
 * menu test
 *
 * @package lyra
 * @subpackage functional test
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new LyraTestFunctional(new sfBrowser());
$browser->loadData();

$browser->info('1 - Main menu')->
  get('/')->
  with('response')->begin()->
  checkElement('ul.menu', true)->
  checkElement('ul.menu li', 4)->
  checkElement('ul.menu li:first-child', '/Home/')->
  checkElement('ul.menu li:nth-child(2)', '/Page/')->
  checkElement('ul.menu li:nth-child(2) a[href$="test-page.html"]')->
  checkElement('ul.menu li:nth-child(2) ul li:first-child', '/SubItem/')->
  checkElement('ul.menu li:nth-child(2) ul li:first-child a[href$="art1.html"]')->
  checkElement('ul.menu li:nth-child(3)', '/External/')->
  checkElement('ul.menu li:nth-child(3) a[href="http://www.example.com"]')->
  end()
;
