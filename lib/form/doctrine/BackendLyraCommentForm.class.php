<?php

class BackendLyraCommentForm extends LyraCommentForm
{
  public function configure()
  {
      parent::configure();
      $this->widgetSchema['is_active']->setLabel('IS_ACTIVE');

      $this->widgetSchema->setHelp('author_email',false);
      $this->widgetSchema->moveField('is_active', sfWidgetFormSchema::FIRST);

  }
  protected function removeFields()
  {
      unset($this['created_at'], $this['updated_at']);
  }
}

