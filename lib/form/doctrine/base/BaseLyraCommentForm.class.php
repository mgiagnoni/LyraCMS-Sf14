<?php

/**
 * LyraComment form base class.
 *
 * @package    form
 * @subpackage lyra_comment
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseLyraCommentForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'article_id'   => new sfWidgetFormDoctrineChoice(array('model' => 'LyraArticle', 'add_empty' => true)),
      'author_name'  => new sfWidgetFormInput(),
      'author_email' => new sfWidgetFormInput(),
      'author_url'   => new sfWidgetFormInput(),
      'content'      => new sfWidgetFormTextarea(),
      'is_active'    => new sfWidgetFormInputCheckbox(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorDoctrineChoice(array('model' => 'LyraComment', 'column' => 'id', 'required' => false)),
      'article_id'   => new sfValidatorDoctrineChoice(array('model' => 'LyraArticle', 'required' => false)),
      'author_name'  => new sfValidatorString(array('max_length' => 255)),
      'author_email' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'author_url'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'content'      => new sfValidatorString(),
      'is_active'    => new sfValidatorBoolean(),
      'created_at'   => new sfValidatorDateTime(array('required' => false)),
      'updated_at'   => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lyra_comment[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'LyraComment';
  }

}
