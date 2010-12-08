<?php

/**
 * LyraRegion form base class.
 *
 * @method LyraRegion getObject() Returns the current form's model object
 *
 * @package    lyra
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLyraRegionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'name'                   => new sfWidgetFormInputText(),
      'region_components_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LyraComponent')),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'                   => new sfValidatorString(array('max_length' => 255)),
      'region_components_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LyraComponent', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lyra_region[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LyraRegion';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['region_components_list']))
    {
      $this->setDefault('region_components_list', $this->object->RegionComponents->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveRegionComponentsList($con);

    parent::doSave($con);
  }

  public function saveRegionComponentsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['region_components_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->RegionComponents->getPrimaryKeys();
    $values = $this->getValue('region_components_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('RegionComponents', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('RegionComponents', array_values($link));
    }
  }

}
