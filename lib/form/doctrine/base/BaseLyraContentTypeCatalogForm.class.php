<?php

/**
 * LyraContentTypeCatalog form base class.
 *
 * @package    form
 * @subpackage lyra_content_type_catalog
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseLyraContentTypeCatalogForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'ctype_id'   => new sfWidgetFormInputHidden(),
      'catalog_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'ctype_id'   => new sfValidatorDoctrineChoice(array('model' => 'LyraContentTypeCatalog', 'column' => 'ctype_id', 'required' => false)),
      'catalog_id' => new sfValidatorDoctrineChoice(array('model' => 'LyraContentTypeCatalog', 'column' => 'catalog_id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lyra_content_type_catalog[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'LyraContentTypeCatalog';
  }

}
