<?php

/**
 * LyraContentType filter form base class.
 *
 * @package    lyra
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseLyraContentTypeFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'type'                       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'name'                       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'                => new sfWidgetFormFilterInput(),
      'model'                      => new sfWidgetFormFilterInput(),
      'module'                     => new sfWidgetFormFilterInput(),
      'plugin'                     => new sfWidgetFormFilterInput(),
      'is_active'                  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'params'                     => new sfWidgetFormFilterInput(),
      'created_at'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'content_type_catalogs_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LyraCatalog')),
    ));

    $this->setValidators(array(
      'type'                       => new sfValidatorPass(array('required' => false)),
      'name'                       => new sfValidatorPass(array('required' => false)),
      'description'                => new sfValidatorPass(array('required' => false)),
      'model'                      => new sfValidatorPass(array('required' => false)),
      'module'                     => new sfValidatorPass(array('required' => false)),
      'plugin'                     => new sfValidatorPass(array('required' => false)),
      'is_active'                  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'params'                     => new sfValidatorPass(array('required' => false)),
      'created_at'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'content_type_catalogs_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LyraCatalog', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lyra_content_type_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addContentTypeCatalogsListColumnQuery(Doctrine_Query $query, $field, $values)
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
          ->andWhereIn('LyraContentTypeCatalog.catalog_id', $values);
  }

  public function getModelName()
  {
    return 'LyraContentType';
  }

  public function getFields()
  {
    return array(
      'id'                         => 'Number',
      'type'                       => 'Text',
      'name'                       => 'Text',
      'description'                => 'Text',
      'model'                      => 'Text',
      'module'                     => 'Text',
      'plugin'                     => 'Text',
      'is_active'                  => 'Boolean',
      'params'                     => 'Text',
      'created_at'                 => 'Date',
      'updated_at'                 => 'Date',
      'content_type_catalogs_list' => 'ManyKey',
    );
  }
}
