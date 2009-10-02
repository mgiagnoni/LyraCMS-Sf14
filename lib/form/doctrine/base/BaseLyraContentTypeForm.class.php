<?php

/**
 * LyraContentType form base class.
 *
 * @package    form
 * @subpackage lyra_content_type
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseLyraContentTypeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                         => new sfWidgetFormInputHidden(),
      'name'                       => new sfWidgetFormInput(),
      'description'                => new sfWidgetFormTextarea(),
      'db_name'                    => new sfWidgetFormInput(),
      'module'                     => new sfWidgetFormInput(),
      'is_active'                  => new sfWidgetFormInputCheckbox(),
      'created_at'                 => new sfWidgetFormDateTime(),
      'updated_at'                 => new sfWidgetFormDateTime(),
      'content_type_catalogs_list' => new sfWidgetFormDoctrineChoiceMany(array('model' => 'LyraCatalog')),
    ));

    $this->setValidators(array(
      'id'                         => new sfValidatorDoctrineChoice(array('model' => 'LyraContentType', 'column' => 'id', 'required' => false)),
      'name'                       => new sfValidatorString(array('max_length' => 255)),
      'description'                => new sfValidatorString(array('max_length' => 4000, 'required' => false)),
      'db_name'                    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'module'                     => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'is_active'                  => new sfValidatorBoolean(),
      'created_at'                 => new sfValidatorDateTime(array('required' => false)),
      'updated_at'                 => new sfValidatorDateTime(array('required' => false)),
      'content_type_catalogs_list' => new sfValidatorDoctrineChoiceMany(array('model' => 'LyraCatalog', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lyra_content_type[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

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
    parent::doSave($con);

    $this->saveContentTypeCatalogsList($con);
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

    if (is_null($con))
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
