<?php

/**
 * LyraCatalog form base class.
 *
 * @package    form
 * @subpackage lyra_catalog
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseLyraCatalogForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                         => new sfWidgetFormInputHidden(),
      'name'                       => new sfWidgetFormInput(),
      'description'                => new sfWidgetFormTextarea(),
      'is_active'                  => new sfWidgetFormInputCheckbox(),
      'locked_by'                  => new sfWidgetFormInput(),
      'created_at'                 => new sfWidgetFormDateTime(),
      'updated_at'                 => new sfWidgetFormDateTime(),
      'catalog_content_types_list' => new sfWidgetFormDoctrineChoiceMany(array('model' => 'LyraContentType')),
    ));

    $this->setValidators(array(
      'id'                         => new sfValidatorDoctrineChoice(array('model' => 'LyraCatalog', 'column' => 'id', 'required' => false)),
      'name'                       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description'                => new sfValidatorString(array('max_length' => 4000, 'required' => false)),
      'is_active'                  => new sfValidatorBoolean(),
      'locked_by'                  => new sfValidatorInteger(array('required' => false)),
      'created_at'                 => new sfValidatorDateTime(array('required' => false)),
      'updated_at'                 => new sfValidatorDateTime(array('required' => false)),
      'catalog_content_types_list' => new sfValidatorDoctrineChoiceMany(array('model' => 'LyraContentType', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lyra_catalog[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'LyraCatalog';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['catalog_content_types_list']))
    {
      $this->setDefault('catalog_content_types_list', $this->object->CatalogContentTypes->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveCatalogContentTypesList($con);
  }

  public function saveCatalogContentTypesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['catalog_content_types_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->CatalogContentTypes->getPrimaryKeys();
    $values = $this->getValue('catalog_content_types_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('CatalogContentTypes', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('CatalogContentTypes', array_values($link));
    }
  }

}
