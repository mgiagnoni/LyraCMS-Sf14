<?php

/**
 * LyraComment form base class.
 *
 * @method LyraComment getObject() Returns the current form's model object
 *
 * @package    lyra
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseLyraCommentForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'article_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CommentArticle'), 'add_empty' => true)),
      'author_name'  => new sfWidgetFormInputText(),
      'author_email' => new sfWidgetFormInputText(),
      'author_url'   => new sfWidgetFormInputText(),
      'content'      => new sfWidgetFormTextarea(),
      'is_active'    => new sfWidgetFormInputCheckbox(),
      'created_by'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CommentCreatedBy'), 'add_empty' => true)),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'article_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CommentArticle'), 'required' => false)),
      'author_name'  => new sfValidatorString(array('max_length' => 255)),
      'author_email' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'author_url'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'content'      => new sfValidatorString(),
      'is_active'    => new sfValidatorBoolean(array('required' => false)),
      'created_by'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CommentCreatedBy'), 'required' => false)),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('lyra_comment[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LyraComment';
  }

}
