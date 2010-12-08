<?php

/**
 * LyraRegion filter form base class.
 *
 * @package    lyra
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseLyraRegionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'region_components_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LyraComponent')),
    ));

    $this->setValidators(array(
      'name'                   => new sfValidatorPass(array('required' => false)),
      'region_components_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LyraComponent', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lyra_region_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addRegionComponentsListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.LyraRegionComponent LyraRegionComponent')
      ->andWhereIn('LyraRegionComponent.component_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'LyraRegion';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'name'                   => 'Text',
      'region_components_list' => 'ManyKey',
    );
  }
}
