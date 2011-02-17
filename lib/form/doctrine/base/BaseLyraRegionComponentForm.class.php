<?php

/**
 * LyraRegionComponent form base class.
 *
 * @method LyraRegionComponent getObject() Returns the current form's model object
 *
 * @package    lyra
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLyraRegionComponentForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'region_id'    => new sfWidgetFormInputHidden(),
      'component_id' => new sfWidgetFormInputHidden(),
      'params'       => new sfWidgetFormInputText(),
      'vis_flag'     => new sfWidgetFormInputCheckbox(),
      'position'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'region_id'    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('region_id')), 'empty_value' => $this->getObject()->get('region_id'), 'required' => false)),
      'component_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('component_id')), 'empty_value' => $this->getObject()->get('component_id'), 'required' => false)),
      'params'       => new sfValidatorPass(array('required' => false)),
      'vis_flag'     => new sfValidatorBoolean(array('required' => false)),
      'position'     => new sfValidatorInteger(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'LyraRegionComponent', 'column' => array('position', 'region_id')))
    );

    $this->widgetSchema->setNameFormat('lyra_region_component[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LyraRegionComponent';
  }

}
