<?php

/**
 * LyraSettings filter form base class.
 *
 * @package    lyra
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseLyraSettingsFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'params' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'params' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lyra_settings_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LyraSettings';
  }

  public function getFields()
  {
    return array(
      'id'     => 'Number',
      'params' => 'Text',
    );
  }
}
