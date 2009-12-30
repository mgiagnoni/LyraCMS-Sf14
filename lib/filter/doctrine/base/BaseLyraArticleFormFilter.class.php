<?php

/**
 * LyraArticle filter form base class.
 *
 * @package    lyra
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseLyraArticleFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'ctype_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ContentType'), 'add_empty' => true)),
      'title'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
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
      'publish_start'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'publish_end'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'status'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'options'             => new sfWidgetFormFilterInput(),
      'created_by'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArticleCreatedBy'), 'add_empty' => true)),
      'updated_by'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArticleUpdatedBy'), 'add_empty' => true)),
      'locked_by'           => new sfWidgetFormFilterInput(),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'slug'                => new sfWidgetFormFilterInput(),
      'article_labels_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LyraLabel')),
    ));

    $this->setValidators(array(
      'ctype_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ContentType'), 'column' => 'id')),
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
      'publish_start'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'publish_end'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'status'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'options'             => new sfValidatorPass(array('required' => false)),
      'created_by'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ArticleCreatedBy'), 'column' => 'id')),
      'updated_by'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ArticleUpdatedBy'), 'column' => 'id')),
      'locked_by'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'slug'                => new sfValidatorPass(array('required' => false)),
      'article_labels_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LyraLabel', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lyra_article_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

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
      'ctype_id'            => 'ForeignKey',
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
      'created_by'          => 'ForeignKey',
      'updated_by'          => 'ForeignKey',
      'locked_by'           => 'Number',
      'created_at'          => 'Date',
      'updated_at'          => 'Date',
      'slug'                => 'Text',
      'article_labels_list' => 'ManyKey',
    );
  }
}
