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
  public function preExecute()
  {
    $this->params = new LyraConfig('settings');
  }
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
    $this->show_registration_link = $this->params->get('enable_registration', 'users');
  }
  public function executeSignout(sfWebRequest $request)
  {
    $this->getUser()->signOut();
    $referer = $request->getReferer();
    return $this->redirect($referer ? $referer : '@homepage');
  }
  public function executeRegister(sfWebRequest $request)
  {
    $this->forward404Unless(true == $this->params->get('enable_registration', 'users'));

    $this->form = new LyraUserRegistrationForm();
    
  }
  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') && true == $this->params->get('enable_registration', 'users'));

    $this->form = new LyraUserRegistrationForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('register');
  }
  public function executeVerify(sfWebRequest $request)
  {
    $this->forward404Unless(true == $this->params->get('email_verification', 'users'));
    
    $this->form = new LyraEmailVerifyForm();

    if($request->isMethod('get'))
    {
      $this->form->setDefault('email', $request->getParameter('e'));
      $this->form->setDefault('token', $request->getParameter('v'));
    }
    else
    {
      $this->processEmailVerifyForm($request, $this->form);
    }
  }
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      $user = $form->save();

      if(null !== $user->getProfile()->getVtoken())
      {
        $this->sendVerificationEmail($user);
      }
      $this->getUser()->setFlash('notice', 'MSG_REGISTRATION_SENT');
      $this->redirect('user/register');
    }
  }
  protected function processEmailVerifyForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      $this->getUser()->setFlash('notice', 'MSG_EMAIL_VERIFICATION');
      $this->redirect('user/login');
    }
  }
  protected function sendVerificationEmail($user)
  {
    $mailer = $this->getMailer();

    $message = Swift_Message::newInstance()
      ->setFrom($this->params->get('system_from', 'mailer'))
      ->setTo($user->getProfile()->getEmail())
      ->setSubject($this->getContext()->getI18N()->__('EMAIL_VERIFICATION_SUBJECT'))
      ->setBody($this->getPartial('email_verification', array('email' => $user->getProfile()->getEmail(), 'token' => $user->getProfile()->getVtoken())))
    ;
    $mailer->send($message);
  }
}
