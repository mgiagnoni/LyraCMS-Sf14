<?php

/**
 * LyraMenu filter form base class.
 *
 * @package    lyra
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseLyraMenuFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'parent_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MenuParent'), 'add_empty' => true)),
      'type'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'ctype_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MenuContentType'), 'add_empty' => true)),
      'element_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MenuContentItem'), 'add_empty' => true)),
      'name'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'params'     => new sfWidgetFormFilterInput(),
      'root_id'    => new sfWidgetFormFilterInput(),
      'lft'        => new sfWidgetFormFilterInput(),
      'rgt'        => new sfWidgetFormFilterInput(),
      'level'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'parent_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('MenuParent'), 'column' => 'id')),
      'type'       => new sfValidatorPass(array('required' => false)),
      'ctype_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('MenuContentType'), 'column' => 'id')),
      'element_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('MenuContentItem'), 'column' => 'id')),
      'name'       => new sfValidatorPass(array('required' => false)),
      'params'     => new sfValidatorPass(array('required' => false)),
      'root_id'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'lft'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'rgt'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'level'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('lyra_menu_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LyraMenu';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'parent_id'  => 'ForeignKey',
      'type'       => 'Text',
      'ctype_id'   => 'ForeignKey',
      'element_id' => 'ForeignKey',
      'name'       => 'Text',
      'params'     => 'Text',
      'root_id'    => 'Number',
      'lft'        => 'Number',
      'rgt'        => 'Number',
      'level'      => 'Number',
    );
  }
}
