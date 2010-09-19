<?php

/**
 * LyraCatalog form base class.
 *
 * @method LyraCatalog getObject() Returns the current form's model object
 *
 * @package    lyra
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLyraCatalogForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                         => new sfWidgetFormInputHidden(),
      'name'                       => new sfWidgetFormInputText(),
      'description'                => new sfWidgetFormTextarea(),
      'is_active'                  => new sfWidgetFormInputCheckbox(),
      'locked_by'                  => new sfWidgetFormInputText(),
      'created_at'                 => new sfWidgetFormDateTime(),
      'updated_at'                 => new sfWidgetFormDateTime(),
      'catalog_content_types_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LyraContentType')),
    ));

    $this->setValidators(array(
      'id'                         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'                       => new sfValidatorString(array('max_length' => 255)),
      'description'                => new sfValidatorString(array('max_length' => 4000, 'required' => false)),
      'is_active'                  => new sfValidatorBoolean(array('required' => false)),
      'locked_by'                  => new sfValidatorInteger(array('required' => false)),
      'created_at'                 => new sfValidatorDateTime(),
      'updated_at'                 => new sfValidatorDateTime(),
      'catalog_content_types_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LyraContentType', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lyra_catalog[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

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
    $this->saveCatalogContentTypesList($con);

    parent::doSave($con);
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

    if (null === $con)
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
