<?php

/**
 * LyraComment form.
 *
 * @package    form
 * @subpackage LyraComment
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class LyraCommentForm extends BaseLyraCommentForm
{
  public function configure()
  {
    $this->removeFields();
    $this->widgetSchema['article_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['author_name']->setLabel('AUTHOR_NAME');
    $this->widgetSchema['author_email']->setLabel('AUTHOR_EMAIL');
    $this->widgetSchema['author_url']->setLabel('AUTHOR_URL');
    $this->widgetSchema['content']->setLabel(false);
    $this->widgetSchema['content']->setAttribute('rows',12);
    $this->widgetSchema['content']->setAttribute('cols',45);
    $this->widgetSchema->setHelp('author_email','AUTHOR_EMAIL_HELP');

    $this->validatorSchema['author_name']->setMessage('required','AUTHOR_NAME_REQUIRED');
    $this->validatorSchema['content']->setMessage('required','CONTENT_REQUIRED');
    $this->validatorSchema['author_email'] = new sfValidatorEmail(
      array('required'=>true),
      array('required'=>'AUTHOR_EMAIL_REQUIRED','invalid'=>'AUTHOR_EMAIL_INVALID')
    );
    $this->validatorSchema['author_url'] = new sfValidatorUrl(
      array('required'=>false),
      array('invalid'=>'AUTHOR_URL_INVALID')
    );

    $this->widgetSchema->setFormFormatterName('LyraComment');
  }
  public function updateObject($values = null)
  {
    $item = parent::updateObject($values);
    $user = $this->getOption('user');
    if($user->isAuthenticated()) {
      $uid = $user->getGuardUser()->getId();
      if($this->isNew()) {
        $item->setCreatedBy($uid);
      }
    }
    return $item;
  }
  protected function removeFields()
  {
    unset($this['created_at'], $this['updated_at'], $this['is_active'], $this['created_by']);
  }
}