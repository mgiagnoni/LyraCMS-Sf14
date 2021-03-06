<?php

/**
 * LyraContent form base class.
 *
 * @method LyraContent getObject() Returns the current form's model object
 *
 * @package    lyra
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLyraContentForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'ctype_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ContentType'), 'add_empty' => false)),
      'path'        => new sfWidgetFormInputText(),
      'params'      => new sfWidgetFormInputText(),
      'meta_title'  => new sfWidgetFormInputText(),
      'meta_descr'  => new sfWidgetFormTextarea(),
      'meta_keys'   => new sfWidgetFormTextarea(),
      'meta_robots' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'ctype_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ContentType'))),
      'path'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'params'      => new sfValidatorPass(array('required' => false)),
      'meta_title'  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'meta_descr'  => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'meta_keys'   => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'meta_robots' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lyra_content[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LyraContent';
  }

}
