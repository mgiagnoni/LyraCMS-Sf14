<?php

/**
 * LyraContent filter form base class.
 *
 * @package    lyra
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseLyraContentFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'ctype_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ContentType'), 'add_empty' => true)),
      'path'        => new sfWidgetFormFilterInput(),
      'params'      => new sfWidgetFormFilterInput(),
      'meta_title'  => new sfWidgetFormFilterInput(),
      'meta_descr'  => new sfWidgetFormFilterInput(),
      'meta_keys'   => new sfWidgetFormFilterInput(),
      'meta_robots' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'ctype_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ContentType'), 'column' => 'id')),
      'path'        => new sfValidatorPass(array('required' => false)),
      'params'      => new sfValidatorPass(array('required' => false)),
      'meta_title'  => new sfValidatorPass(array('required' => false)),
      'meta_descr'  => new sfValidatorPass(array('required' => false)),
      'meta_keys'   => new sfValidatorPass(array('required' => false)),
      'meta_robots' => new sfValidatorPass(array('required' => false)),
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
      'id'          => 'Number',
      'ctype_id'    => 'ForeignKey',
      'path'        => 'Text',
      'params'      => 'Text',
      'meta_title'  => 'Text',
      'meta_descr'  => 'Text',
      'meta_keys'   => 'Text',
      'meta_robots' => 'Text',
    );
  }
}
