<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * LyraArticle filter form base class.
 *
 * @package    filters
 * @subpackage LyraArticle *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseLyraArticleFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'               => new sfWidgetFormFilterInput(),
      'subtitle'            => new sfWidgetFormFilterInput(),
      'summary'             => new sfWidgetFormFilterInput(),
      'content'             => new sfWidgetFormFilterInput(),
      'meta_title'          => new sfWidgetFormFilterInput(),
      'meta_descr'          => new sfWidgetFormFilterInput(),
      'meta_keys'           => new sfWidgetFormFilterInput(),
      'meta_robots'         => new sfWidgetFormFilterInput(),
      'is_active'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_featured'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_sticky'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'publish_start'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'publish_end'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'status'              => new sfWidgetFormFilterInput(),
      'options'             => new sfWidgetFormFilterInput(),
      'created_by'          => new sfWidgetFormFilterInput(),
      'updated_by'          => new sfWidgetFormFilterInput(),
      'locked_by'           => new sfWidgetFormFilterInput(),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'slug'                => new sfWidgetFormFilterInput(),
      'article_labels_list' => new sfWidgetFormDoctrineChoiceMany(array('model' => 'LyraLabel')),
    ));

    $this->setValidators(array(
      'title'               => new sfValidatorPass(array('required' => false)),
      'subtitle'            => new sfValidatorPass(array('required' => false)),
      'summary'             => new sfValidatorPass(array('required' => false)),
      'content'             => new sfValidatorPass(array('required' => false)),
      'meta_title'          => new sfValidatorPass(array('required' => false)),
      'meta_descr'          => new sfValidatorPass(array('required' => false)),
      'meta_keys'           => new sfValidatorPass(array('required' => false)),
      'meta_robots'         => new sfValidatorPass(array('required' => false)),
      'is_active'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_featured'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_sticky'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'publish_start'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'publish_end'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'status'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'options'             => new sfValidatorPass(array('required' => false)),
      'created_by'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'updated_by'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'locked_by'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'slug'                => new sfValidatorPass(array('required' => false)),
      'article_labels_list' => new sfValidatorDoctrineChoiceMany(array('model' => 'LyraLabel', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lyra_article_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addArticleLabelsListColumnQuery(Doctrine_Query $query, $field, $values)
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
          ->andWhereIn('LyraArticleLabel.label_id', $values);
  }

  public function getModelName()
  {
    return 'LyraArticle';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'title'               => 'Text',
      'subtitle'            => 'Text',
      'summary'             => 'Text',
      'content'             => 'Text',
      'meta_title'          => 'Text',
      'meta_descr'          => 'Text',
      'meta_keys'           => 'Text',
      'meta_robots'         => 'Text',
      'is_active'           => 'Boolean',
      'is_featured'         => 'Boolean',
      'is_sticky'           => 'Boolean',
      'publish_start'       => 'Date',
      'publish_end'         => 'Date',
      'status'              => 'Number',
      'options'             => 'Text',
      'created_by'          => 'Number',
      'updated_by'          => 'Number',
      'locked_by'           => 'Number',
      'created_at'          => 'Date',
      'updated_at'          => 'Date',
      'slug'                => 'Text',
      'article_labels_list' => 'ManyKey',
    );
  }
}