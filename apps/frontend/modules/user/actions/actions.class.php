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
 * userActions
 *
 * @package lyra
 * @subpackage user
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class userActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'module');
  }
  public function executeSignin(sfWebRequest $request)
  {
    $user = $this->getUser();
    if ($user->isAuthenticated())
    {
      return $this->redirect('@homepage');
    }

    $this->form = new LyraUserSigninForm();

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('signin'));
      if ($this->form->isValid())
      {
        $values = $this->form->getValues();
        $this->getUser()->signin($values['user'], array_key_exists('remember', $values) ? $values['remember'] : false);

        $referer = $request->getReferer();
        return $this->redirect($referer ? $referer : '@homepage');
      }
    }
  }
  public function executeSignout(sfWebRequest $request)
  {
    $this->getUser()->signOut();
    $referer = $request->getReferer();
    return $this->redirect($referer ? $referer : '@homepage');
  }
  public function executeRegister(sfWebRequest $request)
  {
    $this->form = new LyraUserRegistrationForm();
    
  }
  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new LyraUserRegistrationForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('register');
  }
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      $user = $form->save();
      $this->getUser()->setFlash('notice', 'MSG_REGISTRATION_SENT');
      $this->redirect('user/register');
    }
  }
}
