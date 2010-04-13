<?php

/**
 * LyraContentTypeCatalog form base class.
 *
 * @method LyraContentTypeCatalog getObject() Returns the current form's model object
 *
 * @package    lyra
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseLyraContentTypeCatalogForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'ctype_id'   => new sfWidgetFormInputHidden(),
      'catalog_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'ctype_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'ctype_id', 'required' => false)),
      'catalog_id' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'catalog_id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lyra_content_type_catalog[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LyraContentTypeCatalog';
  }

}
