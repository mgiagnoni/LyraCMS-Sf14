<?php

/**
 * LyraComponent form base class.
 *
 * @method LyraComponent getObject() Returns the current form's model object
 *
 * @package    lyra
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLyraComponentForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'ctype_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ComponentContentType'), 'add_empty' => true)),
      'module'                 => new sfWidgetFormInputText(),
      'action'                 => new sfWidgetFormInputText(),
      'component_regions_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LyraRegion')),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'ctype_id'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ComponentContentType'), 'required' => false)),
      'module'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'action'                 => new sfValidatorString(array('max_length' => 255)),
      'component_regions_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LyraRegion', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lyra_component[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LyraComponent';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['component_regions_list']))
    {
      $this->setDefault('component_regions_list', $this->object->ComponentRegions->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveComponentRegionsList($con);

    parent::doSave($con);
  }

  public function saveComponentRegionsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['component_regions_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->ComponentRegions->getPrimaryKeys();
    $values = $this->getValue('component_regions_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('ComponentRegions', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('ComponentRegions', array_values($link));
    }
  }

}
