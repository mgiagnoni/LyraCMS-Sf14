<?php

/**
 * LyraMenu form base class.
 *
 * @method LyraMenu getObject() Returns the current form's model object
 *
 * @package    lyra
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLyraMenuForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'parent_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MenuParent'), 'add_empty' => true)),
      'type'      => new sfWidgetFormInputText(),
      'ctype_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MenuContentType'), 'add_empty' => true)),
      'object_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MenuItemObject'), 'add_empty' => true)),
      'list_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MenuItemList'), 'add_empty' => true)),
      'name'      => new sfWidgetFormInputText(),
      'params'    => new sfWidgetFormTextarea(),
      'root_id'   => new sfWidgetFormInputText(),
      'lft'       => new sfWidgetFormInputText(),
      'rgt'       => new sfWidgetFormInputText(),
      'level'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'parent_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('MenuParent'), 'required' => false)),
      'type'      => new sfValidatorString(array('max_length' => 20)),
      'ctype_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('MenuContentType'), 'required' => false)),
      'object_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('MenuItemObject'), 'required' => false)),
      'list_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('MenuItemList'), 'required' => false)),
      'name'      => new sfValidatorString(array('max_length' => 255)),
      'params'    => new sfValidatorString(array('required' => false)),
      'root_id'   => new sfValidatorInteger(array('required' => false)),
      'lft'       => new sfValidatorInteger(array('required' => false)),
      'rgt'       => new sfValidatorInteger(array('required' => false)),
      'level'     => new sfValidatorInteger(array('required' => false)),
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
