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
 * admpanelActions
 *
 * @package lyra
 * @subpackage admpanel
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class admpanelActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $last_login = $this->getUser()->getGuarduser()->getLastLogin();
    $this->show_welcome = time() - strtotime($last_login) <= 5;
    $this->infos = null;
    $ctypes = LyraContentTypeTable::getInstance()->findAll();
    foreach($ctypes as $ctype)
    {
      if($ct = Doctrine_Core::getTable($ctype->getModel())->countUnpublishedItems($ctype->getId()))
      {
        $this->infos['unpub'][$ctype->getName()] = array('count' => $ct, 'ctype' => $ctype);
      }
    }
    if($this->getuser()->hasCredential(array('comment_administer', 'comment_approve'), false))
    {
      if($ct = LyraCommentTable::getInstance()->countUnpublishedItems())
      {
        $this->infos['comment'] = $ct;
      }
    }
  }
}
