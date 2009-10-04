<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * LyraLabel filter form base class.
 *
 * @package    filters
 * @subpackage LyraLabel *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseLyraLabelFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'catalog_id'          => new sfWidgetFormDoctrineChoice(array('model' => 'LyraCatalog', 'add_empty' => true)),
      'name'                => new sfWidgetFormFilterInput(),
      'title'               => new sfWidgetFormFilterInput(),
      'description'         => new sfWidgetFormFilterInput(),
      'meta_title'          => new sfWidgetFormFilterInput(),
      'meta_robots'         => new sfWidgetFormFilterInput(),
      'meta_descr'          => new sfWidgetFormFilterInput(),
      'meta_keys'           => new sfWidgetFormFilterInput(),
      'is_active'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_by'          => new sfWidgetFormFilterInput(),
      'updated_by'          => new sfWidgetFormFilterInput(),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'slug'                => new sfWidgetFormFilterInput(),
      'root_id'             => new sfWidgetFormFilterInput(),
      'lft'                 => new sfWidgetFormFilterInput(),
      'rgt'                 => new sfWidgetFormFilterInput(),
      'level'               => new sfWidgetFormFilterInput(),
      'label_articles_list' => new sfWidgetFormDoctrineChoiceMany(array('model' => 'LyraArticle')),
    ));

    $this->setValidators(array(
      'catalog_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'LyraCatalog', 'column' => 'id')),
      'name'                => new sfValidatorPass(array('required' => false)),
      'title'               => new sfValidatorPass(array('required' => false)),
      'description'         => new sfValidatorPass(array('required' => false)),
      'meta_title'          => new sfValidatorPass(array('required' => false)),
      'meta_robots'         => new sfValidatorPass(array('required' => false)),
      'meta_descr'          => new sfValidatorPass(array('required' => false)),
      'meta_keys'           => new sfValidatorPass(array('required' => false)),
      'is_active'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_by'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'updated_by'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'slug'                => new sfValidatorPass(array('required' => false)),
      'root_id'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'lft'                 => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'rgt'                 => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'level'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'label_articles_list' => new sfValidatorDoctrineChoiceMany(array('model' => 'LyraArticle', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lyra_label_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

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

    $query->leftJoin('r.LyraArticleLabel LyraArticleLabel')
          ->andWhereIn('LyraArticleLabel.article_id', $values);
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
      'created_by'          => 'Number',
      'updated_by'          => 'Number',
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