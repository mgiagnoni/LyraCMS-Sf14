<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * LyraContentTypeCatalog filter form base class.
 *
 * @package    filters
 * @subpackage LyraContentTypeCatalog *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseLyraContentTypeCatalogFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('lyra_content_type_catalog_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'LyraContentTypeCatalog';
  }

  public function getFields()
  {
    return array(
      'ctype_id'   => 'Number',
      'catalog_id' => 'Number',
    );
  }
}