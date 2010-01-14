<?php

/**
 * LyraContentType form base class.
 *
 * @method LyraContentType getObject() Returns the current form's model object
 *
 * @package    lyra
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseLyraContentTypeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                         => new sfWidgetFormInputHidden(),
      'name'                       => new sfWidgetFormInputText(),
      'description'                => new sfWidgetFormTextarea(),
      'db_name'                    => new sfWidgetFormInputText(),
      'module'                     => new sfWidgetFormInputText(),
      'is_active'                  => new sfWidgetFormInputCheckbox(),
      'params'                     => new sfWidgetFormTextarea(),
      'created_at'                 => new sfWidgetFormDateTime(),
      'updated_at'                 => new sfWidgetFormDateTime(),
      'content_type_catalogs_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LyraCatalog')),
    ));

    $this->setValidators(array(
      'id'                         => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'name'                       => new sfValidatorString(array('max_length' => 255)),
      'description'                => new sfValidatorString(array('max_length' => 4000, 'required' => false)),
      'db_name'                    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'module'                     => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'is_active'                  => new sfValidatorBoolean(array('required' => false)),
      'params'                     => new sfValidatorString(array('required' => false)),
      'created_at'                 => new sfValidatorDateTime(),
      'updated_at'                 => new sfValidatorDateTime(),
      'content_type_catalogs_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LyraCatalog', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lyra_content_type[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LyraContentType';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['content_type_catalogs_list']))
    {
      $this->setDefault('content_type_catalogs_list', $this->object->ContentTypeCatalogs->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveContentTypeCatalogsList($con);

    parent::doSave($con);
  }

  public function saveContentTypeCatalogsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['content_type_catalogs_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->ContentTypeCatalogs->getPrimaryKeys();
    $values = $this->getValue('content_type_catalogs_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('ContentTypeCatalogs', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('ContentTypeCatalogs', array_values($link));
    }
  }

}
