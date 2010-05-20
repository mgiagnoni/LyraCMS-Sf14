<?php

/**
 * LyraMenu form base class.
 *
 * @method LyraMenu getObject() Returns the current form's model object
 *
 * @package    lyra
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseLyraMenuForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'parent_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MenuParent'), 'add_empty' => true)),
      'type'       => new sfWidgetFormInputText(),
      'ctype_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MenuContentType'), 'add_empty' => true)),
      'element_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MenuContentItem'), 'add_empty' => true)),
      'name'       => new sfWidgetFormInputText(),
      'params'     => new sfWidgetFormTextarea(),
      'root_id'    => new sfWidgetFormInputText(),
      'lft'        => new sfWidgetFormInputText(),
      'rgt'        => new sfWidgetFormInputText(),
      'level'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'parent_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('MenuParent'), 'required' => false)),
      'type'       => new sfValidatorString(array('max_length' => 20)),
      'ctype_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('MenuContentType'), 'required' => false)),
      'element_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('MenuContentItem'), 'required' => false)),
      'name'       => new sfValidatorString(array('max_length' => 255)),
      'params'     => new sfValidatorString(array('required' => false)),
      'root_id'    => new sfValidatorInteger(array('required' => false)),
      'lft'        => new sfValidatorInteger(array('required' => false)),
      'rgt'        => new sfValidatorInteger(array('required' => false)),
      'level'      => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lyra_menu[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LyraMenu';
  }

}
