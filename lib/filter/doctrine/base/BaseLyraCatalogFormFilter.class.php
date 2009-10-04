<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * LyraCatalog filter form base class.
 *
 * @package    filters
 * @subpackage LyraCatalog *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseLyraCatalogFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                       => new sfWidgetFormFilterInput(),
      'description'                => new sfWidgetFormFilterInput(),
      'is_active'                  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'locked_by'                  => new sfWidgetFormFilterInput(),
      'created_at'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'catalog_content_types_list' => new sfWidgetFormDoctrineChoiceMany(array('model' => 'LyraContentType')),
    ));

    $this->setValidators(array(
      'name'                       => new sfValidatorPass(array('required' => false)),
      'description'                => new sfValidatorPass(array('required' => false)),
      'is_active'                  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'locked_by'                  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'catalog_content_types_list' => new sfValidatorDoctrineChoiceMany(array('model' => 'LyraContentType', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lyra_catalog_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addCatalogContentTypesListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query->leftJoin('r.LyraContentTypeCatalog LyraContentTypeCatalog')
          ->andWhereIn('LyraContentTypeCatalog.ctype_id', $values);
  }

  public function getModelName()
  {
    return 'LyraCatalog';
  }

  public function getFields()
  {
    return array(
      'id'                         => 'Number',
      'name'                       => 'Text',
      'description'                => 'Text',
      'is_active'                  => 'Boolean',
      'locked_by'                  => 'Number',
      'created_at'                 => 'Date',
      'updated_at'                 => 'Date',
      'catalog_content_types_list' => 'ManyKey',
    );
  }
}