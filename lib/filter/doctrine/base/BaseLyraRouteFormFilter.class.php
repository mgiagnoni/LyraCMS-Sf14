<?php

/**
 * LyraRoute filter form base class.
 *
 * @package    lyra
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id$
 */
abstract class BaseLyraRouteFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'ctype_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('RouteContentType'), 'add_empty' => true)),
      'name'     => new sfWidgetFormFilterInput(),
      'action'   => new sfWidgetFormFilterInput(),
      'params'   => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'ctype_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('RouteContentType'), 'column' => 'id')),
      'name'     => new sfValidatorPass(array('required' => false)),
      'action'   => new sfValidatorPass(array('required' => false)),
      'params'   => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lyra_route_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LyraRoute';
  }

  public function getFields()
  {
    return array(
      'id'       => 'Number',
      'ctype_id' => 'ForeignKey',
      'name'     => 'Text',
      'action'   => 'Text',
      'params'   => 'Text',
    );
  }
}
