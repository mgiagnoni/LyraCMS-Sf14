<?php

/**
 * LyraContent filter form base class.
 *
 * @package    lyra
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseLyraContentFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'ctype_id' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'params'   => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'ctype_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'params'   => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lyra_content_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LyraContent';
  }

  public function getFields()
  {
    return array(
      'id'       => 'Number',
      'ctype_id' => 'Number',
      'params'   => 'Text',
    );
  }
}
