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
 * LyraUserTest
 *
 * @package lyra
 * @subpackage unit test
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
include(dirname(__FILE__).'/../../bootstrap/Doctrine.php');

$t = new lime_test(3, new lime_output_color());

$_SERVER['session_id'] = 'test';

$dispatcher = new sfEventDispatcher();
$sessionPath = sys_get_temp_dir().'/sessions_'.rand(11111, 99999);
$storage = new sfSessionTestStorage(array('session_path' => $sessionPath));

$user = new sfGuardSecurityUser($dispatcher, $storage);

$admin = Doctrine::getTable('sfGuarduser')
    ->findOneByUsername('admin');

$user->signIn($admin);
$t->is($user->isAuthenticated(), true, '->isAuthenticated()');
$t->is($user->isSuperAdmin(), true, '->isSuperAdmin()');
$t->is($user->getProfile()->getEmail(), 'lyra@localhost', '->getProfile()->getEmail()');
