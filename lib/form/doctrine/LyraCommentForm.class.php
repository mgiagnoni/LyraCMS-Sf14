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
 * LyraCommentForm
 *
 * @package lyra
 * @subpackage form
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class LyraCommentForm extends BaseLyraCommentForm
{
  public function configure()
  {
    $this->removeFields();
    $this->widgetSchema['article_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['author_name']->setLabel('AUTHOR_NAME');
    $this->widgetSchema['author_email']->setLabel('AUTHOR_EMAIL');
    $this->widgetSchema['content']->setLabel(false);
    $this->widgetSchema['content']->setAttribute('rows',12);
    $this->widgetSchema['content']->setAttribute('cols',45);
    $this->widgetSchema->setHelp('author_email','AUTHOR_EMAIL_HELP');
    
    $params = $this->getOption('params');
    $user = $this->getOption('user');
    if(null !== $params && null !== $user && $user->isAuthenticated())
    {
      if($params->get('capture_email_comments'))
      {
        $this->setDefault('author_email', $user->getGuardUser()->getProfile()->getEmail());
      }
      if($params->get('capture_name_comments'))
      {
        $this->setDefault('author_name', trim($user->getGuardUser()->getProfile()->getFirstName() . ' ' . $user->getGuardUser()->getProfile()->getLastName()));
      }
    }
    $this->validatorSchema['author_name']->setMessage('required','AUTHOR_NAME_REQUIRED');
    $this->validatorSchema['content']->setMessage('required','CONTENT_REQUIRED');
    $this->validatorSchema['author_email'] = new sfValidatorEmail(
      array('required'=>true),
      array('required'=>'AUTHOR_EMAIL_REQUIRED','invalid'=>'AUTHOR_EMAIL_INVALID')
    );
    if(isset($this['author_url']))
    {
      $this->widgetSchema['author_url']->setLabel('AUTHOR_URL');
      $this->validatorSchema['author_url'] = new sfValidatorUrl(
        array('required'=>false),
        array('invalid'=>'AUTHOR_URL_INVALID')
      );
    }
    $this->widgetSchema->setFormFormatterName('LyraComment');
    $this->widgetSchema->setNameFormat('comment[%s]');
  }
  public function updateObject($values = null)
  {
    $item = parent::updateObject($values);
    $user_auth = false;

    if($user = $this->getOption('user')) {
      $user_auth = $user->isAuthenticated();
    }
    if($user_auth && $this->isNew()) {
      $item->setCreatedBy($user->getGuardUser()->getId());
    }

    if(!isset($this['is_active']))
    {
      $params = new LyraConfig('settings');
      switch($params->get('moderate_comments', 'comments'))
      {
        case 'moderate_none':
          $publish = true;
          break;
        case 'moderate_no_auth':
          $publish = $user_auth;
          break;
        case 'moderate_all':
        default:
          $publish = false;
          break;
      }
      $item->setIsActive($publish);
    }
    return $item;
  }
  protected function removeFields()
  {
    unset($this['created_at'], $this['updated_at'], $this['is_active'], $this['created_by']);
    $params = $this->getOption('params');
    if(false === $params->get('author_url_comments'))
    {
      unset($this['author_url']);
    }
  }
}