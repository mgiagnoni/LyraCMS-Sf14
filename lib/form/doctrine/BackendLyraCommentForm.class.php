<?php

class BackendLyraCommentForm extends LyraCommentForm
{
  public function configure()
  {
      parent::configure();

      $this->widgetSchema->setHelp('author_email',false);

      if(!$this->getOption('user')->hasCredential(array('comment_administer', 'comment_approve'), false))
      {
        $this->widgetSchema['is_active'] = new sfWidgetFormInputHidden();
        $this->validatorSchema['is_active'] = new sfValidatorChoice(array('choices' => array($this->getObject()->getIsActive()), 'empty_value' => $this->getObject()->getIsActive(), 'required' => false));
      }

  }
  protected function removeFields()
  {
      unset($this['created_at'], $this['updated_at'], $this['created_by']);
  }
}

