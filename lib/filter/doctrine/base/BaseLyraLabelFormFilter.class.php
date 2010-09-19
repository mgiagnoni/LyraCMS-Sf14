<?php

/**
 * LyraLabel filter form base class.
 *
 * @package    lyra
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseLyraLabelFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'catalog_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LabelCatalog'), 'add_empty' => true)),
      'name'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'title'               => new sfWidgetFormFilterInput(),
      'description'         => new sfWidgetFormFilterInput(),
      'meta_title'          => new sfWidgetFormFilterInput(),
      'meta_robots'         => new sfWidgetFormFilterInput(),
      'meta_descr'          => new sfWidgetFormFilterInput(),
      'meta_keys'           => new sfWidgetFormFilterInput(),
      'is_active'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_by'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LabelCreatedBy'), 'add_empty' => true)),
      'updated_by'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LabelUpdatedBy'), 'add_empty' => true)),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'slug'                => new sfWidgetFormFilterInput(),
      'root_id'             => new sfWidgetFormFilterInput(),
      'lft'                 => new sfWidgetFormFilterInput(),
      'rgt'                 => new sfWidgetFormFilterInput(),
      'level'               => new sfWidgetFormFilterInput(),
      'label_articles_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LyraArticle')),
    ));

    $this->setValidators(array(
      'catalog_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('LabelCatalog'), 'column' => 'id')),
      'name'                => new sfValidatorPass(array('required' => false)),
      'title'               => new sfValidatorPass(array('required' => false)),
      'description'         => new sfValidatorPass(array('required' => false)),
      'meta_title'          => new sfValidatorPass(array('required' => false)),
      'meta_robots'         => new sfValidatorPass(array('required' => false)),
      'meta_descr'          => new sfValidatorPass(array('required' => false)),
      'meta_keys'           => new sfValidatorPass(array('required' => false)),
      'is_active'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_by'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('LabelCreatedBy'), 'column' => 'id')),
      'updated_by'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('LabelUpdatedBy'), 'column' => 'id')),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'slug'                => new sfValidatorPass(array('required' => false)),
      'root_id'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'lft'                 => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'rgt'                 => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'level'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'label_articles_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LyraArticle', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lyra_label_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addLabelArticlesListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.LyraArticleLabel LyraArticleLabel')
      ->andWhereIn('LyraArticleLabel.article_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'LyraLabel';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'catalog_id'          => 'ForeignKey',
      'name'                => 'Text',
      'title'               => 'Text',
      'description'         => 'Text',
      'meta_title'          => 'Text',
      'meta_robots'         => 'Text',
      'meta_descr'          => 'Text',
      'meta_keys'           => 'Text',
      'is_active'           => 'Boolean',
      'created_by'          => 'ForeignKey',
      'updated_by'          => 'ForeignKey',
      'created_at'          => 'Date',
      'updated_at'          => 'Date',
      'slug'                => 'Text',
      'root_id'             => 'Number',
      'lft'                 => 'Number',
      'rgt'                 => 'Number',
      'level'               => 'Number',
      'label_articles_list' => 'ManyKey',
    );
  }
}
