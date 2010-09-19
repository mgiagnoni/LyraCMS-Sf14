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
      'id'       => new sfWidgetFormInputHidden(),
      'ctype_id' => new sfWidgetFormInputText(),
      'path'     => new sfWidgetFormInputText(),
      'params'   => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'ctype_id' => new sfValidatorInteger(),
      'path'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'params'   => new sfValidatorString(array('required' => false)),
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
