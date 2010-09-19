<?php

/**
 * LyraContentTypeCatalog form base class.
 *
 * @method LyraContentTypeCatalog getObject() Returns the current form's model object
 *
 * @package    lyra
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
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
      'ctype_id'   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('ctype_id')), 'empty_value' => $this->getObject()->get('ctype_id'), 'required' => false)),
      'catalog_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('catalog_id')), 'empty_value' => $this->getObject()->get('catalog_id'), 'required' => false)),
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
