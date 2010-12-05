<?php

/**
 * LyraRoute form base class.
 *
 * @method LyraRoute getObject() Returns the current form's model object
 *
 * @package    lyra
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLyraRouteForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'       => new sfWidgetFormInputHidden(),
      'ctype_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('RouteContentType'), 'add_empty' => false)),
      'name'     => new sfWidgetFormInputText(),
      'action'   => new sfWidgetFormInputText(),
      'params'   => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'ctype_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('RouteContentType'))),
      'name'     => new sfValidatorString(array('max_length' => 80, 'required' => false)),
      'action'   => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'params'   => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lyra_route[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LyraRoute';
  }

}
