<?php

/**
 * LyraComponent filter form base class.
 *
 * @package    lyra
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseLyraComponentFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'ctype_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ComponentContentType'), 'add_empty' => true)),
      'module'                 => new sfWidgetFormFilterInput(),
      'action'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'component_regions_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LyraRegion')),
    ));

    $this->setValidators(array(
      'ctype_id'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ComponentContentType'), 'column' => 'id')),
      'module'                 => new sfValidatorPass(array('required' => false)),
      'action'                 => new sfValidatorPass(array('required' => false)),
      'component_regions_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LyraRegion', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lyra_component_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addComponentRegionsListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('LyraRegionComponent.region_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'LyraComponent';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'ctype_id'               => 'ForeignKey',
      'module'                 => 'Text',
      'action'                 => 'Text',
      'component_regions_list' => 'ManyKey',
    );
  }
}
